<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
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
        // Set SEO title and description
        app('seo')->setTitle('About Us | Sviato Academy')
            ->setDescription('Learn about Sviato Academy, a world-class permanent make-up training institution founded by Sviatoslav Otchenash.');

        return view('main.about.index');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function contactUs(): View
    {
        // Set SEO title and description
        app('seo')->setTitle('Contact Us | Sviato Academy')
            ->setDescription('Get in touch with Sviato Academy. Contact us for inquiries about our permanent make-up training courses and programs.');

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
     * Show certificate checker page and handle validation
     *
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function certificateChecker(Request $request)
    {
        // Set SEO title and description
        app('seo')->setTitle('Certificate Checker | Sviato Academy')
            ->setDescription('Verify your Sviato Academy certificate authenticity.');

        // Handle AJAX request for certificate validation
        if ($request->ajax() && $request->has('cert')) {
            $validated = $request->validate([
                'cert' => 'required|string',
            ]);

            try {
                $apiKey = config('services.master_event.key');
                $apiUrl = config('services.master_event.api_url');

                $response = Http::withOptions([
                    'verify' => false
                ])->withHeaders([
                    'X-MasterEvent-Key' => $apiKey
                ])->get("{$apiUrl}/validate-certificate", [
                    'cert' => $validated['cert']
                ]);

                if ($response->successful()) {
                    $data = $response->json();

                    // Mask last name if member name exists
                    if (isset($data['member']['name'])) {
                        $data['member']['name'] = $this->maskLastName($data['member']['name']);
                    }

                    return response()->json($data);
                }

                return response()->json([
                    'error' => 'Failed to validate certificate'
                ], $response->status());

            } catch (\Exception $e) {
                Log::error('Certificate validation failed', [
                    'message' => $e->getMessage(),
                    'cert' => $validated['cert']
                ]);

                return response()->json([
                    'error' => 'An error occurred while validating the certificate'
                ], 500);
            }
        }

        return view('main.certificate-checker.index');
    }

    /**
     * Mask last name in full name
     *
     * @param string $fullName
     * @return string
     */
    private function maskLastName(string $fullName): string
    {
        $parts = explode(' ', $fullName);

        if (count($parts) > 1) {
            $lastName = array_pop($parts);
            $maskedLastName = mb_substr($lastName, 0, 1) . str_repeat('*', mb_strlen($lastName) - 1);
            $parts[] = $maskedLastName;
            return implode(' ', $parts);
        }

        return $fullName;
    }

    /**
     * Get upcoming events from API
     *
     * @param int $limit
     * @return array
     */
    private function getUpcomingEvents(int $limit = 30): array
    {
        $today = Carbon::today()->format('Y-m-d');
        $cacheKey = 'home_events_' . $today . '_' . $limit;
        $cacheTtl = config('cache.ttl', 10);

        return Cache::remember($cacheKey, 60 * $cacheTtl, function () use ($limit, $today) {
            try {
                $apiKey = config('services.master_event.key');
                $apiUrl = config('services.master_event.api_url');

                $response = Http::withOptions([
                    'verify' => false
                ])->withHeaders([
                    'X-MasterEvent-Key' => $apiKey
                ])->get("{$apiUrl}/feed", [
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
        });
    }
}
