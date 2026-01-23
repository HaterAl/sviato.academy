<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Carbon\Carbon;

class EventController extends Controller
{
    /**
     * Display a listing of events.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Set SEO title and description
        app('seo')->setTitle('Upcoming Events | Sviato Academy')
            ->setDescription('Browse upcoming events and training courses from Sviato Academy. Join our world-class trainers and expand your professional skills.');

        // Return JSON if requested via AJAX
        if ($request->ajax()) {
            $page = $request->query('page', 1);
            $location = $request->input('location', '');
            $month = $request->input('month', '');
            $technique = $request->input('technique', '');
            $today = Carbon::today()->format('Y-m-d');

            // Create unique cache key based on request parameters
            $cacheKey = 'events_' . md5($page . '_' . $location . '_' . $month . '_' . $technique . '_' . $today);

            // Cache for 10 minutes
            $result = Cache::remember($cacheKey, 60 * 10, function () use ($page, $location, $month, $technique, $today) {
                try {
                    $apiKey = config('services.master_event.key');

                    $params = [
                        'page' => $page,
                        'per_page' => 8,
                        'date_from' => $today,
                        'sort_by' => 'date',
                        'sort_order' => 'ASC',
                    ];

                    // Apply location filter
                    if (!empty($location)) {
                        $params['location'] = $location;
                    }

                    // Apply month filter
                    if (!empty($month)) {
                        $monthDate = Carbon::createFromFormat('Y-m', $month);
                        $monthStart = $monthDate->startOfMonth()->format('Y-m-d');
                        $monthEnd = $monthDate->endOfMonth()->format('Y-m-d');

                        // Only apply month filter if the month is in the future or current
                        if ($monthEnd >= $today) {
                            // If month start is in the past, use today as start date
                            $params['date_from'] = max($monthStart, $today);
                            $params['date_to'] = $monthEnd;
                        }
                    }

                    // Apply technique filter
                    if (!empty($technique)) {
                        $params['technique'] = $technique;
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
                            'events' => $data['data'] ?? [],
                            'pagination' => $data['pagination'] ?? [],
                        ];
                    } else {
                        Log::error('Events API request failed', [
                            'status' => $response->status()
                        ]);
                        return [
                            'events' => [],
                            'pagination' => [],
                        ];
                    }
                } catch (\Exception $e) {
                    Log::error('Events API exception', [
                        'message' => $e->getMessage()
                    ]);
                    return [
                        'events' => [],
                        'pagination' => [],
                    ];
                }
            });

            return response()->json([
                'events' => $result['events'],
                'pagination' => $result['pagination']
            ]);
        }

        // Return empty view for initial page load - data will be loaded via AJAX
        return view('main.events.index', [
            'events' => [],
            'pagination' => []
        ]);
    }

    /**
     * Display a single event.
     *
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function show(string $slug): View
    {
        try {
            // Decode the slug to get the event ID (convert to uppercase for base64_decode)
            $eventId = base64_decode(strtoupper($slug));

            // Validate that we got a numeric ID
            if (!is_numeric($eventId)) {
                abort(404);
            }

            $apiKey = config('services.master_event.key');
            $apiUrl = config('services.master_event.api_url');

            $response = Http::withOptions([
                'verify' => false
            ])->withHeaders([
                'X-MasterEvent-Key' => $apiKey
            ])->get("{$apiUrl}/feed/{$eventId}");

            if ($response->successful()) {
                $event = $response->json();

                return view('main.events.show', [
                    'event' => $event
                ]);
            } else {
                Log::error('Event API request failed', [
                    'status' => $response->status(),
                    'id' => $eventId
                ]);
                abort(404);
            }
        } catch (\Exception $e) {
            Log::error('Event API exception', [
                'message' => $e->getMessage(),
                'slug' => $slug
            ]);
            abort(404);
        }
    }
}
