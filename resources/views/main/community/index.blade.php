@extends('main.layouts.base')

@section('content')
    <section class="p-4">
        <div class="container mx-auto">
            <section class="py-12">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mb-12">
                        <h2 class="font-manrope text-center font-bold text-gray-900 mb-4 u-text--primary italic">Sviato
                            Community</h2>
                        <p class="text-center leading-6 mb-9">Meet our <span class="u-text--primary">talented masters</span> from around the
                            world.</br>
                            <span class="u-text--primary">Join our community</span> of professional PMU artists.</p>
                    </div>

                    <!-- Search Form -->
                    @php $hasActiveFilters = request('search') || request('location') || request('member_type'); @endphp
                    <style>
                        #filters-content {
                            max-height: 0;
                            overflow: hidden;
                            transition: max-height 0.3s ease;
                        }
                        #filters-content.open {
                            max-height: 500px;
                        }
                        @media (min-width: 768px) {
                            #filters-toggle,
                            #sort-mobile-wrapper {
                                display: none !important;
                            }
                            #sort-dropdown-wrapper {
                                display: block !important;
                            }
                            #filters-content {
                                max-height: none !important;
                                overflow: visible !important;
                            }
                        }
                    </style>
                    <div class="mb-8 bg-white rounded-2xl shadow-md p-4 md:p-6">
                        <!-- Mobile Filters Toggle Button -->
                        <button type="button" id="filters-toggle" onclick="toggleFilters()"
                            class="md:hidden w-full flex items-center justify-between px-2 py-2 text-gray-700 font-semibold">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                </svg>
                                Filters
                            </span>
                            <svg id="filters-chevron" class="w-5 h-5 transition-transform duration-300{{ $hasActiveFilters ? ' rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- Filters Content -->
                        <div id="filters-content" class="{{ $hasActiveFilters ? 'open' : '' }}">
                        <form id="search-form">
                            <div class="flex flex-col md:flex-row md:items-end gap-3">
                            <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Name Search -->
                                <div>
                                    <label for="search_name" class="block text-sm font-semibold text-gray-700 mb-2">Name</label>
                                    <div class="relative">
                                        <input type="text" id="search_name" name="search" value="{{ request('search') }}"
                                            placeholder="Search by name..." autocomplete="off"
                                            class="w-full px-4 py-2.5 pr-10 border border-gray-300 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                                        <button type="button" id="clear-search" onclick="clearSearch()"
                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 flex items-center justify-center text-gray-400 hover:text-gray-600 transition-colors {{ request('search') ? '' : 'hidden' }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Location -->
                                <div class="relative">
                                    <label for="location"
                                        class="block text-sm font-semibold text-gray-700 mb-2">Location</label>
                                    <div class="relative">
                                        <input type="text" id="location" name="location" value="{{ request('location') }}"
                                            placeholder="Enter city or country..." autocomplete="off"
                                            class="w-full px-4 py-2.5 pr-10 border border-gray-300 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                                        <button type="button" id="clear-location" onclick="clearLocation()"
                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 flex items-center justify-center text-gray-400 hover:text-gray-600 transition-colors {{ request('location') ? '' : 'hidden' }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div id="location-suggestions"
                                        class="absolute z-50 w-full bg-white border border-gray-300 rounded-lg shadow-lg mt-1 max-h-60 overflow-y-auto hidden">
                                    </div>
                                </div>

                                <!-- Member Type -->
                                <div>
                                    <label for="member_type" class="block text-sm font-semibold text-gray-700 mb-2">Member
                                        Type</label>
                                    <select id="member_type" name="member_type" onchange="loadMembers()"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent bg-white">
                                        <option value="">All Members</option>
                                        <option value="top-trainer" {{ request('member_type') == 'top-trainer' ? 'selected' : '' }}>Top Trainer</option>
                                        <option value="trainer" {{ request('member_type') == 'trainer' ? 'selected' : '' }}>
                                            Trainer</option>
                                        <option value="master" {{ request('member_type') == 'master' ? 'selected' : '' }}>
                                            Master</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Sort: select on mobile, icon+dropdown on desktop -->
                            <!-- Mobile sort select -->
                            <div id="sort-mobile-wrapper" class="md:hidden">
                                <label for="sort_mobile" class="block text-sm font-semibold text-gray-700 mb-2">Sort by</label>
                                <select id="sort_mobile" onchange="applySortFromSelect(this.value)"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent bg-white">
                                    <option value="date-ASC" {{ ($sortBy ?? 'date') == 'date' ? 'selected' : '' }}>Default</option>
                                    <option value="title-ASC" {{ ($sortBy ?? '') == 'title' && ($sortOrder ?? '') == 'ASC' ? 'selected' : '' }}>A - Z</option>
                                    <option value="title-DESC" {{ ($sortBy ?? '') == 'title' && ($sortOrder ?? '') == 'DESC' ? 'selected' : '' }}>Z - A</option>
                                </select>
                            </div>
                            <!-- Desktop sort button -->
                            <div class="relative flex-shrink-0 hidden md:block" id="sort-dropdown-wrapper">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Sort by</label>
                                <button type="button" id="sort-btn" onclick="toggleSortDropdown()"
                                    title="Sort by name"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-yellow-500 focus:border-transparent bg-white">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M4 6h7"/><path d="M4 12h5"/><path d="M4 18h3"/><path d="M18 6v14"/><path d="M18 20l-3-3"/><path d="M18 20l3-3"/>
                                    </svg>
                                    <span class="text-sm"></span>
                                </button>
                                <div id="sort-dropdown" class="absolute right-0 top-full mt-1 w-36 bg-white border border-gray-200 rounded-xl shadow-lg z-50 overflow-hidden hidden">
                                    <button type="button" onclick="applySort('date','ASC')" data-sort="date-ASC"
                                        class="sort-option w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                        Default
                                    </button>
                                    <button type="button" onclick="applySort('title','ASC')" data-sort="title-ASC"
                                        class="sort-option w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                        A - Z
                                    </button>
                                    <button type="button" onclick="applySort('title','DESC')" data-sort="title-DESC"
                                        class="sort-option w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                        Z - A
                                    </button>
                                </div>
                            </div>
                            </div>
                        </form>
                        </div>
                    </div>

                    <div id="members-container">
                        @if(count($members) > 0)
                        <div class="grid gap-6 items-stretch"
                            style="grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));" id="members-grid">
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

                                    {{-- OLD CARD DESIGN WITH ROUND PHOTO
                                    <div
                                        class="bg-white rounded-2xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl flex flex-col h-full transform hover:scale-[1.03] hover:z-10 relative">
                                        <div class="p-6 flex flex-col flex-1 items-center text-center">
                                            <div class="flex justify-center mb-6">
                                                <div class="relative">
                                                    <div class="w-32 h-32 rounded-full p-1" style="background: {{ $gradient }}">
                                                        <div
                                                            class="w-full h-full rounded-full overflow-hidden border-4 border-white">
                                                            <img src="{{ !empty($member['featured_image']) ? $member['featured_image'] : 'https://ui-avatars.com/api/?name=' . urlencode($member['title'] ?? 'N A') . '&size=300&background=random&color=fff&bold=true&font-size=0.35' }}"
                                                                alt="{{ $member['title'] }}" class="w-full h-full object-cover">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <h3 class="font-bold text-lg text-gray-900">{{ $member['title'] ?? 'N/A' }}</h3>
                                                <p class="text-sm text-gray-600 mt-1">{{ $memberTypeDisplay }}</p>
                                            </div>
                                            <div class="border-t border-gray-200 mb-4 w-full"></div>
                                            <div class="mb-5 text-sm font-semibold text-gray-700">
                                                @if(!empty($member['acf_fields']['member_treatment']))
                                                    @foreach($member['acf_fields']['member_treatment'] as $treatment)
                                                        <span>{{ $treatment['title'] }}</span>{{ !$loop->last ? ', ' : '' }}
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="border-t border-gray-200 mb-4 w-full"></div>
                                            <div class="space-y-2 mb-4">
                                                <p onclick="filterByLocation('{{ $member['acf_fields']['location']['address'] ?? '' }}')"
                                                    class="text-sm text-gray-600 cursor-pointer hover:text-yellow-500 transition-colors">
                                                    {{ $member['acf_fields']['location']['address'] ?? 'N/A' }}</p>
                                                @if(!empty($member['acf_fields']['email']))
                                                    <div class="text-xs text-gray-500">
                                                        <a href="mailto:{{ $member['acf_fields']['email'] }}"
                                                            class="hover:text-yellow-500 transition-colors break-all">{{ $member['acf_fields']['email'] }}</a>
                                                    </div>
                                                @endif
                                            </div>
                                            @if(!empty($member['acf_fields']['instagram']) || !empty($member['acf_fields']['facebook'])|| !empty($member['acf_fields']['tiktok']))
                                                <div class="border-t border-gray-200 mb-4 w-full"></div>
                                                <div class="flex justify-center gap-3">
                                                   @if(!empty($member['acf_fields']['instagram']))
                                                        <a href="{{ $member['acf_fields']['instagram'] }}" target="_blank" rel="noopener"
                                                        class="text-gray-600 transition-colors duration-300 hover:text-yellow-500">
                                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                                            </svg>
                                                        </a>
                                                    @endif
                                                    @if(!empty($member['acf_fields']['facebook']))
                                                        <a href="{{ $member['acf_fields']['facebook'] }}" target="_blank" rel="noopener"
                                                        class="text-gray-600 transition-colors duration-300 hover:text-yellow-500">
                                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                                            </svg>
                                                        </a>
                                                    @endif
                                                    @if(!empty($member['acf_fields']['tiktok']))
                                                        <a href="{{ $member['acf_fields']['tiktok'] }}" target="_blank" rel="noopener"
                                                        class="text-gray-600 transition-colors duration-300 hover:text-yellow-500">
                                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M16.656 1.029c1.637-0.025 3.262-0.012 4.886-0.025 0.054 2.031 0.878 3.859 2.189 5.213l-0.002-0.002c1.411 1.271 3.247 2.095 5.271 2.235l0.028 0.002v5.036c-1.912-0.048-3.71-0.489-5.331-1.247l0.082 0.034c-0.784-0.377-1.447-0.764-2.077-1.196l0.052 0.034c-0.012 3.649 0.012 7.298-0.025 10.934-0.103 1.853-0.719 3.543-1.707 4.954l0.020-0.031c-1.652 2.366-4.328 3.919-7.371 4.011l-0.014 0c-0.123 0.006-0.268 0.009-0.414 0.009-1.73 0-3.347-0.482-4.725-1.319l0.040 0.023c-2.508-1.509-4.238-4.091-4.558-7.094l-0.004-0.041c-0.025-0.625-0.037-1.25-0.012-1.862 0.49-4.779 4.494-8.476 9.361-8.476 0.547 0 1.083 0.047 1.604 0.136l-0.056-0.008c0.025 1.849-0.050 3.699-0.050 5.548-0.423-0.153-0.911-0.242-1.42-0.242-1.868 0-3.457 1.194-4.045 2.861l-0.009 0.030c-0.133 0.427-0.21 0.918-0.21 1.426 0 0.206 0.013 0.41 0.037 0.61l-0.002-0.024c0.332 2.046 2.086 3.59 4.201 3.59 0.061 0 0.121-0.001 0.181-0.004l-0.009 0c1.463-0.044 2.733-0.831 3.451-1.994l0.010-0.018c0.267-0.372 0.45-0.822 0.511-1.311l0.001-0.014c0.125-2.237 0.075-4.461 0.087-6.698 0.012-5.036-0.012-10.060 0.025-15.083z"></path>
                                                            </svg>
                                                        </a>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    END OLD CARD DESIGN --}}

                                    {{-- NEW CARD DESIGN WITH SQUARE PHOTO --}}
                                    <div class="group bg-white rounded-2xl shadow-md transition-all duration-300 hover:shadow-2xl flex flex-col h-full transform hover:scale-[1.02] hover:z-10 relative">
                                        {{-- Photo wrapper for badge positioning --}}
                                        <div class="relative">
                                            {{-- Full-width square photo at top --}}
                                            <div class="relative aspect-square w-full overflow-hidden rounded-t-2xl">
                                            <img src="{{ !empty($member['featured_image']) ? $member['featured_image'] : 'https://ui-avatars.com/api/?name=' . urlencode($member['title'] ?? 'N A') . '&size=400&background=random&color=fff&bold=true&font-size=0.35' }}"
                                                alt="{{ $member['title'] }}"
                                                class="w-full h-full object-cover">
                                            {{-- Member type badge - temporarily commented
                                            <div class="absolute top-3 left-3">
                                                <span class="px-3 py-1.5 text-xs font-semibold text-white rounded-full bg-black/70 backdrop-blur-sm">
                                                    {{ $memberTypeDisplay }}
                                                </span>
                                            </div>
                                            --}}
                                            {{-- Social icons - bottom left --}}
                                            @if(!empty($member['acf_fields']['instagram']) || !empty($member['acf_fields']['facebook']) || !empty($member['acf_fields']['tiktok']))
                                                <div class="absolute bottom-3 left-3 flex flex-row gap-2">
                                                    @if(!empty($member['acf_fields']['instagram']))
                                                        <a href="{{ $member['acf_fields']['instagram'] }}" target="_blank" rel="noopener"
                                                            class="w-9 h-9 flex items-center justify-center bg-white rounded-full text-gray-800 shadow-md hover:bg-yellow-400 hover:scale-110 hover:shadow-lg transition-all duration-300">
                                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                                            </svg>
                                                        </a>
                                                    @endif
                                                    @if(!empty($member['acf_fields']['facebook']))
                                                        <a href="{{ $member['acf_fields']['facebook'] }}" target="_blank" rel="noopener"
                                                            class="w-9 h-9 flex items-center justify-center bg-white rounded-full text-gray-800 shadow-md hover:bg-yellow-400 hover:scale-110 hover:shadow-lg transition-all duration-300">
                                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                                            </svg>
                                                        </a>
                                                    @endif
                                                    @if(!empty($member['acf_fields']['tiktok']))
                                                        <a href="{{ $member['acf_fields']['tiktok'] }}" target="_blank" rel="noopener"
                                                            class="w-9 h-9 flex items-center justify-center bg-white rounded-full text-gray-800 shadow-md hover:bg-yellow-400 hover:scale-110 hover:shadow-lg transition-all duration-300">
                                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 32 32">
                                                                <path d="M16.656 1.029c1.637-0.025 3.262-0.012 4.886-0.025 0.054 2.031 0.878 3.859 2.189 5.213l-0.002-0.002c1.411 1.271 3.247 2.095 5.271 2.235l0.028 0.002v5.036c-1.912-0.048-3.71-0.489-5.331-1.247l0.082 0.034c-0.784-0.377-1.447-0.764-2.077-1.196l0.052 0.034c-0.012 3.649 0.012 7.298-0.025 10.934-0.103 1.853-0.719 3.543-1.707 4.954l0.020-0.031c-1.652 2.366-4.328 3.919-7.371 4.011l-0.014 0c-0.123 0.006-0.268 0.009-0.414 0.009-1.73 0-3.347-0.482-4.725-1.319l0.040 0.023c-2.508-1.509-4.238-4.091-4.558-7.094l-0.004-0.041c-0.025-0.625-0.037-1.25-0.012-1.862 0.49-4.779 4.494-8.476 9.361-8.476 0.547 0 1.083 0.047 1.604 0.136l-0.056-0.008c0.025 1.849-0.050 3.699-0.050 5.548-0.423-0.153-0.911-0.242-1.42-0.242-1.868 0-3.457 1.194-4.045 2.861l-0.009 0.030c-0.133 0.427-0.21 0.918-0.21 1.426 0 0.206 0.013 0.41 0.037 0.61l-0.002-0.024c0.332 2.046 2.086 3.59 4.201 3.59 0.061 0 0.121-0.001 0.181-0.004l-0.009 0c1.463-0.044 2.733-0.831 3.451-1.994l0.010-0.018c0.267-0.372 0.45-0.822 0.511-1.311l0.001-0.014c0.125-2.237 0.075-4.461 0.087-6.698 0.012-5.036-0.012-10.060 0.025-15.083z"/>
                                                            </svg>
                                                        </a>
                                                    @endif
                                                </div>
                                            @endif
                                            </div>
                                            {{-- Member type logo badge --}}
                                            @php
                                                $memberTypeSlug = $member['member_types'][0]['slug'] ?? 'master';
                                                $logoMap = [
                                                    'top-trainer' => '/images/top_trainer_logo.png',
                                                    'trainer' => '/images/trainer_logo.png',
                                                    'master' => '/images/master_logo.png',
                                                ];
                                                $memberLogo = $logoMap[$memberTypeSlug] ?? '/images/master_logo.png';
                                            @endphp
                                            <div class="absolute -bottom-10 right-4 z-20 pointer-events-none select-none">
                                                <img src="{{ $memberLogo }}" alt="{{ $memberTypeDisplay }}" class="w-20 h-20 rounded-full shadow-lg border-2 border-white" draggable="false">
                                            </div>
                                        </div>        
                                        {{-- Content section --}}
                                        <div class="p-4 pt-8 flex flex-col flex-1">
                                            {{-- Name - split into two lines only if very long (>18 chars) --}}
                                            @php
                                                $fullName = $member['title'] ?? 'N/A';
                                                $nameParts = explode(' ', $fullName, 2);
                                                $isLong = strlen($fullName) > 36;
                                            @endphp
                                            <h3 class="font-bold text-lg text-gray-900 mb-2 leading-tight">
                                                @if($isLong && isset($nameParts[1]))
                                                    {{ $nameParts[0] }}<br>{{ $nameParts[1] }}
                                                @else
                                                    {{ $fullName }}
                                                @endif
                                            </h3>

                                            {{-- Treatments --}}
                                            @if(!empty($member['acf_fields']['member_treatment']))
                                                <div class="flex flex-wrap gap-1.5 mb-3">
                                                    @foreach($member['acf_fields']['member_treatment'] as $treatment)
                                                        <span class="px-2 py-0.5 text-xs font-medium text-gray-600 bg-gray-100 rounded-md">{{ $treatment['title'] }}</span>
                                                    @endforeach
                                                </div>
                                            @endif

                                            {{-- Spacer to push location to bottom --}}
                                            <div class="flex-1"></div>

                                            {{-- Location --}}
                                            <div class="flex items-center gap-2 text-sm text-gray-500 mt-3 pt-3 border-t border-gray-100">
                                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                                <span onclick="filterByLocation('{{ $member['acf_fields']['location']['address'] ?? '' }}')"
                                                    class="cursor-pointer hover:text-yellow-500 transition-colors truncate">
                                                    {{ $member['acf_fields']['location']['address'] ?? 'N/A' }}
                                                </span>
                                            </div>

                                            {{-- Email --}}
                                            @if(!empty($member['acf_fields']['email']))
                                                <div class="flex items-center gap-2 text-sm text-gray-500 mt-2">
                                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                    </svg>
                                                    <a href="mailto:{{ $member['acf_fields']['email'] }}"
                                                        class="hover:text-yellow-500 transition-colors truncate">
                                                        {{ $member['acf_fields']['email'] }}
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- END NEW CARD DESIGN --}}
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
                        <div class="text-center py-12">
                            <p class="u-text--primary text-xl">No community members available at the moment</p>
                        </div>
                        @endif
                    </div>
                </div>
            </section>
        </div>
    </section>

    <script>
        // Mobile filters toggle
        function toggleFilters() {
            document.getElementById('filters-content').classList.toggle('open');
            document.getElementById('filters-chevron').classList.toggle('rotate-180');
        }

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

        // Sort state
        let currentSortBy = '{{ $sortBy ?? "date" }}';
        let currentSortOrder = '{{ $sortOrder ?? "ASC" }}';

        function toggleSortDropdown() {
            const dropdown = document.getElementById('sort-dropdown');
            dropdown.classList.toggle('hidden');
        }

        function applySort(sortBy, sortOrder) {
            currentSortBy = sortBy;
            currentSortOrder = sortOrder;
            document.getElementById('sort-dropdown').classList.add('hidden');
            // Sync mobile select
            const mobileSelect = document.getElementById('sort_mobile');
            if (mobileSelect) mobileSelect.value = `${sortBy}-${sortOrder}`;
            updateSortButton();
            loadMembers();
        }

        function applySortFromSelect(value) {
            const [sortBy, sortOrder] = value.split('-');
            currentSortBy = sortBy;
            currentSortOrder = sortOrder;
            updateSortButton();
            loadMembers();
        }

        function updateSortButton() {
            const btn = document.getElementById('sort-btn');
            const isActive = currentSortBy === 'title';

            if (isActive) {
                btn.classList.add('border-yellow-500', 'text-yellow-600', 'bg-yellow-50');
                btn.classList.remove('border-gray-300', 'text-gray-500', 'bg-white');
            } else {
                btn.classList.remove('border-yellow-500', 'text-yellow-600', 'bg-yellow-50');
                btn.classList.add('border-gray-300', 'text-gray-500', 'bg-white');
            }

            // Highlight active option
            document.querySelectorAll('.sort-option').forEach(opt => {
                const key = opt.getAttribute('data-sort');
                if (key === `${currentSortBy}-${currentSortOrder}`) {
                    opt.classList.add('bg-yellow-50', 'text-yellow-600', 'font-semibold');
                    opt.classList.remove('text-gray-700');
                } else {
                    opt.classList.remove('bg-yellow-50', 'text-yellow-600', 'font-semibold');
                    opt.classList.add('text-gray-700');
                }
            });
        }

        // Initialize sort button state
        updateSortButton();

        // Load members via AJAX
        async function loadMembers(page = 1) {
            const searchNameInput = document.getElementById('search_name');
            const locationInput = document.getElementById('location');
            const memberTypeSelect = document.getElementById('member_type');
            const clearBtn = document.getElementById('clear-location');
            const container = document.getElementById('members-container');

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

            // Build query parameters for URL
            const params = new URLSearchParams();
            if (page > 1) params.append('page', page);
            if (searchNameInput.value.trim()) params.append('search', searchNameInput.value.trim());
            if (locationInput.value.trim()) params.append('location', locationInput.value.trim());
            if (memberTypeSelect.value) params.append('member_type', memberTypeSelect.value);
            if (currentSortBy !== 'date') {
                params.append('sort_by', currentSortBy);
                params.append('sort_order', currentSortOrder);
            }

            // Update URL in browser address bar (clean URL)
            const pageUrl = params.toString() ? `{{ route('community.index') }}?${params.toString()}` : '{{ route('community.index') }}';
            const apiUrl = params.toString() ? `{{ route('api.community.index') }}?${params.toString()}` : '{{ route('api.community.index') }}';

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

                if (!response.ok) throw new Error('Failed to load members');

                const data = await response.json();
                renderMembers(data.members, data.pagination, data.member_type);
            } catch (error) {
                console.error('Error loading members:', error);
                container.innerHTML = '<div class="text-center py-12"><p class="u-text--primary text-xl">Failed to load community members. Please try again.</p></div>';
            } finally {
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
                const masterImage = member.featured_image || `https://ui-avatars.com/api/?name=${encodeURIComponent(masterTitle)}&size=400&background=random&color=fff&bold=true&font-size=0.35`;
                const location = member.acf_fields?.location?.address || 'N/A';
                const treatments = member.acf_fields?.member_treatment || [];
                const email = member.acf_fields?.email || '';
                const instagram = member.acf_fields?.instagram || '';
                const facebook = member.acf_fields?.facebook || '';
                const tiktok = member.acf_fields?.tiktok || '';

                // Get member type from member data
                const memberTypeDisplay = member.member_types?.[0]?.name || 'Member';

                // NEW CARD DESIGN WITH SQUARE PHOTO
                html += `
                    <div class="group bg-white rounded-2xl shadow-md transition-all duration-300 hover:shadow-2xl flex flex-col h-full transform hover:scale-[1.02] hover:z-10 relative">
                        <!-- Photo wrapper for badge positioning -->
                        <div class="relative">
                            <!-- Full-width square photo at top -->
                            <div class="relative aspect-square w-full overflow-hidden rounded-t-2xl">
                                <img src="${masterImage}" alt="${masterTitle}"
                                    class="w-full h-full object-cover">
                                <!-- Member type badge - temporarily commented
                                <div class="absolute top-3 left-3">
                                    <span class="px-3 py-1.5 text-xs font-semibold text-white rounded-full bg-black/70 backdrop-blur-sm">
                                        ${memberTypeDisplay}
                                    </span>
                                </div>
                                -->`;

                // Social icons - bottom left
                if (instagram || facebook || tiktok) {
                    html += `
                            <div class="absolute bottom-3 left-3 flex flex-row gap-2">`;

                    if (instagram) {
                        html += `
                                <a href="${instagram}" target="_blank" rel="noopener"
                                    class="w-9 h-9 flex items-center justify-center bg-white rounded-full text-gray-800 shadow-md hover:bg-yellow-400 hover:scale-110 hover:shadow-lg transition-all duration-300">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                </a>`;
                    }

                    if (facebook) {
                        html += `
                                <a href="${facebook}" target="_blank" rel="noopener"
                                    class="w-9 h-9 flex items-center justify-center bg-white rounded-full text-gray-800 shadow-md hover:bg-yellow-400 hover:scale-110 hover:shadow-lg transition-all duration-300">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                </a>`;
                    }

                    if (tiktok) {
                        html += `
                                <a href="${tiktok}" target="_blank" rel="noopener"
                                    class="w-9 h-9 flex items-center justify-center bg-white rounded-full text-gray-800 shadow-md hover:bg-yellow-400 hover:scale-110 hover:shadow-lg transition-all duration-300">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 32 32">
                                        <path d="M16.656 1.029c1.637-0.025 3.262-0.012 4.886-0.025 0.054 2.031 0.878 3.859 2.189 5.213l-0.002-0.002c1.411 1.271 3.247 2.095 5.271 2.235l0.028 0.002v5.036c-1.912-0.048-3.71-0.489-5.331-1.247l0.082 0.034c-0.784-0.377-1.447-0.764-2.077-1.196l0.052 0.034c-0.012 3.649 0.012 7.298-0.025 10.934-0.103 1.853-0.719 3.543-1.707 4.954l0.020-0.031c-1.652 2.366-4.328 3.919-7.371 4.011l-0.014 0c-0.123 0.006-0.268 0.009-0.414 0.009-1.73 0-3.347-0.482-4.725-1.319l0.040 0.023c-2.508-1.509-4.238-4.091-4.558-7.094l-0.004-0.041c-0.025-0.625-0.037-1.25-0.012-1.862 0.49-4.779 4.494-8.476 9.361-8.476 0.547 0 1.083 0.047 1.604 0.136l-0.056-0.008c0.025 1.849-0.050 3.699-0.050 5.548-0.423-0.153-0.911-0.242-1.42-0.242-1.868 0-3.457 1.194-4.045 2.861l-0.009 0.030c-0.133 0.427-0.21 0.918-0.21 1.426 0 0.206 0.013 0.41 0.037 0.61l-0.002-0.024c0.332 2.046 2.086 3.59 4.201 3.59 0.061 0 0.121-0.001 0.181-0.004l-0.009 0c1.463-0.044 2.733-0.831 3.451-1.994l0.010-0.018c0.267-0.372 0.45-0.822 0.511-1.311l0.001-0.014c0.125-2.237 0.075-4.461 0.087-6.698 0.012-5.036-0.012-10.060 0.025-15.083z"/>
                                    </svg>
                                </a>`;
                    }

                    html += `
                            </div>`;
                }

                html += `
                            </div>
                            <!-- Member type logo badge -->
                            <div class="absolute -bottom-10 right-4 z-20 pointer-events-none select-none">
                                <img src="${(() => {
                                    const slug = member.member_types?.[0]?.slug || 'master';
                                    const logoMap = {
                                        'top-trainer': '/images/top_trainer_logo.png',
                                        'trainer': '/images/trainer_logo.png',
                                        'master': '/images/master_logo.png'
                                    };
                                    return logoMap[slug] || '/images/master_logo.png';
                                })()}" alt="${memberTypeDisplay}" class="w-20 h-20 rounded-full shadow-lg border-2 border-white" draggable="false">
                            </div>
                        </div>

                        <!-- Content section -->
                        <div class="p-4 pt-8 flex flex-col flex-1">
                            <!-- Name - split into two lines only if very long (>18 chars) -->
                            <h3 class="font-bold text-lg text-gray-900 mb-2 leading-tight">
                                ${(masterTitle.length > 28 && masterTitle.includes(' ')) ? masterTitle.replace(' ', '<br>') : masterTitle}
                            </h3>`;

                // Treatments
                if (treatments.length > 0) {
                    html += `
                            <div class="flex flex-wrap gap-1.5 mb-3">`;
                    treatments.forEach(treatment => {
                        html += `<span class="px-2 py-0.5 text-xs font-medium text-gray-600 bg-gray-100 rounded-md">${treatment.title}</span>`;
                    });
                    html += `
                            </div>`;
                }

                html += `
                            <!-- Spacer to push location to bottom -->
                            <div class="flex-1"></div>

                            <!-- Location -->
                            <div class="flex items-center gap-2 text-sm text-gray-500 mt-3 pt-3 border-t border-gray-100">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span onclick="filterByLocation('${location.replace(/'/g, "\\'")}')"
                                    class="cursor-pointer hover:text-yellow-500 transition-colors truncate">
                                    ${location}
                                </span>
                            </div>`;

                // Email
                if (email) {
                    html += `
                            <div class="flex items-center gap-2 text-sm text-gray-500 mt-2">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <a href="mailto:${email}"
                                    class="hover:text-yellow-500 transition-colors truncate">
                                    ${email}
                                </a>
                            </div>`;
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

        // Name search: trigger on Enter or debounced input
        let nameSearchTimeout;
        const searchNameEl = document.getElementById('search_name');
        searchNameEl.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                clearTimeout(nameSearchTimeout);
                loadMembers();
            }
        });
        searchNameEl.addEventListener('input', function() {
            clearTimeout(nameSearchTimeout);
            document.getElementById('clear-search').classList.toggle('hidden', !this.value.trim());
            nameSearchTimeout = setTimeout(() => loadMembers(), 500);
        });

        // Location autocomplete functionality
        let locationTimeout;
        const locationInput = document.getElementById('location');
        const suggestionsDiv = document.getElementById('location-suggestions');

        locationInput.addEventListener('input', function () {
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

        function clearSearch() {
            searchNameEl.value = '';
            document.getElementById('clear-search').classList.add('hidden');
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

        // Hide dropdowns when clicking outside
        document.addEventListener('click', function (event) {
            if (!locationInput.contains(event.target) && !suggestionsDiv.contains(event.target)) {
                suggestionsDiv.classList.add('hidden');
            }
            const sortWrapper = document.getElementById('sort-dropdown-wrapper');
            if (!sortWrapper.contains(event.target)) {
                document.getElementById('sort-dropdown').classList.add('hidden');
            }
        });
    </script>
@endsection