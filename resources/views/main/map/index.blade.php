@extends('main.layouts.map')

@section('content')
    <style>
        .map-container {
            position: relative;
            width: 100vw;
            height: 100vh;
            margin-left: calc(-50vw + 50%);
            overscroll-behavior: contain;
        }

        #map {
            width: 100%;
            height: 100%;
            overscroll-behavior: contain;
        }

        .leaflet-popup-content-wrapper {
            background-color: #ffffff;
            color: #1f2937;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            padding: 0;
        }

        .leaflet-popup-content {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            width: 280px !important;
        }

        .leaflet-popup-tip {
            background-color: #ffffff;
        }

        .leaflet-container a.leaflet-popup-close-button {
            color: #6b7280;
            font-size: 24px;
            padding: 12px 12px 0 0;
            font-weight: 300;
        }

        .leaflet-container a.leaflet-popup-close-button:hover {
            color: #DCB04B;
        }

        .popup-card {
            padding: 24px;
            text-align: center;
        }

        .popup-image-wrapper {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .popup-image-gradient {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            padding: 4px;
        }

        .popup-image-border {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid white;
        }

        .popup-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .popup-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 4px;
            color: #1f2937;
        }

        .popup-type {
            display: inline-block;
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 16px;
        }

        .popup-separator {
            border-top: 1px solid #e5e7eb;
            margin: 16px 0;
        }

        .popup-treatments {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 16px;
        }

        .popup-location {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 8px;
        }

        .popup-email {
            font-size: 11px;
            margin-bottom: 16px;
        }

        .popup-email a {
            color: #1f2937 !important;
            text-decoration: none;
            word-break: break-all;
            transition: color 0.2s;
        }

        .popup-email a:hover {
            color: #DCB04B !important;
        }

        .popup-social {
            display: flex;
            gap: 12px;
            padding-top: 16px;
            border-top: 1px solid #e5e7eb;
            justify-content: center;
        }

        .popup-social a {
            color: #1f2937 !important;
            transition: color 0.2s;
        }

        .popup-social a:hover {
            color: #DCB04B !important;
        }

        .map-loader {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
            text-align: center;
            color: #ffffff;
            background-color: rgba(0, 0, 0, 0.8);
            padding: 30px 50px;
            border-radius: 12px;
        }


        .loader-spinner {
            border: 4px solid #374151;
            border-top: 4px solid #DCB04B;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 0 auto 15px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <div class="map-container">
        <div id="map"></div>

        <div id="loader" class="map-loader">
            <div class="loader-spinner"></div>
            <div>Loading trainers map...</div>
        </div>
    </div>

    <script>
        // Initialize the map centered on Europe
        const map = L.map('map', {
            minZoom: 2,
            maxBounds: [
                [-85, -180],  // Southwest corner
                [85, 180]     // Northeast corner
            ],
            maxBoundsViscosity: 1.0, // Makes bounds completely rigid
            worldCopyJump: false,
            zoomControl: false, // Remove zoom buttons
            attributionControl: false // Remove attribution
        }).setView([50.06, 19.94], 6); // Krakow center

        // Add dark tile layer with retina support
        L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
            subdomains: 'abcd',
            maxZoom: 19,
            detectRetina: true,
            updateWhenIdle: false,
            keepBuffer: 2
        }).addTo(map);

        // Fix map size after initialization
        setTimeout(() => {
            map.invalidateSize();
        }, 100);

        // Custom marker icon
        const customIcon = L.icon({
            iconUrl: '/s-marker.svg',
            iconSize: [21, 28],  // 50% smaller
            iconAnchor: [10, 28], // Bottom center point
            popupAnchor: [0, -28]
        });

        // Store markers globally
        const markers = {};

        // Helper functions to encode/decode member ID
        function encodeMemberId(id) {
            return btoa(String(id)).replace(/=/g, '');
        }

        function decodeMemberId(encoded) {
            try {
                return parseInt(atob(encoded));
            } catch(e) {
                return null;
            }
        }

        // Load trainers data with retry
        async function loadTrainers(retryCount = 0) {
            const maxRetries = 3;

            try {
                const response = await fetch('{{ route('map.index') }}', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) throw new Error('Failed to load trainers');

                const data = await response.json();

                if (data.success && data.members && data.members.length > 0) {
                    const bounds = [];

                    data.members.forEach(member => {
                        const lat = parseFloat(member.acf_fields.location.lat);
                        const lng = parseFloat(member.acf_fields.location.lng);

                        if (isNaN(lat) || isNaN(lng)) return;

                        bounds.push([lat, lng]);

                        // Create popup content
                        const memberType = member.member_types?.[0]?.name || 'Member';
                        const treatments = member.acf_fields?.member_treatment || [];
                        const treatmentsText = treatments.map(t => t.title).join(', ');
                        const email = member.acf_fields?.email || '';
                        const instagram = member.acf_fields?.instagram || '';
                        const facebook = member.acf_fields?.facebook || '';
                        const tiktok = member.acf_fields?.tiktok || '';

                        // Random gradient for image border
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
                        const gradient = gradients[Math.floor(Math.random() * gradients.length)];

                        const masterImage = member.featured_image || `https://ui-avatars.com/api/?name=${encodeURIComponent(member.title)}&size=300&background=random&color=fff&bold=true&font-size=0.35`;

                        let popupContent = `<div class="popup-card">`;

                        // Avatar with gradient border
                        popupContent += `
                            <div class="popup-image-wrapper">
                                <div class="popup-image-gradient" style="background: ${gradient}">
                                    <div class="popup-image-border">
                                        <img src="${masterImage}" alt="${member.title}" class="popup-image">
                                    </div>
                                </div>
                            </div>
                        `;

                        // Name and type
                        popupContent += `
                            <div class="popup-title">${member.title}</div>
                            <div class="popup-type">${memberType}</div>
                        `;

                        // Treatments
                        if (treatmentsText) {
                            popupContent += `<div class="popup-separator"></div>`;
                            popupContent += `<div class="popup-treatments">${treatmentsText}</div>`;
                        }

                        // Location and email
                        popupContent += `<div class="popup-separator"></div>`;
                        popupContent += `<div class="popup-location">${member.acf_fields.location.address}</div>`;

                        if (email) {
                            popupContent += `<div class="popup-email"><a href="mailto:${email}">${email}</a></div>`;
                        }

                        // Social links
                        if (instagram || facebook || tiktok) {
                            popupContent += `<div class="popup-social">`;
                            if (instagram) {
                                popupContent += `
                                    <a href="${instagram}" target="_blank" rel="noopener">
                                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                        </svg>
                                    </a>`;
                            }
                            if (facebook) {
                                popupContent += `
                                    <a href="${facebook}" target="_blank" rel="noopener">
                                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                        </svg>
                                    </a>`;
                            }

                            if (tiktok) {
                                popupContent += `
                                    <a href="${tiktok}" target="_blank" rel="noopener">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M16.656 1.029c1.637-0.025 3.262-0.012 4.886-0.025 0.054 2.031 0.878 3.859 2.189 5.213l-0.002-0.002c1.411 1.271 3.247 2.095 5.271 2.235l0.028 0.002v5.036c-1.912-0.048-3.71-0.489-5.331-1.247l0.082 0.034c-0.784-0.377-1.447-0.764-2.077-1.196l0.052 0.034c-0.012 3.649 0.012 7.298-0.025 10.934-0.103 1.853-0.719 3.543-1.707 4.954l0.020-0.031c-1.652 2.366-4.328 3.919-7.371 4.011l-0.014 0c-0.123 0.006-0.268 0.009-0.414 0.009-1.73 0-3.347-0.482-4.725-1.319l0.040 0.023c-2.508-1.509-4.238-4.091-4.558-7.094l-0.004-0.041c-0.025-0.625-0.037-1.25-0.012-1.862 0.49-4.779 4.494-8.476 9.361-8.476 0.547 0 1.083 0.047 1.604 0.136l-0.056-0.008c0.025 1.849-0.050 3.699-0.050 5.548-0.423-0.153-0.911-0.242-1.42-0.242-1.868 0-3.457 1.194-4.045 2.861l-0.009 0.030c-0.133 0.427-0.21 0.918-0.21 1.426 0 0.206 0.013 0.41 0.037 0.61l-0.002-0.024c0.332 2.046 2.086 3.59 4.201 3.59 0.061 0 0.121-0.001 0.181-0.004l-0.009 0c1.463-0.044 2.733-0.831 3.451-1.994l0.010-0.018c0.267-0.372 0.45-0.822 0.511-1.311l0.001-0.014c0.125-2.237 0.075-4.461 0.087-6.698 0.012-5.036-0.012-10.060 0.025-15.083z"></path>
                                        </svg>
                                    </a>`;
                            }
                            popupContent += `</div>`;
                        }

                        popupContent += `</div>`;

                        // Create marker
                        const marker = L.marker([lat, lng], {
                            icon: customIcon
                        }).addTo(map);

                        marker.bindPopup(popupContent, {
                            maxWidth: 300,
                            className: 'custom-popup'
                        });

                        // Remove member parameter from URL when popup is closed
                        marker.on('popupclose', function() {
                            const url = new URL(window.location);
                            url.searchParams.delete('m');
                            window.history.replaceState({}, '', url);
                        });

                        // Store marker reference
                        markers[member.id] = marker;

                        // Center map on marker when clicked (horizontally centered, vertically at bottom)
                        marker.on('click', function() {
                            // Update URL with encoded member ID (use replaceState to not create history entry)
                            const url = new URL(window.location);
                            url.searchParams.set('m', encodeMemberId(member.id));
                            window.history.replaceState({}, '', url);

                            // Calculate target position: marker at bottom 30% of screen
                            const point = map.project([lat, lng], map.getZoom());
                            const mapHeight = map.getSize().y;
                            const offsetY = mapHeight * 0.3;

                            // Adjust point so marker will be at bottom when centered
                            point.y -= offsetY;

                            // Convert back to coordinates
                            const targetLatLng = map.unproject(point, map.getZoom());

                            // Smoothly pan to target position in one movement
                            map.setView(targetLatLng, map.getZoom(), {
                                animate: true,
                                duration: 1.0,
                                easeLinearity: 0.2
                            });
                        });
                    });

                    // Don't auto-zoom to fit markers
                    // Keep the initial view centered on Europe

                    // Check if URL has member parameter
                    const urlParams = new URLSearchParams(window.location.search);
                    const encodedId = urlParams.get('m');

                    if (encodedId) {
                        const memberId = decodeMemberId(encodedId);
                        if (memberId && markers[memberId]) {
                            // Open the specific member's popup and center on it
                            setTimeout(() => {
                                markers[memberId].fire('click');
                            }, 500);
                        }
                    }
                }

                // Hide loader
                document.getElementById('loader').style.display = 'none';
            } catch (error) {
                console.error('Error loading trainers:', error);

                if (retryCount < maxRetries) {
                    // Retry after a delay
                    const delay = (retryCount + 1) * 1000; // 1s, 2s, 3s
                    document.getElementById('loader').innerHTML = `
                        <div class="loader-spinner"></div>
                        <div>Loading trainers map...</div>
                    `;

                    setTimeout(() => {
                        loadTrainers(retryCount + 1);
                    }, delay);
                } else {
                    document.getElementById('loader').innerHTML = `
                        <div class="loader-spinner"></div>
                        <div>Failed to load trainers. Please refresh the page.</div>
                    `;
                }
            }
        }

        // Load trainers when page is ready
        loadTrainers();

        // Handle page restoration from cache (bfcache)
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                // Page was restored from bfcache, reload data
                loadTrainers();
            }
        });

        // Handle browser back/forward buttons
        window.addEventListener('popstate', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const encodedId = urlParams.get('m');

            // Close all popups first
            map.closePopup();

            // If there's a member ID, open that popup and center
            if (encodedId) {
                const memberId = decodeMemberId(encodedId);
                if (memberId && markers[memberId]) {
                    markers[memberId].fire('click');
                }
            }
        });
    </script>
@endsection
