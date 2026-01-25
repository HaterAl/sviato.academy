<footer class="bg-white border-t border-gray-200">
    <div class="c-sheet py-12">
        <!-- Main Content -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-8">

            <!-- Brand Section -->
            <div>
                <a href="{{ route('home') }}" class="inline-block mb-4" title="Sviato Academy">
                    <img
                        src="{{ Vite::asset('resources/images/logo.svg') }}"
                        width="90"
                        height="90"
                        class="w-20 h-auto"
                        alt="Sviato Academy"
                    >
                </a>
                <p class="text-sm text-gray-600 leading-relaxed mb-6">
                    World-class permanent make-up training institution.
                </p>

                <!-- Social Links -->
                <div class="flex gap-4">
                    <a href="https://www.instagram.com/sviato_academy"
                       rel="nofollow noopener"
                       target="_blank"
                       class="text-gray-400 hover:text-gray-900 transition-colors"
                       aria-label="Instagram">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    <a href="https://www.tiktok.com/@sviatoacademy"
                       rel="nofollow noopener"
                       target="_blank"
                       class="text-gray-400 hover:text-gray-900 transition-colors"
                       aria-label="TikTok">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-1-.05A6.33 6.33 0 005 20.1a6.34 6.34 0 0010.86-4.43v-7a8.16 8.16 0 004.77 1.52v-3.4a4.85 4.85 0 01-1-.1z"/>
                        </svg>
                    </a>
                    <a href="https://t.me/sviatoacademy"
                       rel="nofollow noopener"
                       target="_blank"
                       class="text-gray-400 hover:text-gray-900 transition-colors"
                       aria-label="Telegram">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69a.2.2 0 00-.05-.18c-.06-.05-.14-.03-.21-.02-.09.02-1.49.95-4.22 2.79-.4.27-.76.41-1.08.4-.36-.01-1.04-.2-1.55-.37-.63-.2-1.12-.31-1.08-.66.02-.18.27-.36.74-.55 2.92-1.27 4.86-2.11 5.83-2.51 2.78-1.16 3.35-1.36 3.73-1.36.08 0 .27.02.39.12.1.08.13.19.14.27-.01.06.01.24 0 .38z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Navigation Links -->
            <div>
                <h3 class="font-bold text-gray-900 mb-4">Navigation</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900 transition-colors">Home</a></li>
                    <li><a href="{{ route('about.index') }}" class="text-gray-600 hover:text-gray-900 transition-colors">About</a></li>
                    <li><a href="{{ route('events.index') }}" class="text-gray-600 hover:text-gray-900 transition-colors">Events</a></li>
                    <li><a href="{{ route('community.index') }}" class="text-gray-600 hover:text-gray-900 transition-colors">Community</a></li>
                    <li><a href="{{ route('products.index') }}" class="text-gray-600 hover:text-gray-900 transition-colors">Products</a></li>
                    <li><a href="{{ route('contact-us.index') }}" class="text-gray-600 hover:text-gray-900 transition-colors">Contact</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h3 class="font-bold text-gray-900 mb-4">Contact</h3>
                <div class="space-y-3 text-sm">
                    @if ($phone = config('contacts.phone'))
                    <div>
                        <p class="text-gray-500 text-xs mb-1">Phone</p>
                        <a href="tel:{{ str_replace(' ', '', $phone) }}" class="text-gray-900 hover:u-text--primary transition-colors">
                            {{ $phone }}
                        </a>
                    </div>
                    @endif

                    @if ($email = config('contacts.email'))
                    <div>
                        <p class="text-gray-500 text-xs mb-1">Email</p>
                        <a href="mailto:{{ $email }}" class="text-gray-900 hover:u-text--primary transition-colors">
                            {{ $email }}
                        </a>
                    </div>
                    @endif

                    @if ($address = config('contacts.address'))
                    <div>
                        <p class="text-gray-500 text-xs mb-1">Address</p>
                        <div class="text-gray-900">
                            {!! $address !!}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Bottom Section -->
        <div class="pt-8 border-t border-gray-200">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-sm text-gray-500">
                <p>© {{ now()->format('Y') }} Sviato Academy. All rights reserved.</p>
                <div class="flex gap-6">
                    <a href="{{ route('privacy-policy.index') }}" class="hover:text-gray-900 transition-colors">Privacy</a>
                    <a href="{{ route('terms-and-conditions.index') }}" class="hover:text-gray-900 transition-colors">Terms</a>
                </div>
            </div>
        </div>
    </div>
</footer>
