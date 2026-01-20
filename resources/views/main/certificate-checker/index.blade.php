@extends('main.layouts.base')

@section('content')
<section class="p-4">
    <div class="container mx-auto">
        <section class="py-12">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-12">
                    <h2 class="font-manrope text-center font-bold text-gray-900 mb-4 u-text--primary italic">Certificate Checker</h2>
                    <p class="u-text--primary text-center leading-6 mb-9">Verify the authenticity of your Sviato Academy certificate</p>
                </div>

                <!-- Certificate Form -->
                <div class="mx-auto max-w-2xl">
                    <div class="bg-white rounded-2xl shadow-md p-6 md:p-8">
                        <form id="certificate-form">
                            <div class="mb-6">
                                <label for="certificate-number" class="block text-sm font-semibold text-gray-700 mb-2">Certificate Number</label>
                                <input
                                    id="certificate-number"
                                    type="text"
                                    name="cert"
                                    placeholder="Enter certificate number"
                                    required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                />
                            </div>

                            <!-- Submit Button -->
                            <div class="mb-6">
                                <button
                                    type="submit"
                                    id="submit-button"
                                    style="background: linear-gradient(to right, #ffda55, #ca9d00); color: rgb(12, 12, 13);"
                                    class="w-full rounded-xl px-6 py-3.5 text-center text-base font-bold shadow-lg hover:shadow-xl transition-all duration-300">
                                    Verify Certificate
                                </button>
                            </div>
                        </form>

                        <!-- Loading State -->
                        <div id="loading" class="hidden text-center py-8">
                            <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-purple-600"></div>
                            <p class="mt-4 text-gray-600">Validating certificate...</p>
                        </div>

                        <!-- Error Message -->
                        <div id="error-message" class="hidden rounded-2xl bg-red-50 p-6 border-2 border-red-500 mb-6">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-0.5">
                                    <svg class="h-5 w-5 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-base font-semibold text-red-800 leading-tight" id="error-text"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Result Display -->
                        <div id="result" class="hidden">
                            <!-- Valid Certificate -->
                            <div id="valid-result" class="hidden">
                                <div class="rounded-2xl bg-green-50 p-6 border-2 border-green-500 mb-6">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <svg class="h-6 w-6 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-lg font-bold text-green-800 m-0 leading-none">Certificate is Valid</h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <div class="border-b border-gray-200 pb-4">
                                        <p class="text-sm font-semibold text-gray-500 mb-1">Certificate Number</p>
                                        <p class="text-lg font-bold text-gray-900" id="cert-number"></p>
                                    </div>

                                    <div class="border-b border-gray-200 pb-4">
                                        <p class="text-sm font-semibold text-gray-500 mb-1">Participant</p>
                                        <p class="text-lg font-bold text-gray-900" id="cert-member-name"></p>
                                    </div>

                                    <div class="border-b border-gray-200 pb-4">
                                        <p class="text-sm font-semibold text-gray-500 mb-1">Event Date</p>
                                        <p class="text-lg font-bold text-gray-900" id="cert-event-date"></p>
                                    </div>

                                    <div>
                                        <p class="text-sm font-semibold text-gray-500 mb-1">Verified On</p>
                                        <p class="text-base text-gray-900" id="cert-timestamp"></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Invalid Certificate -->
                            <div id="invalid-result" class="hidden">
                                <div class="rounded-2xl bg-red-50 p-6 border-2 border-red-500">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg class="h-6 w-6 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-lg font-bold text-red-800 m-0 leading-none">Certificate is Invalid</h3>
                                            <p class="mt-2 text-sm text-red-700 leading-none m-0lfkm">The certificate number you entered could not be verified. Please check the number and try again.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('certificate-form');
    const loading = document.getElementById('loading');
    const errorMessage = document.getElementById('error-message');
    const errorText = document.getElementById('error-text');
    const result = document.getElementById('result');
    const validResult = document.getElementById('valid-result');
    const invalidResult = document.getElementById('invalid-result');
    const submitButton = document.getElementById('submit-button');
    const certificateInput = document.getElementById('certificate-number');

    // Check if certificate number is in URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const certFromUrl = urlParams.get('certificate');

    if (certFromUrl) {
        certificateInput.value = certFromUrl;
        // Trigger validation automatically
        validateCertificate(certFromUrl);
    }

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        // Get certificate number
        const certNumber = certificateInput.value.trim();

        if (!certNumber) {
            showError('Please enter a certificate number');
            return;
        }

        validateCertificate(certNumber);
    });

    async function validateCertificate(certNumber) {
        if (!certNumber) {
            showError('Please enter a certificate number');
            return;
        }

        // Update URL with certificate parameter
        const newUrl = new URL(window.location);
        newUrl.searchParams.set('certificate', certNumber);
        window.history.pushState({}, '', newUrl);

        // Hide previous results
        hideAll();
        loading.classList.remove('hidden');
        submitButton.disabled = true;

        try {
            const url = new URL('{{ route("certificate-checker.index") }}');
            url.searchParams.append('cert', certNumber);

            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            loading.classList.add('hidden');
            submitButton.disabled = false;

            const data = await response.json();

            if (response.ok) {
                if (data.valid === true) {
                    showValidResult(data);
                } else {
                    showInvalidResult();
                }
            } else {
                showError(data.error || 'Failed to validate certificate');
            }
        } catch (error) {
            console.error('Error:', error);
            loading.classList.add('hidden');
            submitButton.disabled = false;
            showError('An error occurred while validating the certificate. Please try again.');
        }
    }

    function hideAll() {
        errorMessage.classList.add('hidden');
        result.classList.add('hidden');
        validResult.classList.add('hidden');
        invalidResult.classList.add('hidden');
    }

    function showError(message) {
        hideAll();
        errorText.textContent = message;
        errorMessage.classList.remove('hidden');
    }

    function showValidResult(data) {
        hideAll();

        document.getElementById('cert-number').textContent = data.certificate_number || 'N/A';
        document.getElementById('cert-member-name').textContent = data.member?.name || 'N/A';
        document.getElementById('cert-event-date').textContent = data.event?.date_formatted || data.event?.date || 'N/A';
        document.getElementById('cert-timestamp').textContent = data.timestamp || 'N/A';

        validResult.classList.remove('hidden');
        result.classList.remove('hidden');
    }

    function showInvalidResult() {
        hideAll();
        invalidResult.classList.remove('hidden');
        result.classList.remove('hidden');
    }
});
</script>
@endsection
