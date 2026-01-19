<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // Return JSON if requested via AJAX
        if ($request->wantsJson() || $request->ajax()) {
            $products = $this->getProducts();
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
     * Get products from XML feed
     *
     * @return array
     */
    private function getProducts(): array
    {
        try {
            $response = Http::withOptions([
                'verify' => false
            ])->get('https://sviato.shop/media/googlefeed/products.xml');

            if ($response->successful()) {
                $xml = simplexml_load_string($response->body());

                if ($xml === false) {
                    Log::error('Failed to parse products XML');
                    return [];
                }

                $products = [];

                // Register the Google namespace
                $xml->registerXPathNamespace('g', 'http://base.google.com/ns/1.0');

                foreach ($xml->channel->item as $item) {
                    $products[] = [
                        'id' => (string)$item->children('g', true)->id,
                        'title' => (string)$item->children('g', true)->title,
                        'description' => (string)$item->children('g', true)->description,
                        'link' => (string)$item->children('g', true)->link,
                        'image' => (string)$item->children('g', true)->image_link,
                        'price' => (string)$item->children('g', true)->price,
                        'sale_price' => (string)$item->children('g', true)->sale_price,
                        'availability' => (string)$item->children('g', true)->availability,
                        'brand' => (string)$item->children('g', true)->brand,
                        'category' => (string)$item->children('g', true)->product_type,
                    ];
                }

                return $products;
            }
        } catch (\Exception $e) {
            Log::error('Failed to fetch products XML', [
                'message' => $e->getMessage()
            ]);
        }

        return [];
    }
}
