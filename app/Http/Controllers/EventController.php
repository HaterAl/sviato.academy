<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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
        // Return JSON if requested via AJAX
        if ($request->wantsJson() || $request->ajax()) {
            $page = $request->query('page', 1);

            try {
                $apiKey = config('services.master_event.key');
                $today = Carbon::today()->format('Y-m-d');

                $params = [
                    'page' => $page,
                    'per_page' => 9,
                    'date_from' =>  $today, 
                    'sort_by' => 'date',
                    'sort_order' => 'ASC',
                ];

                // Apply location filter
                if ($request->has('location') && !empty($request->location)) {
                    $params['location'] = $request->location;
                }

                // Apply month filter
                if ($request->has('month') && !empty($request->month)) {
                    $monthDate = Carbon::createFromFormat('Y-m', $request->month);
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
                if ($request->has('technique') && !empty($request->technique)) {
                    $params['technique'] = $request->technique;
                }

                $response = Http::withOptions([
                    'verify' => false // Disable SSL verification for local development
                ])->withHeaders([
                    'X-MasterEvent-Key' => $apiKey
                ])->get('https://old.sviato.academy/wp-json/master-event/v1/feed', $params);

                if ($response->successful()) {
                    $data = $response->json();
                    $events = $data['data'] ?? [];
                    $pagination = $data['pagination'] ?? [];
                } else {
                    Log::error('Events API request failed', [
                        'status' => $response->status()
                    ]);
                    $events = [];
                    $pagination = [];
                }
            } catch (\Exception $e) {
                Log::error('Events API exception', [
                    'message' => $e->getMessage()
                ]);
                $events = [];
                $pagination = [];
            }

            return response()->json([
                'events' => $events,
                'pagination' => $pagination
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

            $response = Http::withOptions([
                'verify' => false
            ])->withHeaders([
                'X-MasterEvent-Key' => $apiKey
            ])->get("https://old.sviato.academy/wp-json/master-event/v1/feed/{$eventId}");

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
