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
     * Display products page
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Set SEO title and description
        app('seo')->setTitle('Our Products | Sviato Academy')
            ->setDescription('Discover our premium selection of professional PMU products and supplies.');

        $page = (int)$request->get('page', 1);
        $category = $request->get('category', 'all');

        // Create unique cache key for this page and category combination
        $cacheKey = 'products_page_' . $page . '_cat_' . $category;
        $cacheTtl = config('cache.ttl', 10);

        // Cache for configured TTL (default 10 minutes)
        $result = Cache::remember($cacheKey, 60 * $cacheTtl, function () use ($page, $category) {
            return $this->getProducts($page, $category);
        });

        // Return view with data for initial page load
        return view('main.products.index', [
            'products' => $result['products'],
            'pagination' => $result['pagination']
        ]);
    }

    /**
     * API endpoint for products data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiIndex(Request $request)
    {
        $page = (int)$request->get('page', 1);
        $category = $request->get('category', 'all');

        // Create unique cache key for this page and category combination
        $cacheKey = 'products_page_' . $page . '_cat_' . $category;
        $cacheTtl = config('cache.ttl', 10);

        // Cache for configured TTL (default 10 minutes)
        $result = Cache::remember($cacheKey, 60 * $cacheTtl, function () use ($page, $category) {
            return $this->getProducts($page, $category);
        });

        return response()->json($result);
    }

    /**
     * Get products from Magento 2 REST API with pagination and category filter
     *
     * @param int $page
     * @param string $category
     * @return array
     */
    private function getProducts(int $page = 1, string $category = 'all'): array
    {
        try {
            $apiUrl = config('services.magento.api_url');
            $accessToken = config('services.magento.access_token');
            $perPage = 20;

            // Category mapping
            $categoryMapping = [
                'kits' => 35,
                'training' => 23,
                'treatment tools' => 22,
                'aftercare products' => 20,
                'microblading blades & tools' => 19,
                'pigments' => 11,
                'pmu cartridges' => 8,
                'removal products' => 21,
                'machines' => 25,
                'sale' => 50,
            ];

            // All allowed category IDs
            $allowedCategoryIds = [35, 23, 22, 20, 19, 11, 8, 21, 25, 50];

            // Build filter params
            $params = [
                'searchCriteria[pageSize]' => $perPage,
                'searchCriteria[currentPage]' => $page,
                // Filter Group 0: Only enabled products
                'searchCriteria[filterGroups][0][filters][0][field]' => 'status',
                'searchCriteria[filterGroups][0][filters][0][value]' => '1',
                'searchCriteria[filterGroups][0][filters][0][conditionType]' => 'eq',
                // Filter Group 1: Only simple products
                'searchCriteria[filterGroups][1][filters][0][field]' => 'type_id',
                'searchCriteria[filterGroups][1][filters][0][value]' => 'simple',
                'searchCriteria[filterGroups][1][filters][0][conditionType]' => 'eq',
                // Filter Group 3: Visibility - only catalog visible (2 = Catalog, 4 = Catalog + Search)
                'searchCriteria[filterGroups][3][filters][0][field]' => 'visibility',
                'searchCriteria[filterGroups][3][filters][0][value]' => '2,4',
                'searchCriteria[filterGroups][3][filters][0][conditionType]' => 'in',
            ];

            // Filter Group 2: Category IDs
            if ($category !== 'all' && isset($categoryMapping[$category])) {
                // Filter by specific category
                $params['searchCriteria[filterGroups][2][filters][0][field]'] = 'category_id';
                $params['searchCriteria[filterGroups][2][filters][0][value]'] = $categoryMapping[$category];
                $params['searchCriteria[filterGroups][2][filters][0][conditionType]'] = 'eq';
            } else {
                // Filter by all allowed categories
                $params['searchCriteria[filterGroups][2][filters][0][field]'] = 'category_id';
                $params['searchCriteria[filterGroups][2][filters][0][value]'] = implode(',', $allowedCategoryIds);
                $params['searchCriteria[filterGroups][2][filters][0][conditionType]'] = 'in';
            }

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
                    Log::error('Invalid Magento API response structure');
                    return [
                        'products' => [],
                        'pagination' => [
                            'page' => $page,
                            'per_page' => $perPage,
                            'total' => 0,
                            'total_pages' => 0
                        ]
                    ];
                }

                $baseUrl = rtrim(config('services.magento.api_url'), '/rest/V1/');
                $products = [];

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
                    $productCategory = $this->getCategoryName($item);

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

                    // Build product URL
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

                    $products[] = [
                        'id' => (string)$item['id'],
                        'title' => $item['name'],
                        'description' => strip_tags($description),
                        'link' => $link,
                        'image' => $image,
                        'price' => $price,
                        'sale_price' => $salePrice,
                        'availability' => $availability,
                        'brand' => $brand,
                        'category' => $productCategory,
                    ];
                }

                // Calculate pagination
                $totalCount = $data['total_count'] ?? 0;
                $totalPages = ceil($totalCount / $perPage);

                Log::info('Fetched products from Magento', [
                    'page' => $page,
                    'category' => $category,
                    'products_count' => count($products),
                    'total_count' => $totalCount
                ]);

                return [
                    'products' => $products,
                    'pagination' => [
                        'page' => $page,
                        'per_page' => $perPage,
                        'total' => $totalCount,
                        'total_pages' => $totalPages
                    ]
                ];
            } else {
                Log::error('Failed to fetch products from Magento API', [
                    'page' => $page,
                    'category' => $category,
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to fetch products from Magento API', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }

        return [
            'products' => [],
            'pagination' => [
                'page' => $page,
                'per_page' => 20,
                'total' => 0,
                'total_pages' => 0
            ]
        ];
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
            35 => 'kits',
            23 => 'training',
            22 => 'treatment tools',
            20 => 'aftercare products',
            19 => 'microblading blades & tools',
            11 => 'pigments',
            8 => 'pmu cartridges',
            21 => 'removal products',
            25 => 'machines',
            50 => 'sale',
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
