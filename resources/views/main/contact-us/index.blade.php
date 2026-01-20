@extends('main.layouts.base')

@section('content')
<section class="p-4">
    <div class="container mx-auto">
        <section class="py-12">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="mb-12">
                    <h2 class="font-manrope text-center font-bold text-gray-900 mb-4 u-text--primary italic">Contact Us</h2>
                    <p class="u-text--primary text-center leading-6 mb-9">Get in touch with our team. We'd love to hear from you.</p>
                </div>

                <!-- Success Message -->
                @if(session('success'))
                    <div class="mx-auto max-w-2xl mb-8">
                        <div class="rounded-2xl bg-green-50 p-6 border-2 border-green-500">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-0.5">
                                    <svg class="h-5 w-5 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-base font-semibold text-green-800 leading-tight">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Error Messages -->
                @if($errors->any())
                    <div class="mx-auto max-w-2xl mb-8">
                        <div class="rounded-2xl bg-red-50 p-6 border-2 border-red-500">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-red-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-base font-semibold text-red-800">Please correct the following errors:</h3>
                                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Contact Form -->
                <div class="mx-auto max-w-2xl">
                    <div class="bg-white rounded-2xl shadow-md p-6 md:p-8">
                        <form action="{{ route('contact-us.submit') }}" method="POST">
                            @csrf
                            <style>
                                @media (min-width: 640px) {
                                    .contact-form-grid {
                                        grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                                    }
                                }
                            </style>
                            <div class="grid gap-x-6 gap-y-6 contact-form-grid" style="grid-template-columns: repeat(1, minmax(0, 1fr));">
                                <!-- First Name -->
                                <div class="col-span-1">
                                    <label for="first-name" class="block text-sm font-semibold text-gray-700 mb-2">First name</label>
                                    <input id="first-name" type="text" name="first_name" value="{{ old('first_name') }}" autocomplete="given-name" required
                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent" />
                                </div>

                                <!-- Last Name -->
                                <div class="col-span-1">
                                    <label for="last-name" class="block text-sm font-semibold text-gray-700 mb-2">Last name</label>
                                    <input id="last-name" type="text" name="last_name" value="{{ old('last_name') }}" autocomplete="family-name" required
                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent" />
                                </div>

                                <!-- Email -->
                                <div class="sm:col-span-2">
                                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                                    <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" required
                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent" />
                                </div>

                                <!-- Phone Number -->
                                <div class="sm:col-span-2">
                                    <label for="phone-number" class="block text-sm font-semibold text-gray-700 mb-2">Phone number</label>
                                    <input id="phone-number" type="text" name="phone_number" value="{{ old('phone_number') }}" placeholder="+1 (555) 123-4567"
                                           class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent" />
                                </div>

                                <!-- Message -->
                                <div class="sm:col-span-2">
                                    <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">Message</label>
                                    <textarea id="message" name="message" rows="5" required
                                              class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent resize-none">{{ old('message') }}</textarea>
                                </div>

                                <!-- Privacy Policy Agreement -->
                                <div class="flex gap-x-3 sm:col-span-2">
                                    <div class="flex h-6 items-center">
                                        <input id="agree-to-policies" type="checkbox" name="agree_to_policies" value="1" {{ old('agree_to_policies') ? 'checked' : '' }} required
                                               class="h-4 w-4 rounded border-gray-300 text-purple-600 focus:ring-2 focus:ring-purple-500" />
                                    </div>
                                    <label for="agree-to-policies" class="text-sm text-gray-600 leading-6">
                                        By selecting this, you agree to our
                                        <a href="{{ route('privacy-policy.index') }}" class="font-semibold text-purple-600 hover:text-purple-500">privacy policy</a>.
                                    </label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="mt-8">
                                <button type="submit"
                                        style="background: linear-gradient(to right, #ffda55, #ca9d00); color: rgb(12, 12, 13);"
                                        class="w-full rounded-xl px-6 py-3.5 text-center text-base font-bold shadow-lg hover:shadow-xl transition-all duration-300">
                                    Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</section>
@endsection
