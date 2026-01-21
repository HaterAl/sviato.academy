<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MapController extends Controller
{
    /**
     * Display the Sviato Map with all trainers.
     */
    public function index(Request $request)
    {
        // Set SEO title and description
        app('seo')->setTitle('Sviato Map | Sviato Academy')
            ->setDescription('Find Sviato Academy trainers and masters around the world on our interactive map.');

        // Return JSON if requested via AJAX
        if ($request->ajax()) {
            try {
                $apiKey = config('services.master_event.key');
                $apiUrl = config('services.master_event.api_url');

                // First, get total_items count
                $initialResponse = Http::withOptions([
                    'verify' => false
                ])->withHeaders([
                    'X-MasterEvent-Key' => $apiKey
                ])->get("{$apiUrl}/feed", [
                    'post_type' => 'member',
                    'page' => 1,
                    'per_page' => 1,
                ]);

                if (!$initialResponse->successful()) {
                    Log::error('Map API initial request failed', [
                        'status' => $initialResponse->status()
                    ]);
                    return response()->json([
                        'success' => false,
                        'members' => []
                    ]);
                }

                $initialData = $initialResponse->json();
                $totalItems = $initialData['pagination']['total_items'] ?? 0;

                // Now fetch all members at once
                $response = Http::withOptions([
                    'verify' => false
                ])->withHeaders([
                    'X-MasterEvent-Key' => $apiKey
                ])->get("{$apiUrl}/feed", [
                    'post_type' => 'member',
                    'page' => 1,
                    'per_page' => $totalItems,
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    $members = $data['data'] ?? [];

                    // Filter members to only include those with valid coordinates
                    $membersWithCoordinates = array_filter($members, function ($member) {
                        return isset($member['acf_fields']['location']['lat'])
                            && isset($member['acf_fields']['location']['lng'])
                            && !empty($member['acf_fields']['location']['lat'])
                            && !empty($member['acf_fields']['location']['lng']);
                    });

                    return response()->json([
                        'success' => true,
                        'members' => array_values($membersWithCoordinates)
                    ]);
                } else {
                    Log::error('Map API request failed', [
                        'status' => $response->status()
                    ]);
                    return response()->json([
                        'success' => false,
                        'members' => []
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Map API exception', [
                    'message' => $e->getMessage()
                ]);
                return response()->json([
                    'success' => false,
                    'members' => []
                ]);
            }
        }

        // Return view for initial page load
        return view('main.map.index');
    }
}
