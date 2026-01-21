<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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

        // Return JSON if requested via AJAX
        if ($request->ajax()) {
            $page = $request->query('page', 1);

            try {
                $apiKey = config('services.master_event.key');

                $params = [
                    'page' => $page,
                    'per_page' => 16,
                    'post_type' => 'member',
                ];

                // Apply member_type filter only if specified
                if ($request->has('member_type') && !empty($request->member_type)) {
                    $params['member_type'] = $request->member_type;
                }

                // Apply location filter
                if ($request->has('location') && !empty($request->location)) {
                    $params['location'] = $request->location;
                }

                $apiUrl = config('services.master_event.api_url');

                $response = Http::withOptions([
                    'verify' => false // Disable SSL verification for local development
                ])->withHeaders([
                            'X-MasterEvent-Key' => $apiKey
                        ])->get("{$apiUrl}/feed", $params);

                if ($response->successful()) {
                    $data = $response->json();
                    $members = $data['data'] ?? [];
                    $pagination = $data['pagination'] ?? [];
                } else {
                    Log::error('Community API request failed', [
                        'status' => $response->status()
                    ]);
                    $members = [];
                    $pagination = [];
                }
            } catch (\Exception $e) {
                Log::error('Community API exception', [
                    'message' => $e->getMessage()
                ]);
                $members = [];
                $pagination = [];
            }

            // Get current member_type for display
            $currentMemberType = $request->input('member_type', '');

            return response()->json([
                'members' => $members,
                'pagination' => $pagination,
                'member_type' => $currentMemberType
            ])
                ->header('Vary', 'X-Requested-With')
                ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0, post-check=0, pre-check=0')
                ->header('Pragma', 'no-cache')
                ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
        }

        // Return empty view for initial page load - data will be loaded via AJAX
        return view('main.community.index', [
            'members' => [],
            'pagination' => [],
            'currentMemberType' => ''
        ]);
    }
}
