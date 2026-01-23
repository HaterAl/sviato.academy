<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // Set SEO title and description
        app('seo')->setTitle('Our Products | Sviato Academy')
            ->setDescription('Discover our premium selection of professional PMU products and supplies.');

        // Return JSON if requested via AJAX
        if ($request->ajax()) {
            // Cache products for 24 hours (1440 minutes)
            $products = Cache::remember('magento_products', 60 * 24, function () {
                return $this->getProducts();
            });

            // Category filtering
            $category = $request->get('category');
            if ($category && $category !== 'all') {
                $products = array_filter($products, function($product) use ($category) {
                    return $product['category'] === $category;
                });
                $products = array_values($products);
            }

            $perPage = 20;
            $page = $request->get('page', 1);

            // Calculate pagination
            $total = count($products);
            $totalPages = ceil($total / $perPage);
            $offset = ($page - 1) * $perPage;

            // Get products for current page
            $productsForPage = array_slice($products, $offset, $perPage);

            $pagination = [
                'page' => (int)$page,
                'per_page' => $perPage,
                'total' => $total,
                'total_pages' => $totalPages
            ];

            return response()->json([
                'products' => $productsForPage,
                'pagination' => $pagination
            ]);
        }

        // Return empty view for initial page load - data will be loaded via AJAX
        return view('main.products.index', [
            'products' => [],
            'pagination' => []
        ]);
    }

    /**
     * Get products from Magento 2 REST API with pagination
     *
     * @return array
     */
    private function getProducts(): array
    {
        try {
            $apiUrl = config('services.magento.api_url');
            $accessToken = config('services.magento.access_token');

            // Allowed category IDs (excluding Sviato Collection)
            $allowedCategoryIds = [
                35, // Kits
                23, // Training
                22, // Treatment Tools
                20, // Aftercare Products
                19, // Microblading Blades & Tools
                11, // Pigments
                8,  // PMU Cartridges
                21, // Removal products
                25, // Machines
                50, // SALE!
            ];

            $allProducts = [];
            $pageSize = 100; // Request 100 products per page
            $currentPage = 1;
            $totalPages = 1;

            // Fetch products page by page
            do {
                // Build filter params
                $params = [
                    'searchCriteria[pageSize]' => $pageSize,
                    'searchCriteria[currentPage]' => $currentPage,
                    // Filter Group 0: Only enabled products
                    'searchCriteria[filterGroups][0][filters][0][field]' => 'status',
                    'searchCriteria[filterGroups][0][filters][0][value]' => '1',
                    'searchCriteria[filterGroups][0][filters][0][conditionType]' => 'eq',
                    // Filter Group 1: Only simple products
                    'searchCriteria[filterGroups][1][filters][0][field]' => 'type_id',
                    'searchCriteria[filterGroups][1][filters][0][value]' => 'simple',
                    'searchCriteria[filterGroups][1][filters][0][conditionType]' => 'eq',
                    // Filter Group 2: Category IDs (using 'in' condition)
                    'searchCriteria[filterGroups][2][filters][0][field]' => 'category_id',
                    'searchCriteria[filterGroups][2][filters][0][value]' => implode(',', $allowedCategoryIds),
                    'searchCriteria[filterGroups][2][filters][0][conditionType]' => 'in',
                    // Filter Group 3: Visibility - only catalog visible (2 = Catalog, 4 = Catalog + Search)
                    'searchCriteria[filterGroups][3][filters][0][field]' => 'visibility',
                    'searchCriteria[filterGroups][3][filters][0][value]' => '2,4',
                    'searchCriteria[filterGroups][3][filters][0][conditionType]' => 'in',
                ];

                $response = Http::withOptions([
                    'verify' => false
                ])
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json',
                ])
                ->get($apiUrl . 'products', $params);

                if ($response->successful()) {
                    // Remove UTF-8 BOM if present
                    $body = $response->body();
                    $body = preg_replace('/^\xEF\xBB\xBF/', '', $body);
                    $data = json_decode($body, true);

                    if (!isset($data['items'])) {
                        Log::error('Invalid Magento API response structure', [
                            'page' => $currentPage
                        ]);
                        break;
                    }

                    // Calculate total pages on first request
                    if ($currentPage === 1 && isset($data['total_count'])) {
                        $totalPages = ceil($data['total_count'] / $pageSize);
                        Log::info('Fetching products from Magento', [
                            'total_count' => $data['total_count'],
                            'total_pages' => $totalPages,
                            'page_size' => $pageSize
                        ]);
                    }

                    // Process products from this page
                    $baseUrl = rtrim(config('services.magento.api_url'), '/rest/V1/');

                    foreach ($data['items'] as $item) {
                        // Skip products without name or sku
                        if (empty($item['name']) || empty($item['sku'])) {
                            continue;
                        }

                        // Get custom attributes helper function
                        $getCustomAttribute = function($attributes, $code, $default = '') {
                            foreach ($attributes as $attr) {
                                if ($attr['attribute_code'] === $code) {
                                    return $attr['value'] ?? $default;
                                }
                            }
                            return $default;
                        };

                        $customAttributes = $item['custom_attributes'] ?? [];

                        // Get category names from category_ids
                        $category = $this->getCategoryName($item);

                        // Get main image
                        $image = '';
                        if (!empty($item['media_gallery_entries'])) {
                            foreach ($item['media_gallery_entries'] as $media) {
                                if (isset($media['types']) && in_array('image', $media['types'])) {
                                    $image = $baseUrl . '/media/catalog/product' . $media['file'];
                                    break;
                                }
                            }
                        }

                        // Get description
                        $description = $getCustomAttribute($customAttributes, 'description');
                        if (empty($description)) {
                            $description = $getCustomAttribute($customAttributes, 'short_description');
                        }

                        // Build product URL (without .html)
                        $urlKey = $getCustomAttribute($customAttributes, 'url_key');
                        $link = !empty($urlKey) ? $baseUrl . '/' . $urlKey : $baseUrl . '/catalog/product/view/id/' . $item['id'];

                        // Get special price if available
                        $specialPrice = $getCustomAttribute($customAttributes, 'special_price');
                        $salePrice = !empty($specialPrice) ? number_format((float)$specialPrice, 2) . ' €' : '';

                        // Format regular price
                        $price = isset($item['price']) ? number_format((float)$item['price'], 2) . ' €' : '';

                        // Determine availability
                        $availability = 'in stock';
                        if (isset($item['extension_attributes']['stock_item'])) {
                            $stockItem = $item['extension_attributes']['stock_item'];
                            if (!$stockItem['is_in_stock'] || $stockItem['qty'] <= 0) {
                                $availability = 'out of stock';
                            }
                        }

                        // Get brand
                        $brand = $getCustomAttribute($customAttributes, 'manufacturer');
                        if (empty($brand)) {
                            $brand = $getCustomAttribute($customAttributes, 'brand', 'Sviato');
                        }

                        $allProducts[] = [
                            'id' => (string)$item['id'],
                            'title' => $item['name'],
                            'description' => strip_tags($description),
                            'link' => $link,
                            'image' => $image,
                            'price' => $price,
                            'sale_price' => $salePrice,
                            'availability' => $availability,
                            'brand' => $brand,
                            'category' => $category,
                        ];
                    }

                    // Move to next page
                    $currentPage++;
                } else {
                    Log::error('Failed to fetch products from Magento API', [
                        'page' => $currentPage,
                        'status' => $response->status(),
                        'body' => $response->body()
                    ]);
                    break;
                }
            } while ($currentPage <= $totalPages);

            Log::info('Successfully fetched products from Magento', [
                'total_products' => count($allProducts),
                'pages_fetched' => $currentPage - 1
            ]);

            return $allProducts;
        } catch (\Exception $e) {
            Log::error('Failed to fetch products from Magento API', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }

        return [];
    }

    /**
     * Get category name from product data
     *
     * @param array $product
     * @return string
     */
    private function getCategoryName(array $product): string
    {
        // Main category mapping (level 2, excluding Sviato Collection)
        $categoryMapping = [
            35 => 'Kits',
            23 => 'Training',
            22 => 'Treatment Tools',
            20 => 'Aftercare Products',
            19 => 'Microblading Blades & Tools',
            11 => 'Pigments',
            8 => 'PMU Cartridges',
            21 => 'Removal products',
            25 => 'Machines',
            50 => 'SALE!',
        ];

        // Subcategory to main category mapping (level 3 -> level 2)
        $subcategoryMapping = [
            // Kits subcategories
            36 => 35, 37 => 35,
            // Training subcategories
            32 => 23, 33 => 23, 34 => 23,
            // Treatment Tools subcategories
            44 => 22, 45 => 22,
            // Pigments subcategories
            12 => 11, 15 => 11, 16 => 11, 17 => 11, 58 => 11, 59 => 11,
            // PMU Cartridges subcategories
            9 => 8, 10 => 8, 29 => 8,
            // Removal products subcategories
            30 => 21, 31 => 21,
            // Machines subcategories
            26 => 25, 27 => 25, 28 => 25,
        ];

        $allCategoryIds = [];

        // Try to get category from extension_attributes first
        if (isset($product['extension_attributes']['category_links'])) {
            foreach ($product['extension_attributes']['category_links'] as $link) {
                $allCategoryIds[] = (int)$link['category_id'];
            }
        }

        // Try to get category from custom attributes
        $customAttributes = $product['custom_attributes'] ?? [];
        foreach ($customAttributes as $attr) {
            if ($attr['attribute_code'] === 'category_ids' && !empty($attr['value'])) {
                $categoryIds = is_array($attr['value']) ? $attr['value'] : explode(',', $attr['value']);
                foreach ($categoryIds as $id) {
                    $allCategoryIds[] = (int)$id;
                }
            }
        }

        // Remove duplicates and root categories
        $allCategoryIds = array_unique($allCategoryIds);
        $allCategoryIds = array_filter($allCategoryIds, function($id) {
            return $id > 2;
        });

        // Find main category (prioritize level 2 categories)
        foreach ($allCategoryIds as $categoryId) {
            if (isset($categoryMapping[$categoryId])) {
                return $categoryMapping[$categoryId];
            }
        }

        // Check if product is in subcategory and map to main category
        foreach ($allCategoryIds as $categoryId) {
            if (isset($subcategoryMapping[$categoryId])) {
                $mainCategoryId = $subcategoryMapping[$categoryId];
                if (isset($categoryMapping[$mainCategoryId])) {
                    return $categoryMapping[$mainCategoryId];
                }
            }
        }

        return 'Uncategorized';
    }
}
