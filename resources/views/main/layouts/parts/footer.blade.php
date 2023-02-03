<footer class="pt-20 pb-5 c-sheet md:pt-28" id="contacts">
    <div class="justify-between mb-20 -mx-4 md:flex">
        <dl class="flex flex-col justify-between px-4 b-h4">
            @if ($phone = config('contacts.phone'))
                <dt class="sr-only">{{ __('Phone number') }}:</dt>
                <dd class="mb-3 text-gray-100 aos-init aos-animate" data-aos="fade-up">
                    <a href="tel:{{ str_replace(' ', '', $phone) }}">
                        {{ $phone }}
                    </a>
                </dd>
            @endif
            @if ($email = config('contacts.email'))
                <dt class="sr-only">{{ __('Email address') }}:</dt>
                <dd class="u-text--primary aos-init aos-animate" data-aos="fade-up">
                    <a href="mailto:{{ $email }}">
                        {{ $email }}
                    </a>
                </dd>
            @endif
        </dl>
        @if ($address = config('contacts.address'))
            <dl class="px-4 text-gray-100 b-h6 aos-init aos-animate" data-aos="fade-up">
                <dt class="sr-only">{{ __('Address') }}:</dt>
                <dd>
                    {!! $address !!}
                </dd>
            </dl>
        @endif
    </div>
    <div class="justify-between -mx-4 md:flex">
        <div class="px-4 mb-3 md:mb-0">© {{ now()->format('Y') }} SVIATO.ACADEMY</div>
        <div class="px-4 lowercase">
            <a class="flex gap-x-1" rel="nofollow noopener" target="_blank" href="https://www.ideil.com/">
                made by
                <span class="sr-only">ideil.</span>
                <img src="{{ Vite::asset('resources/images/ideil.svg') }}" width="42" height="14" alt="ideil">
            </a>
        </div>
    </div>
</footer>
