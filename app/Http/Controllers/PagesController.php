<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PagesController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function home(): View
    {
        // Get upcoming events for home page
        $events = $this->getUpcomingEvents();

        return view('main.home.home', [
            'upcomingEvents' => $events
        ]);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function about(): View
    {
        return view('main.about.index');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function contactUs(): View
    {
        return view('main.contact-us.index');
    }

    /**
     * Handle contact form submission
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submitContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'nullable|string|max:30',
            'message' => 'required|string|max:2000',
            'agree_to_policies' => 'accepted',
        ]);

        // TODO: Here you can send email, save to database, etc.
        // For now, we'll just log it and redirect back with success message

        Log::info('Contact form submission', $validated);

        return redirect()->back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }

    /**
     * Get upcoming events from API
     *
     * @param int $limit
     * @return array
     */
    private function getUpcomingEvents(int $limit = 30): array
    {
        try {
            $apiKey = config('services.master_event.key');
            $today = Carbon::today()->format('Y-m-d');

            $response = Http::withOptions([
                'verify' => false
            ])->withHeaders([
                'X-MasterEvent-Key' => $apiKey
            ])->get('https://old.sviato.academy/wp-json/master-event/v1/feed', [
                'page' => 1,
                'per_page' => $limit,
                'date_from' => $today,
                'sort_by' => 'date',
                'sort_order' => 'ASC',
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $events = $data['data'] ?? [];

                return array_slice($events, 0, $limit);
            }
        } catch (\Exception $e) {
            Log::error('Failed to fetch events for home page', [
                'message' => $e->getMessage()
            ]);
        }

        return [];
    }
}
