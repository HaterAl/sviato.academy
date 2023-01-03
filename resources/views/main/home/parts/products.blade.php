<div class="overflow-hidden">
    <section class="c-sheet splide splide--arrows-center splide--branded pt-20 md:pt-28" data-carousel-showcase  id="products">
        <h2 class="b-h1 text-center mb-20 aos-init" data-aos="fade-up">
            {{ __('Our') }} <span class="u-text--primary px-2 -mx-2 italic">{{ __('products') }}</span>
        </h2>
        <div class="relative aos-init" data-aos="fade-up">
            <div class="splide__arrows aos-init" data-aos="fade-up">
                <button class="splide__arrow splide__arrow--prev">
                    @svg('arrow-ltr', '-scale-x-1')
                </button>
                <button class="splide__arrow splide__arrow--next">
                    @svg('arrow-ltr')
                </button>
            </div>
            <div class="splide__track overflow-visible mx-auto md:w-3/5">
                <div class="splide__list">
                    @foreach(config('products.list') as $product)
                        <article class="splide__slide text-center md:px-12">
                            <h3 class="mb-8">
                                <a href="{{ $product['url'] }}" target="_blank" rel="nofollow noopener" class="splide__slide__link">
                                    {{ $product['name'] }}
                                </a>
                            </h3>
                            <div class="splide__slide__img mb-16">
                                <img
                                    width="358"
                                    height="358"
                                    data-src="{{ asset($product['img']['1x']) }}"
                                    data-srcset="{{ asset($product['img']['2x']) }} 2x"
                                    alt="{{ $product['name'] }}"
                                    class="lazy aspect-square relative"
                                >
                            </div>
                            <dl>
                                <dt class="sr-only">Price</dt>
                                <dd class="u-text--primary b-h3">€{{ number_format($product['price'], 2) }}</dd>
                            </dl>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</div>
