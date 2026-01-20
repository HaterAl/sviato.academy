@extends('main.layouts.base')

@section('content')
    <section class="p-4">
        <div class="container mx-auto">
            <section class="py-12">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mb-12">
                        <h2 class="font-manrope text-center font-bold text-gray-900 mb-4 u-text--primary italic">Our Community</h2>
                        <p class="u-text--primary text-center leading-6 mb-9">Meet our talented masters from around the world.</br>
                            Join our community of professional PMU artists.</p>
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

                                <!-- Member Type -->
                                <div>
                                    <label for="member_type" class="block text-sm font-semibold text-gray-700 mb-2">Member Type</label>
                                    <select id="member_type"
                                            name="member_type"
                                            onchange="loadMembers()"
                                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-white">
                                        <option value="">All Members</option>
                                        <option value="top-trainer" {{ request('member_type') == 'top-trainer' ? 'selected' : '' }}>Top Trainer</option>
                                        <option value="trainer" {{ request('member_type') == 'trainer' ? 'selected' : '' }}>Trainer</option>
                                        <option value="master" {{ request('member_type') == 'master' ? 'selected' : '' }}>Master</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>

            <div id="members-container">
                @if(count($members) > 0)
                <div class="grid gap-6 items-stretch" style="grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));" id="members-grid">
                    @foreach($members as $member)
                        @php
                            $gradients = [
                                'linear-gradient(to top right, #facc15, #ef4444, #9333ea)',
                                'linear-gradient(to top right, #ec4899, #f43f5e, #f97316)',
                                'linear-gradient(to top right, #3b82f6, #a855f7, #ec4899)',
                                'linear-gradient(to top right, #4ade80, #06b6d4, #3b82f6)',
                                'linear-gradient(to top right, #a855f7, #ec4899, #ef4444)',
                                'linear-gradient(to top right, #6366f1, #a855f7, #ec4899)',
                                'linear-gradient(to top right, #fb923c, #ef4444, #db2777)',
                                'linear-gradient(to top right, #2dd4bf, #10b981, #22c55e)',
                                'linear-gradient(to top right, #fb7185, #c026d3, #9333ea)',
                            ];
                            $gradient = $gradients[array_rand($gradients)];

                            // Get member type from member data
                            $memberTypeDisplay = !empty($member['member_types'][0]['name']) ? $member['member_types'][0]['name'] : 'Member';
                        @endphp
                        <div class="bg-white rounded-2xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl flex flex-col h-full transform hover:scale-[1.03] hover:z-10 relative">
                            <div class="p-6 flex flex-col flex-1 items-center text-center">
                                <!-- Master image with gradient -->
                                <div class="flex justify-center mb-6">
                                    <div class="relative">
                                        <div class="w-32 h-32 rounded-full p-1" style="background: {{ $gradient }}">
                                            <div class="w-full h-full rounded-full overflow-hidden border-4 border-white">
                                                <img src="{{ !empty($member['featured_image']) ? $member['featured_image'] : 'https://ui-avatars.com/api/?name=' . urlencode($member['title'] ?? 'N A') . '&size=300&background=random&color=fff&bold=true&font-size=0.35' }}"
                                                     alt="{{ $member['title'] }}"
                                                     class="w-full h-full object-cover">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Master name -->
                                <div class="mb-3">
                                    <h3 class="font-bold text-lg text-gray-900">{{ $member['title'] ?? 'N/A' }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">{{ $memberTypeDisplay }}</p>
                                </div>
                                <!-- Separator -->
                                <div class="border-t border-gray-200 mb-4 w-full"></div>
                                <!-- Treatments -->
                                <div class="mb-5 text-sm font-semibold text-gray-700">
                                    @if(!empty($member['acf_fields']['member_treatment']))
                                        @foreach($member['acf_fields']['member_treatment'] as $treatment)
                                            <span>{{ $treatment['title'] }}</span>{{ !$loop->last ? ', ' : '' }}
                                        @endforeach
                                    @endif
                                </div>

                                <!-- Separator -->
                                <div class="border-t border-gray-200 mb-4 w-full"></div>

                                <!-- Location and Email -->
                                <div class="space-y-2 mb-4">
                                    <p onclick="filterByLocation('{{ $member['acf_fields']['location']['address'] ?? '' }}')" class="text-sm text-gray-600 cursor-pointer hover:text-purple-600 transition-colors">{{ $member['acf_fields']['location']['address'] ?? 'N/A' }}</p>

                                    @if(!empty($member['acf_fields']['email']))
                                        <div class="text-xs text-gray-500">
                                            <a href="mailto:{{ $member['acf_fields']['email'] }}" class="hover:text-purple-600 transition-colors break-all">{{ $member['acf_fields']['email'] }}</a>
                                        </div>
                                    @endif
                                </div>

                                <!-- Separator -->
                                @if(!empty($member['acf_fields']['instagram']) || !empty($member['acf_fields']['facebook']))
                                    <div class="border-t border-gray-200 mb-4 w-full"></div>

                                    <!-- Social Networks -->
                                    <div class="flex justify-center gap-3">
                                        @if(!empty($member['acf_fields']['instagram']))
                                            <a href="{{ $member['acf_fields']['instagram'] }}" target="_blank" rel="noopener" class="text-gray-600 hover:text-purple-600 transition-colors">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                                </svg>
                                            </a>
                                        @endif
                                        @if(!empty($member['acf_fields']['facebook']))
                                            <a href="{{ $member['acf_fields']['facebook'] }}" target="_blank" rel="noopener" class="text-gray-600 hover:text-purple-600 transition-colors">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                @if(!empty($pagination) && $pagination['total_pages'] > 1)
                    <div class="mt-12 flex justify-center items-center gap-4">
                        @if($pagination['page'] > 1)
                            <button onclick="loadMembers({{ $pagination['page'] - 1 }})"
                                    class="py-2.5 px-5 bg-gray-600 shadow-sm rounded-2xl transition-all duration-500 text-base text-white font-semibold text-center hover:bg-gray-700">
                                Previous
                            </button>
                        @endif

                        <span class="text-gray-700 font-semibold">
                            Page {{ $pagination['page'] }} of {{ $pagination['total_pages'] }}
                        </span>

                        @if($pagination['page'] < $pagination['total_pages'])
                            <button onclick="loadMembers({{ $pagination['page'] + 1 }})"
                                    class="py-2.5 px-5 bg-gray-600 shadow-sm rounded-2xl transition-all duration-500 text-base text-white font-semibold text-center hover:bg-gray-700">
                                Next
                            </button>
                        @endif
                    </div>
                @endif
            @else
                <!-- Skeleton Loader -->
                <div id="members-skeleton" class="grid gap-6 items-stretch" style="grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));">
                    @for ($i = 0; $i < 16; $i++)
                        <div class="bg-white rounded-2xl shadow-md overflow-hidden flex flex-col h-full">
                            <div class="p-6 flex flex-col flex-1 items-center text-center">
                                <!-- Avatar skeleton -->
                                <div class="flex justify-center mb-6">
                                    <div class="w-32 h-32 rounded-full bg-gray-100"></div>
                                </div>

                                <!-- Name and type skeleton -->
                                <div class="mb-3 w-full">
                                    <div class="h-6 bg-gray-100 rounded w-2/3 mx-auto mb-2"></div>
                                    <div class="h-4 bg-gray-100 rounded w-1/2 mx-auto"></div>
                                </div>

                                <!-- Separator -->
                                <div class="border-t border-gray-200 mb-4 w-full"></div>

                                <!-- Treatments skeleton -->
                                <div class="mb-5 w-full">
                                    <div class="h-4 bg-gray-100 rounded w-3/4 mx-auto"></div>
                                </div>

                                <!-- Separator -->
                                <div class="border-t border-gray-200 mb-4 w-full"></div>

                                <!-- Location and email skeleton -->
                                <div class="space-y-2 mb-4 w-full">
                                    <div class="h-4 bg-gray-100 rounded w-2/3 mx-auto"></div>
                                    <div class="h-3 bg-gray-100 rounded w-1/2 mx-auto"></div>
                                </div>

                                <!-- Separator -->
                                <div class="border-t border-gray-200 mb-4 w-full"></div>

                                <!-- Social icons skeleton -->
                                <div class="flex justify-center gap-3">
                                    <div class="w-5 h-5 bg-gray-100 rounded"></div>
                                    <div class="w-5 h-5 bg-gray-100 rounded"></div>
                                </div>
                            </div>
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
        // Gradients for member cards
        const gradients = [
            'linear-gradient(to top right, #facc15, #ef4444, #9333ea)',
            'linear-gradient(to top right, #ec4899, #f43f5e, #f97316)',
            'linear-gradient(to top right, #3b82f6, #a855f7, #ec4899)',
            'linear-gradient(to top right, #4ade80, #06b6d4, #3b82f6)',
            'linear-gradient(to top right, #a855f7, #ec4899, #ef4444)',
            'linear-gradient(to top right, #6366f1, #a855f7, #ec4899)',
            'linear-gradient(to top right, #fb923c, #ef4444, #db2777)',
            'linear-gradient(to top right, #2dd4bf, #10b981, #22c55e)',
            'linear-gradient(to top right, #fb7185, #c026d3, #9333ea)',
        ];

        let isFirstLoad = true;

        // Load members via AJAX
        async function loadMembers(page = 1) {
            const locationInput = document.getElementById('location');
            const memberTypeSelect = document.getElementById('member_type');
            const clearBtn = document.getElementById('clear-location');
            const container = document.getElementById('members-container');

            // Scroll to container with offset only during pagination (not on first load)
            if (!isFirstLoad) {
                const containerRect = container.getBoundingClientRect();
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                const targetPosition = containerRect.top + scrollTop - 100; // 100px above the container

                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });

                // Add blur effect
                container.style.filter = 'blur(3px)';
                container.style.pointerEvents = 'none';
                container.style.opacity = '0.6';
                container.style.transition = 'filter 0.2s ease, opacity 0.2s ease';
            }

            isFirstLoad = false;

            // Build query parameters
            const params = new URLSearchParams();
            if (page > 1) params.append('page', page);
            if (locationInput.value.trim()) params.append('location', locationInput.value.trim());
            if (memberTypeSelect.value) params.append('member_type', memberTypeSelect.value);

            // Update URL without reload
            const newUrl = params.toString() ? `{{ route('community.index') }}?${params.toString()}` : '{{ route('community.index') }}';
            window.history.pushState({}, '', newUrl);

            // Show/hide clear button
            clearBtn.classList.toggle('hidden', !locationInput.value.trim());

            try {
                const response = await fetch(newUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) throw new Error('Failed to load members');

                const data = await response.json();
                renderMembers(data.members, data.pagination, data.member_type);
            } catch (error) {
                console.error('Error loading members:', error);
                container.innerHTML = '<div class="text-center py-12"><p class="u-text--primary text-xl">Failed to load community members. Please try again.</p></div>';
            } finally {
                // Remove blur effect
                container.style.filter = '';
                container.style.pointerEvents = '';
                container.style.opacity = '';
            }
        }

        // Render members HTML
        function renderMembers(members, pagination, memberType = '') {
            const container = document.getElementById('members-container');

            if (!members || members.length === 0) {
                container.innerHTML = '<div class="text-center py-12"><p class="u-text--primary text-xl">No community members available at the moment</p></div>';
                return;
            }

            let html = '<div class="grid gap-6 items-stretch" style="grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));" id="members-grid">';

            members.forEach(member => {
                const gradient = gradients[Math.floor(Math.random() * gradients.length)];
                const masterTitle = member.title || 'N/A';
                const masterImage = member.featured_image || `https://ui-avatars.com/api/?name=${encodeURIComponent(masterTitle)}&size=300&background=random&color=fff&bold=true&font-size=0.35`;
                const location = member.acf_fields?.location?.address || 'N/A';
                const treatments = member.acf_fields?.member_treatment || [];

                // Get member type from member data
                const memberTypeDisplay = member.member_types?.[0]?.name || 'Member';

                html += `
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl flex flex-col h-full transform hover:scale-[1.03] hover:z-10 relative">
                        <div class="p-6 flex flex-col flex-1 items-center text-center">
                            <div class="flex justify-center mb-6">
                                <div class="relative">
                                    <div class="w-32 h-32 rounded-full p-1" style="background: ${gradient}">
                                        <div class="w-full h-full rounded-full overflow-hidden border-4 border-white">
                                            <img src="${masterImage}" alt="${masterTitle}" class="w-full h-full object-cover">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <h3 class="font-bold text-lg text-gray-900">${masterTitle}</h3>
                                <p class="text-sm text-gray-600 mt-1">${memberTypeDisplay}</p>
                            </div>`;

                // Treatments
                html += `<div class="mb-5 text-sm font-semibold text-gray-700">`;
                if (treatments.length > 0) {
                    html += treatments.map((treatment, index) => {
                        return `<span>${treatment.title}</span>${index < treatments.length - 1 ? ', ' : ''}`;
                    }).join('');
                }
                html += `</div>`;

                // Separator
                html += `<div class="border-t border-gray-200 mb-4 w-full"></div>`;

                // Location and Email
                const email = member.acf_fields?.email || '';
                html += `<div class="space-y-2 mb-4">
                    <p onclick="filterByLocation('${location.replace(/'/g, "\\'")}')" class="text-sm text-gray-600 cursor-pointer hover:text-purple-600 transition-colors">${location}</p>`;

                if (email) {
                    html += `
                        <div class="text-xs text-gray-500">
                            <a href="mailto:${email}" class="hover:text-purple-600 transition-colors break-all">${email}</a>
                        </div>`;
                }

                html += `</div>`;

                // Social Networks
                const instagram = member.acf_fields?.instagram || '';
                const facebook = member.acf_fields?.facebook || '';

                if (instagram || facebook) {
                    // Separator before social networks
                    html += `<div class="border-t border-gray-200 mb-4 w-full"></div>`;

                    html += `<div class="flex justify-center gap-3">`;

                    if (instagram) {
                        html += `
                            <a href="${instagram}" target="_blank" rel="noopener" class="text-gray-600 hover:text-purple-600 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </a>`;
                    }

                    if (facebook) {
                        html += `
                            <a href="${facebook}" target="_blank" rel="noopener" class="text-gray-600 hover:text-purple-600 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>`;
                    }

                    html += `</div>`;
                }

                html += `
                    </div>
                </div>`;
            });

            html += '</div>';

            // Add pagination
            if (pagination && pagination.total_pages > 1) {
                html += '<div class="mt-12 flex justify-center items-center gap-4">';

                if (pagination.page > 1) {
                    html += `<button onclick="loadMembers(${pagination.page - 1})" class="py-2.5 px-5 bg-gray-600 shadow-sm rounded-2xl transition-all duration-500 text-base text-white font-semibold text-center hover:bg-gray-700">Previous</button>`;
                }

                html += `<span class="text-gray-700 font-semibold">Page ${pagination.page} of ${pagination.total_pages}</span>`;

                if (pagination.page < pagination.total_pages) {
                    html += `<button onclick="loadMembers(${pagination.page + 1})" class="py-2.5 px-5 bg-gray-600 shadow-sm rounded-2xl transition-all duration-500 text-base text-white font-semibold text-center hover:bg-gray-700">Next</button>`;
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
            loadMembers();
        }

        function clearLocation() {
            locationInput.value = '';
            loadMembers();
        }

        // Filter by location
        function filterByLocation(locationValue) {
            const locationInput = document.getElementById('location');
            const clearBtn = document.getElementById('clear-location');
            locationInput.value = locationValue;
            clearBtn.classList.remove('hidden');
            loadMembers();
        }

        // Hide suggestions when clicking outside
        document.addEventListener('click', function(event) {
            if (!locationInput.contains(event.target) && !suggestionsDiv.contains(event.target)) {
                suggestionsDiv.classList.add('hidden');
            }
        });

        // Auto-load members on page load
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const page = urlParams.get('page') || 1;
            loadMembers(page);
        });
    </script>
@endsection
