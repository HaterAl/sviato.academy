<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class CommunityController extends Controller
{
    /**
     * Display a listing of community members (masters).
     */
    public function index(Request $request)
    {
        // Set SEO title and description
        app('seo')->setTitle('Sviato Community | Sviato Academy')
            ->setDescription('Meet our talented masters from around the world. Join our community of professional PMU artists.');

        // Get request parameters
        $page = $request->query('page', 1);
        $memberType = $request->input('member_type', '');
        $location = $request->input('location', '');

        // Create unique cache key based on request parameters
        $cacheKey = 'community_' . md5($page . '_' . $memberType . '_' . $location);
        $cacheTtl = config('cache.ttl', 10);

        // Cache for configured TTL (default 10 minutes)
        $result = Cache::remember($cacheKey, 60 * $cacheTtl, function () use ($request, $page, $memberType, $location) {
            try {
                $apiKey = config('services.master_event.key');

                $params = [
                    'page' => $page,
                    'per_page' => 16,
                    'post_type' => 'member',
                ];

                // Apply member_type filter only if specified
                if (!empty($memberType)) {
                    $params['member_type'] = $memberType;
                }

                // Apply location filter
                if (!empty($location)) {
                    $params['location'] = $location;
                }

                $apiUrl = config('services.master_event.api_url');

                $response = Http::withOptions([
                    'verify' => false // Disable SSL verification for local development
                ])->withHeaders([
                    'X-MasterEvent-Key' => $apiKey
                ])->get("{$apiUrl}/feed", $params);

                if ($response->successful()) {
                    $data = $response->json();
                    return [
                        'members' => $data['data'] ?? [],
                        'pagination' => $data['pagination'] ?? [],
                    ];
                } else {
                    Log::error('Community API request failed', [
                        'status' => $response->status()
                    ]);
                    return [
                        'members' => [],
                        'pagination' => [],
                    ];
                }
            } catch (\Exception $e) {
                Log::error('Community API exception', [
                    'message' => $e->getMessage()
                ]);
                return [
                    'members' => [],
                    'pagination' => [],
                ];
            }
        });

        // Return view with data for initial page load
        return view('main.community.index', [
            'members' => $result['members'],
            'pagination' => $result['pagination'],
            'currentMemberType' => $memberType
        ]);
    }

    /**
     * API endpoint for community members data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiIndex(Request $request)
    {
        // Get request parameters
        $page = $request->query('page', 1);
        $memberType = $request->input('member_type', '');
        $location = $request->input('location', '');

        // Create unique cache key based on request parameters
        $cacheKey = 'community_' . md5($page . '_' . $memberType . '_' . $location);
        $cacheTtl = config('cache.ttl', 10);

        // Cache for configured TTL (default 10 minutes)
        $result = Cache::remember($cacheKey, 60 * $cacheTtl, function () use ($request, $page, $memberType, $location) {
            try {
                $apiKey = config('services.master_event.key');

                $params = [
                    'page' => $page,
                    'per_page' => 16,
                    'post_type' => 'member',
                ];

                // Apply member_type filter only if specified
                if (!empty($memberType)) {
                    $params['member_type'] = $memberType;
                }

                // Apply location filter
                if (!empty($location)) {
                    $params['location'] = $location;
                }

                $apiUrl = config('services.master_event.api_url');

                $response = Http::withOptions([
                    'verify' => false // Disable SSL verification for local development
                ])->withHeaders([
                    'X-MasterEvent-Key' => $apiKey
                ])->get("{$apiUrl}/feed", $params);

                if ($response->successful()) {
                    $data = $response->json();
                    return [
                        'members' => $data['data'] ?? [],
                        'pagination' => $data['pagination'] ?? [],
                    ];
                } else {
                    Log::error('Community API request failed', [
                        'status' => $response->status()
                    ]);
                    return [
                        'members' => [],
                        'pagination' => [],
                    ];
                }
            } catch (\Exception $e) {
                Log::error('Community API exception', [
                    'message' => $e->getMessage()
                ]);
                return [
                    'members' => [],
                    'pagination' => [],
                ];
            }
        });

        return response()->json([
            'members' => $result['members'],
            'pagination' => $result['pagination'],
            'member_type' => $memberType
        ]);
    }
}
