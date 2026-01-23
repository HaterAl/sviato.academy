@extends('main.layouts.base')

@section('content')
    <section class="p-4">
        <div class="container mx-auto">
            <section class="py-12">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mb-12">
                        <h2 class="font-manrope text-center font-bold text-gray-900 u-text--primary italic">Our Products</h2>
                        <p class="u-text--primary text-center leading-6 mt-4">Discover our premium selection of professional PMU products and supplies.</p>
                    </div>

                    {{-- Category filter --}}
                    <div class="mb-8 md:flex md:justify-end">
                        <div class="md:w-[600px]">
                            <select id="category-filter" onchange="handleCategoryChange()" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:border-yellow-500 transition-colors duration-300 bg-white text-gray-900 font-semibold cursor-pointer">
                                <option value="all">All Categories</option>
                                <option value="aftercare products">Aftercare Products</option>
                                <option value="kits">Kits</option>
                                <option value="machines">Machines</option>
                                <option value="microblading blades & tools">Microblading Blades & Tools</option>
                                <option value="pmu cartridges">PMU Cartridges</option>
                                <option value="pigments">Pigments</option>
                                <option value="removal products">Removal products</option>
                                <option value="sale">SALE!</option>
                                <option value="training">Training</option>
                                <option value="treatment tools">Treatment Tools</option>
                            </select>
                        </div>
                    </div>

                    <div id="products-container">
                        @if(count($products) > 0)
                            <div class="grid gap-6 items-stretch" style="grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));" id="products-grid">
                                @foreach($products as $product)
                                    <a href="{{ $product['link'] }}" target="_blank" class="bg-white rounded-2xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl flex flex-col h-full transform hover:scale-[1.03] group">
                                        <div class="flex flex-col flex-1 p-6" style="background-color: #F5F6FA;">
                                            <!-- Product image -->
                                            <div class="flex justify-center mb-4">
                                                <div class="w-40 h-44 overflow-hidden">
                                                    <img src="{{ $product['image'] }}"
                                                         alt="{{ $product['title'] }}"
                                                         class="w-full h-full object-cover"
                                                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($product['title']) }}&size=300&background=f3f4f6&color=6b7280'">
                                                </div>
                                            </div>

                                            <!-- Product title -->
                                            <div class="text-center mb-4 flex-1">
                                                <h3 class="font-bold text-lg text-gray-900 line-clamp-2">{{ $product['title'] }}</h3>
                                            </div>

                                            <!-- Separator -->
                                            <div class="border-t border-gray-200 my-4"></div>

                                            <!-- Price section -->
                                            <div class="text-center mb-4">
                                                @if(!empty($product['sale_price']))
                                                    <div class="flex items-center justify-center gap-2">
                                                        <span class="text-2xl font-bold text-red-600">{{ $product['sale_price'] }}</span>
                                                        <span class="text-lg text-gray-500 line-through">{{ $product['price'] }}</span>
                                                    </div>
                                                @else
                                                    <span class="text-2xl font-bold text-gray-900">{{ $product['price'] }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Buy button -->
                                        <div style="background: linear-gradient(to right, #ffda55, #ca9d00); color: rgb(12, 12, 13);"
                                             class="md:opacity-0 md:group-hover:opacity-100 block w-full text-center py-4 font-bold text-sm shadow-lg transition-all duration-300">
                                            Buy Now
                                        </div>
                                    </a>
                                @endforeach
                            </div>

                            @if(!empty($pagination) && $pagination['total_pages'] > 1)
                                <div class="mt-12 flex justify-center items-center gap-4">
                                    @if($pagination['page'] > 1)
                                        <button onclick="loadProducts({{ $pagination['page'] - 1 }}, document.getElementById('category-filter').value)"
                                                class="py-2.5 px-5 bg-gray-600 shadow-sm rounded-2xl transition-all duration-500 text-base text-white font-semibold text-center hover:bg-gray-700">
                                            Previous
                                        </button>
                                    @endif

                                    <span class="text-gray-700 font-semibold">
                                        Page {{ $pagination['page'] }} of {{ $pagination['total_pages'] }}
                                    </span>

                                    @if($pagination['page'] < $pagination['total_pages'])
                                        <button onclick="loadProducts({{ $pagination['page'] + 1 }}, document.getElementById('category-filter').value)"
                                                class="py-2.5 px-5 bg-gray-600 shadow-sm rounded-2xl transition-all duration-500 text-base text-white font-semibold text-center hover:bg-gray-700">
                                            Next
                                        </button>
                                    @endif
                                </div>
                            @endif
                        @else
                            <!-- Skeleton Loader -->
                            <div id="products-skeleton" class="grid gap-6 items-stretch" style="grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));">
                                @for ($i = 0; $i < 20; $i++)
                                    <div class="bg-white rounded-2xl shadow-md overflow-hidden flex flex-col h-full">
                                        <div class="p-6 flex flex-col flex-1">
                                            <!-- Image skeleton -->
                                            <div class="flex justify-center mb-4">
                                                <div class="w-40 h-40 bg-gray-100 rounded-full"></div>
                                            </div>

                                            <!-- Title skeleton -->
                                            <div class="text-center mb-4">
                                                <div class="h-6 bg-gray-100 rounded w-3/4 mx-auto mb-2"></div>
                                            </div>

                                            <!-- Separator -->
                                            <div class="border-t border-gray-200 my-4"></div>

                                            <!-- Price skeleton -->
                                            <div class="text-center mb-4">
                                                <div class="h-8 bg-gray-100 rounded w-1/2 mx-auto"></div>
                                            </div>
                                        </div>

                                        <!-- Button skeleton -->
                                        <div class="p-4 border-t border-gray-200">
                                            <div class="h-10 bg-gray-100 rounded-xl"></div>
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
        let isFirstLoad = true;

        // Load products via AJAX
        async function loadProducts(page = 1, category = 'all') {
            const container = document.getElementById('products-container');

            // Scroll to container with offset only during pagination (not on first load)
            if (!isFirstLoad) {
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
            }

            isFirstLoad = false;

            const params = new URLSearchParams();
            if (page > 1) params.append('page', page);
            if (category && category !== 'all') params.append('category', category);

            const newUrl = params.toString() ? `{{ route('products.index') }}?${params.toString()}` : '{{ route('products.index') }}';
            window.history.pushState({}, '', newUrl);

            try {
                const response = await fetch(newUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) throw new Error('Failed to load products');

                const data = await response.json();

                renderProducts(data.products, data.pagination);
            } catch (error) {
                console.error('Error loading products:', error);
                container.innerHTML = '<div class="text-center py-12"><p class="u-text--primary text-xl">Failed to load products. Please try again.</p></div>';
            } finally {
                container.style.filter = '';
                container.style.pointerEvents = '';
                container.style.opacity = '';
            }
        }

        // Handle category filter change
        function handleCategoryChange() {
            const select = document.getElementById('category-filter');
            const category = select.value;
            loadProducts(1, category);
        }

        // Render products HTML
        function renderProducts(products, pagination) {
            const container = document.getElementById('products-container');
            const categoryFilter = document.getElementById('category-filter');
            const currentCategory = categoryFilter ? categoryFilter.value : 'all';

            if (!products || products.length === 0) {
                container.innerHTML = '<div class="text-center py-12"><p class="u-text--primary text-xl">No products available at the moment.</p></div>';
                return;
            }

            let html = '<div class="grid gap-6 items-stretch" style="grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));" id="products-grid">';

            products.forEach(product => {
                const title = product.title || 'N/A';
                const image = product.image || `https://ui-avatars.com/api/?name=${encodeURIComponent(title)}&size=300&background=f3f4f6&color=6b7280`;
                const price = product.price || '';
                const salePrice = product.sale_price || '';
                const availability = product.availability || '';
                const link = product.link || '#';

                // Calculate discount
                const priceNum = parseFloat(price.replace(/[^0-9.]/g, ''));
                const salePriceNum = salePrice ? parseFloat(salePrice.replace(/[^0-9.]/g, '')) : 0;
                const discount = (salePriceNum > 0 && priceNum > 0) ? Math.round(((priceNum - salePriceNum) / priceNum) * 100) : 0;

                html += `
                    <div class="bg-white rounded-2xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl flex flex-col h-full transform hover:scale-[1.03]">
                        <div class="flex flex-col flex-1 p-6" style="background-color: #F5F6FA;">
                            <div class="flex justify-center mb-4">
                                <div class="w-40 h-44 overflow-hidden">
                                    <img src="${image}" alt="${title}" class="w-full h-full object-cover" onerror="this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(title)}&size=300&background=f3f4f6&color=6b7280'">
                                </div>
                            </div>
                            <div class="text-center mb-4 flex-1">
                                <h3 class="font-bold text-lg text-gray-900 line-clamp-2">${title}</h3>
                            </div>
                            <div class="border-t border-gray-200 my-4"></div>
                            <div class="text-center mb-4">`;

                if (salePrice) {
                    html += `
                        <div class="flex items-center justify-center gap-2">
                            <span class="text-2xl font-bold text-red-600">${salePrice}</span>
                            <span class="text-lg text-gray-500 line-through">${price}</span>
                        </div>`;
                } else {
                    html += `<span class="text-2xl font-bold text-gray-900">${price}</span>`;
                }

                html += `
                            </div>
                        </div>
                        <a href="${link}" target="_blank" style="background: linear-gradient(to right, #ffda55, #ca9d00); color: rgb(12, 12, 13);" class="block w-full text-center py-4 font-bold text-sm shadow-lg hover:shadow-xl transition-all duration-300">
                            Buy Now
                        </a>
                    </div>`;
            });

            html += '</div>';

            // Add pagination
            if (pagination && pagination.total_pages > 1) {
                html += '<div class="mt-12 flex justify-center items-center gap-4">';

                if (pagination.page > 1) {
                    html += `<button onclick="loadProducts(${pagination.page - 1}, '${currentCategory}')" class="py-2.5 px-5 bg-gray-600 shadow-sm rounded-2xl transition-all duration-500 text-base text-white font-semibold text-center hover:bg-gray-700">Previous</button>`;
                }

                html += `<span class="text-gray-700 font-semibold">Page ${pagination.page} of ${pagination.total_pages}</span>`;

                if (pagination.page < pagination.total_pages) {
                    html += `<button onclick="loadProducts(${pagination.page + 1}, '${currentCategory}')" class="py-2.5 px-5 bg-gray-600 shadow-sm rounded-2xl transition-all duration-500 text-base text-white font-semibold text-center hover:bg-gray-700">Next</button>`;
                }

                html += '</div>';
            }

            container.innerHTML = html;
        }

        // Auto-load products on page load
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const page = urlParams.get('page') || 1;
            const category = urlParams.get('category') || 'all';

            // Set category filter if exists in URL
            const categoryFilter = document.getElementById('category-filter');
            if (categoryFilter && category) {
                categoryFilter.value = category;
            }

            loadProducts(page, category);
        });
    </script>
@endsection
