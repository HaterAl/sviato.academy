<footer class="c-sheet pt-20 pb-28 md:pt-28 md:pb-36">
    <div class="-mx-4 md:flex justify-between">
        <dl class="b-h4 px-4 flex flex-col justify-between">
            @if ($phone = config('contacts.phone'))
                <dt class="sr-only">{{ __('Phone number') }}:</dt>
                <dd class="text-gray-100 mb-3 aos-init" data-aos="fade-up">
                    <a href="tel:{{ str_replace(' ', '', $phone) }}">
                        {{ $phone }}
                    </a>
                </dd>
            @endif
            @if ($email = config('contacts.email'))
                <dt class="sr-only">{{ __('Email address') }}:</dt>
                <dd class="u-text--primary aos-init" data-aos="fade-up">
                    <a href="mailto:{{ $email }}">
                        {{ $email }}
                    </a>
                </dd>
            @endif
        </dl>
        @if ($address = config('contacts.address'))
            <dl class="b-h6 text-gray-100 px-4 aos-init" data-aos="fade-up">
                <dt class="sr-only">{{ __('Address') }}:</dt>
                <dd>
                    {!! $address !!}
                </dd>
            </dl>
        @endif
    </div>
</footer>
