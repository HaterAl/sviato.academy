@extends('main.layouts.base')

@section('content')
    <section class="p-4">
        <div class="container mx-auto">
            <section class="py-12">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mb-12">
                        <h2 class="font-manrope text-center font-bold text-gray-900 u-text--primary italic">Our Products</h2>
                        <p class="text-center leading-6 mt-4">Discover our <span class="u-text--primary">premium selection</span> of <span class="u-text--primary">professional PMU products and supplies</span>.</p>
                    </div>

                    {{-- Category filter --}}
                    <div class="mb-8 md:flex md:justify-end">
                        <div class="md:w-[500px]">
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
                        <div class="grid gap-6" style="grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));" id="products-grid">
                            @foreach($products as $product)
                                    <a href="{{ $product['link'] }}" target="_blank" class="bg-white rounded-2xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl hover:scale-105 flex flex-col" style="height: 400px;">
                                        <div class="flex flex-col flex-1 p-6 justify-center" style="background-color: #F5F6FA;">
                                            <div class="flex justify-center mb-3">
                                                <div class="w-40 h-44 overflow-hidden">
                                                    <img src="{{ $product['image'] }}"
                                                         alt="{{ $product['title'] }}"
                                                         class="w-full h-full object-cover"
                                                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($product['title']) }}&size=300&background=f3f4f6&color=6b7280'">
                                                </div>
                                            </div>
                                            <div class="text-center mb-3">
                                                <h3 class="font-bold text-lg text-gray-900 line-clamp-2">{{ $product['title'] }}</h3>
                                            </div>
                                            <div class="border-t border-gray-200 my-3"></div>
                                            <div class="text-center">
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
                                    </a>
                            @endforeach
                        </div>

                        {{-- New minimalist style (commented) --}}
                        {{--
                        <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8" id="products-grid">
                            @foreach($products as $product)
                                <a href="{{ $product['link'] }}" target="_blank" class="group">
                                    <img
                                        src="{{ $product['image'] }}"
                                        alt="{{ $product['title'] }}"
                                        class="aspect-square w-full rounded-lg bg-gray-200 object-cover group-hover:opacity-75 xl:aspect-[7/8]"
                                        onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($product['title']) }}&size=300&background=f3f4f6&color=6b7280'">
                                    <h3 class="mt-4 text-sm text-gray-700">{{ $product['title'] }}</h3>
                                    @if(!empty($product['sale_price']))
                                        <div class="mt-1 flex items-center gap-2">
                                            <p class="text-lg font-medium text-red-600">{{ $product['sale_price'] }}</p>
                                            <p class="text-sm text-gray-500 line-through">{{ $product['price'] }}</p>
                                        </div>
                                    @else
                                        <p class="mt-1 text-lg font-medium text-gray-900">{{ $product['price'] }}</p>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                        --}}

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
                    </div>
                </div>
            </section>
        </div>
    </section>

    <script>
        // Load products via AJAX
        async function loadProducts(page = 1, category = 'all') {
            const container = document.getElementById('products-container');

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

            let html = '<div class="grid gap-6" style="grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));" id="products-grid">';

            products.forEach(product => {
                const title = product.title || 'N/A';
                const image = product.image || `https://ui-avatars.com/api/?name=${encodeURIComponent(title)}&size=300&background=f3f4f6&color=6b7280`;
                const price = product.price || '';
                const salePrice = product.sale_price || '';
                const link = product.link || '#';

                html += `
                    <a href="${link}" target="_blank" class="bg-white rounded-2xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl hover:scale-105 flex flex-col" style="height: 400px;">
                        <div class="flex flex-col flex-1 p-6 justify-center" style="background-color: #F5F6FA;">
                            <div class="flex justify-center mb-3">
                                <div class="w-40 h-44 overflow-hidden">
                                    <img src="${image}" alt="${title}" class="w-full h-full object-cover" onerror="this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(title)}&size=300&background=f3f4f6&color=6b7280'">
                                </div>
                            </div>
                            <div class="text-center mb-3">
                                <h3 class="font-bold text-lg text-gray-900 line-clamp-2">${title}</h3>
                            </div>
                            <div class="border-t border-gray-200 my-3"></div>
                            <div class="text-center">
                                ${salePrice ? `
                                    <div class="flex items-center justify-center gap-2">
                                        <span class="text-2xl font-bold text-red-600">${salePrice}</span>
                                        <span class="text-lg text-gray-500 line-through">${price}</span>
                                    </div>
                                ` : `<span class="text-2xl font-bold text-gray-900">${price}</span>`}
                            </div>
                        </div>
                    </a>`;
            });

            html += '</div>';

            // New minimalist style (commented)
            /*
            let html = '<div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8" id="products-grid">';
            products.forEach(product => {
                const title = product.title || 'N/A';
                const image = product.image || `https://ui-avatars.com/api/?name=${encodeURIComponent(title)}&size=300&background=f3f4f6&color=6b7280`;
                const price = product.price || '';
                const salePrice = product.sale_price || '';
                const link = product.link || '#';

                html += `
                    <a href="${link}" target="_blank" class="group">
                        <img
                            src="${image}"
                            alt="${title}"
                            class="aspect-square w-full rounded-lg bg-gray-200 object-cover group-hover:opacity-75 xl:aspect-[7/8]"
                            onerror="this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(title)}&size=300&background=f3f4f6&color=6b7280'">
                        <h3 class="mt-4 text-sm text-gray-700">${title}</h3>`;

                if (salePrice) {
                    html += `
                        <div class="mt-1 flex items-center gap-2">
                            <p class="text-lg font-medium text-red-600">${salePrice}</p>
                            <p class="text-sm text-gray-500 line-through">${price}</p>
                        </div>`;
                } else {
                    html += `<p class="mt-1 text-lg font-medium text-gray-900">${price}</p>`;
                }

                html += `</a>`;
            });
            html += '</div>';
            */

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

        // Set category filter from URL on page load
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const category = urlParams.get('category') || 'all';

            // Set category filter if exists in URL
            const categoryFilter = document.getElementById('category-filter');
            if (categoryFilter && category) {
                categoryFilter.value = category;
            }
        });
    </script>
@endsection
