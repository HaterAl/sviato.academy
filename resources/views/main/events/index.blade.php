@extends('main.layouts.base')

@section('content')
    <section class="p-4">
        <div class="container mx-auto">
            <section class="py-12">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mb-12">
                        <h2 class="font-manrope text-center font-bold text-gray-900 mb-4 u-text--primary italic">Upcoming Events</h2>
                        <p class="text-center leading-6 mb-9"><span class="u-text--primary">Browse</span> our upcoming <span class="u-text--primary">training events</span> and <span class="u-text--primary">WorldS PMU championships</span></br></p>
                    </div>

                    <!-- Search Form -->
                    <div class="mb-8 bg-white rounded-2xl shadow-md p-6">
                        <form id="search-form">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Location -->
                                <div class="relative">
                                    <label for="location" class="block text-sm font-semibold text-gray-700 mb-2">Location</label>
                                    <div class="relative">
                                        <input type="text"
                                               id="location"
                                               name="location"
                                               value="{{ request('location') }}"
                                               placeholder="Enter city or country..."
                                               autocomplete="off"
                                               class="w-full px-4 py-2.5 pr-10 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                        <button type="button"
                                                id="clear-location"
                                                onclick="clearLocation()"
                                                class="absolute right-3 top-1/2 transform -translate-y-1/2 flex items-center justify-center text-gray-400 hover:text-gray-600 transition-colors {{ request('location') ? '' : 'hidden' }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <div id="location-suggestions" class="absolute z-50 w-full bg-white border border-gray-300 rounded-lg shadow-lg mt-1 max-h-60 overflow-y-auto hidden"></div>
                                </div>

                                <!-- Technique -->
                                <div>
                                    <label for="technique" class="block text-sm font-semibold text-gray-700 mb-2">Technique</label>
                                    <select id="technique"
                                            name="technique"
                                            onchange="loadEvents()"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-white">
                                        <option value="">All Techniques</option>
                                        <optgroup label="S-Brows">
                                            <option value="Magic Shading Technique" {{ request('technique') == 'Magic Shading Technique' ? 'selected' : '' }}>Magic Shading Technique</option>
                                            <option value="Magic Combined Technique" {{ request('technique') == 'Magic Combined Technique' ? 'selected' : '' }}>Magic Combined Technique</option>
                                            <option value="HairstrokeS Technique" {{ request('technique') == 'HairstrokeS Technique' ? 'selected' : '' }}>HairstrokeS Technique</option>
                                        </optgroup>
                                        <optgroup label="S-Eyes">
                                            <option value="Classic Eyeliner Technique" {{ request('technique') == 'Classic Eyeliner Technique' ? 'selected' : '' }}>Classic Eyeliner Technique</option>
                                            <option value="Stardust Technique" {{ request('technique') == 'Stardust Technique' ? 'selected' : '' }}>Stardust Technique</option>
                                            <option value="Soft Liner Technique" {{ request('technique') == 'Soft Liner Technique' ? 'selected' : '' }}>Soft Liner Technique</option>
                                        </optgroup>
                                        <optgroup label="S-Lips">
                                            <option value="Aquarelle Lips Technique" {{ request('technique') == 'Aquarelle Lips Technique' ? 'selected' : '' }}>Aquarelle Lips Technique</option>
                                            <option value="Dark Lips Cover" {{ request('technique') == 'Dark Lips Cover' ? 'selected' : '' }}>Dark Lips Cover</option>
                                            <option value="Superbright Shading Technique" {{ request('technique') == 'Superbright Shading Technique' ? 'selected' : '' }}>Superbright Shading Technique</option>
                                        </optgroup>
                                        <optgroup label="Other">
                                            <option value="Cover-up Technique" {{ request('technique') == 'Cover-up Technique' ? 'selected' : '' }}>Cover-up Technique</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>

            <div id="events-container">
                @if(count($events) > 0)
                <div class="grid gap-6 items-stretch" style="grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));" id="events-grid">
                    @foreach($events as $event)
                        @php
                            $masterTitle = $event['acf_fields']['master']['title'] ?? 'N/A';
                            $masterImage = !empty($event['acf_fields']['master']['featured_image_url'])
                                ? $event['acf_fields']['master']['featured_image_url']
                                : 'https://ui-avatars.com/api/?name=' . urlencode($masterTitle) . '&size=400&background=random&color=fff&bold=true&font-size=0.35';

                            // Get trainer type for logo
                            $trainerTypeSlug = $event['acf_fields']['master']['member_types'][0]['slug'] ?? 'trainer';
                            $logoMap = [
                                'top-trainer' => '/images/top_trainer_logo.png',
                                'trainer' => '/images/trainer_logo.png',
                                'master' => '/images/master_logo.png',
                            ];
                            $trainerLogo = $logoMap[$trainerTypeSlug] ?? '/images/trainer_logo.png';
                        @endphp

                        <div class="bg-white rounded-2xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl flex flex-col h-full transform hover:scale-[1.02] hover:z-10 relative">
                            <!-- Photo wrapper for badge positioning -->
                            <div class="relative">
                                <!-- Full-width square photo at top -->
                                <div class="relative aspect-square w-full overflow-hidden rounded-t-2xl">
                                    <img src="{{ $masterImage }}"
                                         alt="{{ $masterTitle }}"
                                         class="w-full h-full object-cover">
                                </div>
                                <!-- Trainer type logo badge -->
                                <div class="absolute -bottom-10 right-4 z-20 pointer-events-none select-none">
                                    <img src="{{ $trainerLogo }}" alt="Trainer" class="w-20 h-20 rounded-full shadow-lg border-2 border-white" draggable="false">
                                </div>
                            </div>

                            <div class="p-4 pt-8 flex flex-col flex-1">
                                <!-- Master name -->
                                <h3 class="font-bold text-lg text-gray-900 mb-2">{{ $masterTitle }}</h3>

                                <!-- Course/Treatment badges -->
                                <div class="flex flex-wrap gap-1 md:gap-2 mb-3">
                                    @if(!empty($event['acf_fields']['treatments']))
                                        @foreach($event['acf_fields']['treatments'] as $treatment)
                                            <span class="inline-block px-2 py-0.5 rounded text-xs font-semibold border border-purple-500 text-purple-700 bg-purple-50">
                                                #{{ str_replace(' ', '_', $treatment['title']) }}
                                            </span>
                                        @endforeach
                                    @endif
                                    @if(!empty($event['acf_fields']['course']))
                                        @foreach($event['acf_fields']['course'] as $course)
                                            <span class="inline-block px-2 py-0.5 rounded text-xs font-semibold border border-teal-500 text-teal-700 bg-teal-50">
                                                #{{ str_replace(' ', '_', $course['title']) }}
                                            </span>
                                        @endforeach
                                    @endif
                                </div>

                                <!-- Techniques -->
                                @if(!empty($event['acf_fields']['technique']))
                                    <div class="flex flex-wrap gap-1.5 mb-3">
                                        @foreach($event['acf_fields']['technique'] as $technique)
                                            <span onclick="filterByTechnique('{{ $technique }}')" class="px-2 py-0.5 text-xs font-medium text-gray-600 bg-gray-100 rounded-md cursor-pointer hover:bg-purple-100 hover:text-purple-700 transition-colors">{{ $technique }}</span>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Spacer -->
                                <div class="flex-1"></div>

                                <!-- Location -->
                                <div class="flex items-center gap-2 text-sm text-gray-500 mt-3 pt-3 border-t border-gray-100">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span onclick="filterByLocation('{{ $event['acf_fields']['location']['address'] ?? '' }}')"
                                          class="cursor-pointer hover:text-purple-600 transition-colors truncate">
                                        {{ $event['acf_fields']['location']['address'] ?? 'N/A' }}
                                    </span>
                                </div>

                                <!-- Date -->
                                <div class="flex items-center gap-2 text-sm text-gray-500 mt-2">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="font-semibold text-gray-800">{{ $event['acf_fields']['date'] ?? 'N/A' }}</span>
                                    @if(!empty($event['acf_fields']['duration']))
                                        <span class="text-gray-400">·</span>
                                        <span>{{ $event['acf_fields']['duration'] }} days</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Contact button as footer -->
                            @if(!empty($event['acf_fields']['organiser_email_1']))
                                <a href="mailto:{{ $event['acf_fields']['organiser_email_1'] }}"
                                   style="background: linear-gradient(to right, #ffda55, #ca9d00); color: rgb(12, 12, 13);"
                                   class="block w-full text-center py-4 font-bold text-sm shadow-lg hover:shadow-xl transition-all duration-300">
                                    Contact Organizer
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>

                @if(!empty($pagination) && $pagination['total_pages'] > 1)
                    <div class="mt-12 flex justify-center items-center gap-4">
                        @if($pagination['page'] > 1)
                            <button onclick="loadEvents({{ $pagination['page'] - 1 }})"
                                    class="py-2.5 px-5 bg-gray-600 shadow-sm rounded-2xl transition-all duration-500 text-base text-white font-semibold text-center hover:bg-gray-700">
                                Previous
                            </button>
                        @endif

                        <span class="text-gray-700 font-semibold">
                            Page {{ $pagination['page'] }} of {{ $pagination['total_pages'] }}
                        </span>

                        @if($pagination['page'] < $pagination['total_pages'])
                            <button onclick="loadEvents({{ $pagination['page'] + 1 }})"
                                    class="py-2.5 px-5 bg-gray-600 shadow-sm rounded-2xl transition-all duration-500 text-base text-white font-semibold text-center hover:bg-gray-700">
                                Next
                            </button>
                        @endif
                    </div>
                @endif
            @else
                <!-- Skeleton Loader -->
                <div id="events-skeleton" class="grid gap-6 items-stretch" style="grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));">
                    @for ($i = 0; $i < 8; $i++)
                        <div class="bg-white rounded-2xl shadow-md overflow-hidden flex flex-col h-full animate-pulse">
                            <!-- Image skeleton with logo placeholder -->
                            <div class="relative">
                                <div class="aspect-square bg-gray-200"></div>
                                <div class="absolute -bottom-10 right-4 w-20 h-20 bg-gray-300 rounded-full"></div>
                            </div>

                            <div class="p-4 pt-8 flex flex-col flex-1">
                                <!-- Name skeleton -->
                                <div class="h-6 bg-gray-200 rounded w-3/4 mb-3"></div>

                                <!-- Badges skeleton -->
                                <div class="flex flex-wrap gap-1 mb-3">
                                    <div class="h-5 w-20 bg-gray-100 rounded"></div>
                                    <div class="h-5 w-24 bg-gray-100 rounded"></div>
                                </div>

                                <!-- Techniques skeleton -->
                                <div class="flex flex-wrap gap-1.5 mb-3">
                                    <div class="h-5 w-28 bg-gray-100 rounded"></div>
                                </div>

                                <div class="flex-1"></div>

                                <!-- Location skeleton -->
                                <div class="pt-3 border-t border-gray-100">
                                    <div class="h-4 bg-gray-100 rounded w-3/4 mb-2"></div>
                                    <div class="h-4 bg-gray-100 rounded w-1/2"></div>
                                </div>
                            </div>

                            <!-- Button skeleton -->
                            <div class="h-12 bg-gray-200"></div>
                        </div>
                    @endfor
                </div>
            @endif
            </div>
                </div>
            </section>
        </div>
    </section>

    <script>
        // Load events via AJAX
        async function loadEvents(page = 1) {
            const locationInput = document.getElementById('location');
            const techniqueSelect = document.getElementById('technique');
            const clearBtn = document.getElementById('clear-location');
            const container = document.getElementById('events-container');

            // Scroll to container with offset
            const containerRect = container.getBoundingClientRect();
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            const targetPosition = containerRect.top + scrollTop - 100; // 100px above the container

            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });

            container.style.filter = 'blur(3px)';
            container.style.pointerEvents = 'none';
            container.style.opacity = '0.6';
            container.style.transition = 'filter 0.2s ease, opacity 0.2s ease';

            // Build query parameters
            const params = new URLSearchParams();
            if (page > 1) params.append('page', page);
            if (locationInput.value.trim()) params.append('location', locationInput.value.trim());
            if (techniqueSelect.value) params.append('technique', techniqueSelect.value);

            // Update URL without reload
            const pageUrl = params.toString() ? `{{ route('events.index') }}?${params.toString()}` : '{{ route('events.index') }}';
            const apiUrl = params.toString() ? `{{ route('api.events.index') }}?${params.toString()}` : '{{ route('api.events.index') }}';

            window.history.pushState({}, '', pageUrl);

            // Show/hide clear button
            clearBtn.classList.toggle('hidden', !locationInput.value.trim());

            try {
                const response = await fetch(apiUrl, {
                    cache: 'no-store',
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) throw new Error('Failed to load events');

                const data = await response.json();
                renderEvents(data.events, data.pagination);
            } catch (error) {
                console.error('Error loading events:', error);
                container.innerHTML = '<div class="text-center py-12"><p class="u-text--primary text-xl">Failed to load events. Please try again.</p></div>';
            } finally {
                container.style.filter = '';
                container.style.pointerEvents = '';
                container.style.opacity = '';
            }
        }

        // Render events HTML
        function renderEvents(events, pagination) {
            const container = document.getElementById('events-container');

            if (!events || events.length === 0) {
                container.innerHTML = '<div class="text-center py-12"><p class="u-text--primary text-xl">No events available at the moment</p></div>';
                return;
            }

            let html = '<div class="grid gap-6 items-stretch" style="grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));" id="events-grid">';

            events.forEach(event => {
                const masterImage = event.acf_fields?.master?.featured_image_url || '';
                const masterTitle = event.acf_fields?.master?.title || 'N/A';
                const location = event.acf_fields?.location?.address || 'N/A';
                const date = event.acf_fields?.date || 'N/A';
                const duration = event.acf_fields?.duration || '';
                const email = event.acf_fields?.organiser_email_1 || '';
                const techniques = event.acf_fields?.technique || [];
                const treatments = event.acf_fields?.treatments || [];
                const courses = event.acf_fields?.course || [];

                // Always show image, use placeholder if no image
                const imageUrl = masterImage || `https://ui-avatars.com/api/?name=${encodeURIComponent(masterTitle)}&size=400&background=random&color=fff&bold=true&font-size=0.35`;

                // Get trainer type for logo
                const trainerTypeSlug = event.acf_fields?.master?.member_types?.[0]?.slug || 'trainer';
                const logoMap = {
                    'top-trainer': '/images/top_trainer_logo.png',
                    'trainer': '/images/trainer_logo.png',
                    'master': '/images/master_logo.png'
                };
                const trainerLogo = logoMap[trainerTypeSlug] || '/images/trainer_logo.png';

                html += `
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl flex flex-col h-full transform hover:scale-[1.02] hover:z-10 relative">
                        <!-- Photo wrapper for badge positioning -->
                        <div class="relative">
                            <!-- Full-width square photo at top -->
                            <div class="relative aspect-square w-full overflow-hidden rounded-t-2xl">
                                <img src="${imageUrl}" alt="${masterTitle}" class="w-full h-full object-cover">
                            </div>
                            <!-- Trainer type logo badge -->
                            <div class="absolute -bottom-10 right-4 z-20 pointer-events-none select-none">
                                <img src="${trainerLogo}" alt="Trainer" class="w-20 h-20 rounded-full shadow-lg border-2 border-white" draggable="false">
                            </div>
                        </div>

                        <div class="p-4 pt-8 flex flex-col flex-1">
                            <!-- Master name -->
                            <h3 class="font-bold text-lg text-gray-900 mb-2">${masterTitle}</h3>

                            <!-- Course/Treatment badges -->
                            <div class="flex flex-wrap gap-1 md:gap-2 mb-3">`;

                treatments.forEach(treatment => {
                    const hashtag = '#' + treatment.title.replace(/ /g, '_');
                    html += `<span class="inline-block px-2 py-0.5 rounded text-xs font-semibold border border-purple-500 text-purple-700 bg-purple-50">${hashtag}</span>`;
                });

                courses.forEach(course => {
                    const hashtag = '#' + course.title.replace(/ /g, '_');
                    html += `<span class="inline-block px-2 py-0.5 rounded text-xs font-semibold border border-teal-500 text-teal-700 bg-teal-50">${hashtag}</span>`;
                });

                html += `</div>`;

                // Techniques
                if (techniques.length > 0) {
                    html += `<div class="flex flex-wrap gap-1.5 mb-3">`;
                    techniques.forEach(tech => {
                        html += `<span onclick="filterByTechnique('${tech.replace(/'/g, "\\'")}')" class="px-2 py-0.5 text-xs font-medium text-gray-600 bg-gray-100 rounded-md cursor-pointer hover:bg-purple-100 hover:text-purple-700 transition-colors">${tech}</span>`;
                    });
                    html += `</div>`;
                }

                html += `
                            <!-- Spacer -->
                            <div class="flex-1"></div>

                            <!-- Location -->
                            <div class="flex items-center gap-2 text-sm text-gray-500 mt-3 pt-3 border-t border-gray-100">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span onclick="filterByLocation('${location.replace(/'/g, "\\'")}')"
                                      class="cursor-pointer hover:text-purple-600 transition-colors truncate">
                                    ${location}
                                </span>
                            </div>

                            <!-- Date -->
                            <div class="flex items-center gap-2 text-sm text-gray-500 mt-2">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="font-semibold text-gray-800">${date}</span>`;

                if (duration) {
                    html += `<span class="text-gray-400">·</span><span>${duration} days</span>`;
                }

                html += `
                            </div>
                        </div>`;

                if (email) {
                    html += `
                        <a href="mailto:${email}"
                           style="background: linear-gradient(to right, #ffda55, #ca9d00); color: rgb(12, 12, 13);"
                           class="block w-full text-center py-4 font-bold text-sm shadow-lg hover:shadow-xl transition-all duration-300">
                            Contact Organizer
                        </a>`;
                }

                html += `</div>`;
            });

            html += '</div>';

            // Add pagination
            if (pagination && pagination.total_pages > 1) {
                html += '<div class="mt-12 flex justify-center items-center gap-4">';

                if (pagination.page > 1) {
                    html += `<button onclick="loadEvents(${pagination.page - 1})" class="py-2.5 px-5 bg-gray-600 shadow-sm rounded-2xl transition-all duration-500 text-base text-white font-semibold text-center hover:bg-gray-700">Previous</button>`;
                }

                html += `<span class="text-gray-700 font-semibold">Page ${pagination.page} of ${pagination.total_pages}</span>`;

                if (pagination.page < pagination.total_pages) {
                    html += `<button onclick="loadEvents(${pagination.page + 1})" class="py-2.5 px-5 bg-gray-600 shadow-sm rounded-2xl transition-all duration-500 text-base text-white font-semibold text-center hover:bg-gray-700">Next</button>`;
                }

                html += '</div>';
            }

            container.innerHTML = html;
        }

        // Location autocomplete functionality
        let locationTimeout;
        const locationInput = document.getElementById('location');
        const suggestionsDiv = document.getElementById('location-suggestions');

        locationInput.addEventListener('input', function() {
            clearTimeout(locationTimeout);
            const query = this.value.trim();

            if (query.length < 3) {
                suggestionsDiv.classList.add('hidden');
                return;
            }

            locationTimeout = setTimeout(async () => {
                try {
                    const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=5&addressdetails=1&accept-language=en`);
                    const data = await response.json();

                    if (data.length > 0) {
                        suggestionsDiv.innerHTML = data.map(item => {
                            const address = item.address || {};
                            const city = address.city || address.town || address.village || address.municipality || address.county || '';
                            const country = address.country || '';
                            const displayName = city && country ? `${city}, ${country}` : item.display_name;

                            return `<div class="px-4 py-2 hover:bg-gray-100 cursor-pointer transition-colors" onclick="selectLocation('${displayName.replace(/'/g, "\\'")}')">${displayName}</div>`;
                        }).join('');
                        suggestionsDiv.classList.remove('hidden');
                    } else {
                        suggestionsDiv.classList.add('hidden');
                    }
                } catch (error) {
                    console.error('Error fetching locations:', error);
                    suggestionsDiv.classList.add('hidden');
                }
            }, 300);
        });

        function selectLocation(location) {
            locationInput.value = location;
            suggestionsDiv.classList.add('hidden');
            loadEvents();
        }

        function clearLocation() {
            locationInput.value = '';
            loadEvents();
        }

        // Filter by technique
        function filterByTechnique(technique) {
            const techniqueSelect = document.getElementById('technique');
            techniqueSelect.value = technique;
            loadEvents();
        }

        // Filter by location
        function filterByLocation(locationValue) {
            const locationInput = document.getElementById('location');
            const clearBtn = document.getElementById('clear-location');
            locationInput.value = locationValue;
            clearBtn.classList.remove('hidden');
            loadEvents();
        }

        // Hide suggestions when clicking outside
        document.addEventListener('click', function(event) {
            if (!locationInput.contains(event.target) && !suggestionsDiv.contains(event.target)) {
                suggestionsDiv.classList.add('hidden');
            }
        });
    </script>
@endsection
