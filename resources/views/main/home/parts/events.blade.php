{{-- Debug: Events count: {{ count($upcomingEvents ?? []) }} --}}
@if(isset($upcomingEvents) && count($upcomingEvents) > 0)
<div class="overflow-hidden">
    <section class="c-sheet splide splide--arrows-bottom pt-20 md:pt-28" data-carousel-row id="events">
        <h2 class="b-h1 mb-6 md:text-center md:mb-14 aos-init" data-aos="fade-up">
            {{ __('Upcoming') }} <span class="u-text--primary italic px-2 -mx-2">{{ __('events') }}</span>
        </h2>
        <div class="splide__body md:max-xl:mx-6 aos-init" data-aos="fade-up">
            <div class="splide__arrows aos-init" data-aos="fade-up">
                <button class="splide__arrow splide__arrow--prev">
                    @svg('arrow-ltr', '-scale-x-1')
                </button>
                <button class="splide__arrow splide__arrow--next">
                    @svg('arrow-ltr')
                </button>
            </div>
            <div class="splide__track overflow-visible -mx-6">
                <div class="splide__list">
                    @foreach($upcomingEvents as $event)
                        @php
                            $location = $event['acf_fields']['location']['address'] ?? '';
                            $firstTechnique = !empty($event['acf_fields']['technique']) ? $event['acf_fields']['technique'][0] : '';
                            $queryParams = [];
                            if ($location) $queryParams['location'] = $location;
                            if ($firstTechnique) $queryParams['technique'] = $firstTechnique;
                            $eventsUrl = route('events.index', $queryParams);
                        @endphp
                        <div class="splide__slide pl-6 md:pr-6">
                            <a href="{{ $eventsUrl }}" class="block cursor-pointer transition-opacity hover:opacity-80">
                                <article class="relative flex flex-col-reverse text-sm">
                                    <div class="flex flex-col">
                                        <h3 class="text-lg italic u-text--primary mb-1">
                                            @if(!empty($event['acf_fields']['course']))
                                                {{ $event['acf_fields']['course'][0]['title'] ?? '' }}:
                                            @endif
                                            @if(!empty($event['acf_fields']['treatments']))
                                                {{ $event['acf_fields']['treatments'][0]['title'] ?? '' }}
                                            @endif
                                            @if(!empty($event['acf_fields']['master']['title']))
                                                by {{ $event['acf_fields']['master']['title'] }}
                                            @endif
                                        </h3>

                                        @if(!empty($event['acf_fields']['date']))
                                            <dl class="mb-1">
                                                <dt class="sr-only">Date</dt>
                                                <dd>
                                                    @php
                                                        $date = \Carbon\Carbon::createFromFormat('d-m-Y', $event['acf_fields']['date']);
                                                    @endphp
                                                    {{ $date->format('d F, Y') }}
                                                </dd>
                                            </dl>
                                        @endif

                                        @if(!empty($event['acf_fields']['location']['address']))
                                            <dl class="mb-1">
                                                <dt class="sr-only">Location</dt>
                                                <dd>{{ $event['acf_fields']['location']['address'] }}</dd>
                                            </dl>
                                        @endif
                                    </div>
                                    <img
                                        width="224"
                                        height="224"
                                        data-src="{{ $event['acf_fields']['master']['featured_image_url'] ?? asset('static/images/placeholder.png') }}"
                                        data-srcset="{{ $event['acf_fields']['master']['featured_image_url'] ?? asset('static/images/placeholder.png') }} 2x"
                                        alt="{{ $event['acf_fields']['master']['title'] ?? 'Event' }}"
                                        class="lazy aspect-square rounded mb-4"
                                    >
                                </article>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</div>
@endif
