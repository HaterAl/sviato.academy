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

                $response = Http::withOptions([
                    'verify' => false // Disable SSL verification for local development
                ])->withHeaders([
                    'X-MasterEvent-Key' => $apiKey
                ])->get('https://old.sviato.academy/wp-json/master-event/v1/feed', $params);

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
            ]);
        }

        // Return empty view for initial page load - data will be loaded via AJAX
        return view('main.community.index', [
            'members' => [],
            'pagination' => [],
            'currentMemberType' => ''
        ]);
    }
}
