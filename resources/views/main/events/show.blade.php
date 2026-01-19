@extends('main.layouts.base')

@section('content')
    @php
        $eventData = $event['data'] ?? $event;
    @endphp

    <section class="py-12 md:py-20" style="background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);">
        <div class="container mx-auto px-4">
            <!-- Back button -->
            <div class="mb-8">
                <a href="{{ route('events.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 font-semibold transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Events
                </a>
            </div>

            <div class="max-w-6xl mx-auto">
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
                    <div class="grid md:grid-cols-2 gap-0">
                        <!-- Left side: Master info and event details -->
                        <div class="p-8 md:p-12 flex flex-col items-center justify-center relative" style="background-color: #1a1a1a;">
                            <!-- Texture overlay -->
                            <div class="absolute inset-0 opacity-5" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

                            <!-- Content wrapper with z-index -->
                            <div class="relative z-10 flex flex-col items-center w-full">
                                <!-- Master Avatar -->
                                <div class="mb-8">
                                    @if(!empty($eventData['acf_fields']['master']['featured_image_url']))
                                        <div class="relative">
                                            <div class="w-48 h-48 md:w-64 md:h-64 rounded-full overflow-hidden border-8 border-white shadow-2xl">
                                                <img src="{{ $eventData['acf_fields']['master']['featured_image_url'] }}"
                                                     alt="{{ $eventData['acf_fields']['master']['title'] }}"
                                                     class="w-full h-full object-cover">
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Master Name -->
                                <div class="text-center mb-8">
                                    <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">
                                        {{ $eventData['acf_fields']['master']['title'] ?? 'N/A' }}
                                    </h1>
                                    <p class="text-xl text-white opacity-90">Master</p>
                                </div>

                                <!-- Course/Treatment badges -->
                                <div class="flex flex-wrap gap-3 justify-center mb-8">
                                    @if(!empty($eventData['acf_fields']['treatments']))
                                        @foreach($eventData['acf_fields']['treatments'] as $treatment)
                                            <span class="px-6 py-2 bg-white text-gray-800 rounded-full text-sm font-semibold shadow-lg">
                                                {{ $treatment['title'] }}
                                            </span>
                                        @endforeach
                                    @endif
                                    @if(!empty($eventData['acf_fields']['course']))
                                        @foreach($eventData['acf_fields']['course'] as $course)
                                            <span class="px-6 py-2 bg-white text-gray-800 rounded-full text-sm font-semibold shadow-lg">
                                                {{ $course['title'] }}
                                            </span>
                                        @endforeach
                                    @endif
                                </div>

                                <!-- Event Details -->
                                <div class="w-full max-w-sm space-y-4">
                                    @if(!empty($eventData['acf_fields']['technique']))
                                        <div class="bg-white bg-opacity-10 rounded-2xl p-5 border border-white border-opacity-20">
                                            <h3 class="text-sm font-semibold uppercase text-white opacity-70 mb-2">Technique</h3>
                                            <p class="font-medium text-white text-base">
                                                @foreach($eventData['acf_fields']['technique'] as $technique)
                                                    {{ $technique }}{{ !$loop->last ? ', ' : '' }}
                                                @endforeach
                                            </p>
                                        </div>
                                    @endif

                                    <div class="bg-white bg-opacity-10 rounded-2xl p-5 border border-white border-opacity-20">
                                        <h3 class="text-sm font-semibold uppercase text-white opacity-70 mb-2">Location</h3>
                                        <p class="font-medium text-white text-base">{{ $eventData['acf_fields']['location']['address'] ?? 'N/A' }}</p>
                                    </div>

                                    <div class="bg-white bg-opacity-10 rounded-2xl p-5 border border-white border-opacity-20">
                                        <h3 class="text-sm font-semibold uppercase text-white opacity-70 mb-2">Date</h3>
                                        <p class="font-bold text-white text-lg">{{ $eventData['acf_fields']['date'] ?? 'N/A' }}</p>
                                    </div>

                                    @if(!empty($eventData['acf_fields']['duration']))
                                        <div class="bg-white bg-opacity-10 rounded-2xl p-5 border border-white border-opacity-20">
                                            <h3 class="text-sm font-semibold uppercase text-white opacity-70 mb-2">Duration</h3>
                                            <p class="font-medium text-white text-base">{{ $eventData['acf_fields']['duration'] }} days</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Right side: Contact Form -->
                        <div class="p-8 md:p-12 bg-gray-50">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6">Book Your Spot</h2>

                            <form action="#" method="POST" class="space-y-5">
                                @csrf

                                <!-- Full Name -->
                                <div>
                                    <label for="full_name" class="block text-sm font-semibold text-gray-700 mb-2">Full name</label>
                                    <input type="text"
                                           id="full_name"
                                           name="full_name"
                                           placeholder="Name Surname"
                                           required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                                    <input type="email"
                                           id="email"
                                           name="email"
                                           placeholder="your@email.com"
                                           required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone Number</label>
                                    <input type="tel"
                                           id="phone"
                                           name="phone"
                                           placeholder="+1234567890"
                                           required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                </div>

                                <!-- Message -->
                                <div>
                                    <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">Message</label>
                                    <textarea id="message"
                                              name="message"
                                              rows="4"
                                              placeholder="Type your message here..."
                                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all resize-none"></textarea>
                                </div>

                                <!-- Privacy Policy -->
                                <div class="flex items-start">
                                    <input type="checkbox"
                                           id="accept"
                                           name="accept"
                                           required
                                           class="mt-1 w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                                    <label for="accept" class="ml-3 text-sm text-gray-600">
                                        I have read and agree with <a href="#" class="text-purple-600 hover:text-purple-700 font-semibold">Privacy Policy</a>
                                    </label>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit"
                                        style="background: linear-gradient(to right, #ffda55, #ca9d00); color: rgb(12, 12, 13);"
                                        class="w-full py-4 px-6 rounded-xl font-bold text-base shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                    Send Message
                                </button>

                                <!-- Direct Contact -->
                                @if(!empty($eventData['acf_fields']['organiser_email_1']))
                                    <div class="pt-4 text-center border-t border-gray-200">
                                        <p class="text-sm text-gray-600 mb-3">Or contact organizer directly:</p>
                                        <a href="mailto:{{ $eventData['acf_fields']['organiser_email_1'] }}"
                                           class="inline-flex items-center text-purple-600 hover:text-purple-700 font-semibold">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                            {{ $eventData['acf_fields']['organiser_email_1'] }}
                                        </a>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>

                    <!-- Additional Description -->
                    @if(!empty($eventData['acf_fields']['description']))
                        <div class="p-8 md:p-12 border-t border-gray-200">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6">About this Event</h3>
                            <div class="prose max-w-none text-gray-700">
                                {!! $eventData['acf_fields']['description'] !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
