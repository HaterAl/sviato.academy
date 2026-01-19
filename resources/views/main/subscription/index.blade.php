@extends('main.layouts.base')
@section('content')
    <section class="p-4">
        <div class="container mx-auto">
           <section class="py-24 ">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-12">
                <h2 class="font-manrope text-center font-bold text-gray-900 mb-4 u-text--primary italic pl-[2.4em] pr-2 -mr-2">Choose your plan </h2>
                <p class="u-text--primary text-center leading-6 mb-9">Choose a plan according to your level of training.</br>
                    Consumers not eligible for the subscription plans will receive a refund and will be denied access to the subscription services.</p>
                    <div class="text-center"> Please read these
                        <a href="https://sviato.academy/subscriptions/terms-and-conditions" class="u-text--primary">Terms and Conditions</a> &
                        <a href="https://sviato.academy/subscriptions/privacy-policy" class="u-text--primary">Privacy Policy</a> before using Our Service.
                    </div>
                    
            </div>
                <!--Grid-->
                <div class="space-y-8 lg:grid lg:grid-cols-3 sm:gap-6 xl:gap-8 lg:space-y-0 lg:items-center">
                    <!--Pricing Card-->
                    <div class="flex flex-col mx-auto max-w-sm text-gray-900 rounded-2xl bg-gray-50 transition-all duration-500 hover:bg-gray-100 ">
                       
                        <div class="p-6 xl:py-9 xl:px-12">
                        <h3 class="font-manrope text-2xl font-bold mb-3">STYLIST</h3>
                        <div class="flex items-center mb-6">
                            <span class="font-manrope mr-2 text-6xl font-semibold text-[#7770ff]">€10</span>
                            <span class="text-xl text-[#7770ff] ">/ month</span>
                        </div>
                        <!--List-->
                        <ul class="mb-12 space-y-6 text-left text-lg normal-case">
                            <li class="flex items-center space-x-4">
                                <!-- Icon -->
                                <span class="w-4 h-4 rounded-full bg-gray-600 "></span>
                                <span>Stylist logo and certificate</span>
                            </li>
                            <li class="flex items-center space-x-4">
                                <!-- Icon -->
                                <span class="w-6 h-4 rounded-full bg-gray-600"></span>
                                <span>15% discount on all Sviato Academy products</span>
                            </li>
                            <li class="flex items-center space-x-4">
                                <!-- Icon -->
                                <span class="w-6 h-4 rounded-full bg-gray-600"></span>
                                <span>60-day access to the BeautyClass platform</span>
                            </li>  
                             <li class="flex items-center space-x-4">
                                <!-- Icon -->
                                <span class="w-6 h-4 rounded-full bg-gray-600"></span>
                                <span>WebShop Stylist account with personalized features</span>
                            </li>
                            <li class="flex items-center space-x-4">
                                <!-- Icon -->
                                <span class="w-6 h-4 rounded-full bg-gray-600"></span>
                                <span>Exclusive access to Sviato Academy promo content</span>
                            </li>
                            <li class="flex items-center space-x-4 opacity-25 line-through">
                                <!-- Icon -->
                                <span class="w-4 h-4 rounded-full bg-gray-600"></span>
                                <span>Early access to pre-sale launches</span>
                            </li>
                            <li class="flex items-center space-x-4 opacity-25 line-through">
                                <!-- Icon -->
                                <span class="w-6 h-4 rounded-full bg-gray-600"></span>
                                <span>Authorization to teach Sviato techniques</span>
                            </li>
                            <li class="flex items-center space-x-4 opacity-25 line-through">
                                <!-- Icon -->
                                <span class="w-6 h-4 rounded-full bg-gray-600"></span>
                                <span>Possibility to organize the Worlds event</span>
                            </li>
                        </ul>
                        <a href="https://buy.stripe.com/5kA5nB1Qb40re406oo" class="py-2.5 px-5 bg-gray-600 shadow-sm rounded-2xl transition-all duration-500 text-base text-white font-semibold text-center w-fit block mx-auto hover:bg-gray-700">Subscribe</a>
                        <!--List End-->
                    </div>
                    </div> 
                    
                    <!--Pricing Card-->
                    <div class="flex flex-col mx-auto max-w-sm text-gray-900 rounded-2xl bg-gray-50 transition-all duration-500 hover:bg-gray-100 ">
                       
                        <div class="p-6 xl:py-9 xl:px-12">
                        <h3 class="font-manrope text-2xl font-bold text-[#7770ff] mb-3">MASTER</h3>
                        <div class="flex items-center mb-6">
                            <span class="font-manrope mr-2 text-6xl font-semibold text-[#7770ff]">€100</span>
                            <span class="text-xl text-[#7770ff] ">/ month</span>
                        </div>
                        <!--List-->
                        <ul class="mb-12 space-y-6 text-left text-lg normal-case">
                            <li class="flex items-center space-x-4">
                                <!-- Icon -->
                                <span class="w-4 h-4 rounded-full bg-gray-600"></span>
                                <span>Master logo and certificate</span>
                            </li>
                            <li class="flex items-center space-x-4">
                                <!-- Icon -->
                                <span class="w-6 h-4 rounded-full bg-gray-600"></span>
                                <span>35% discount on all Sviato Academy products</span>
                            </li>
                            <li class="flex items-center space-x-4">
                                <!-- Icon -->
                                <span class="w-6 h-4 rounded-full bg-gray-600"></span>
                                <span>90-day access to the BeautyClass platform</span>
                            </li>
                            <li class="flex items-center space-x-4">
                                <!-- Icon -->
                                <span class="w-6 h-4 rounded-full bg-gray-600"></span>
                                <span>WebShop Master account with personalized features</span>
                            </li>
                            <li class="flex items-center space-x-4">
                                <!-- Icon -->
                                <span class="w-6 h-4 rounded-full bg-gray-600"></span>
                                <span>Exclusive access to Sviato Academy promo content</span>
                            </li>
                            <li class="flex items-center space-x-4">
                                <!-- Icon -->
                                <span class="w-4 h-4 rounded-full bg-gray-600"></span>
                                <span>Early access to pre-sale launches</span>
                            </li>
                            <li class="flex items-center space-x-4 opacity-25 line-through">
                                <!-- Icon -->
                                <span class="w-6 h-4 rounded-full bg-gray-600"></span>
                                <span>Authorization to teach Sviato techniques</span>
                            </li>
                            <li class="flex items-center space-x-4 opacity-25 line-through">
                                <!-- Icon -->
                                <span class="w-6 h-4 rounded-full bg-gray-600"></span>
                                <span>Possibility to organize the Worlds event</span>
                            </li>
                        </ul>
                        <a href="https://buy.stripe.com/14k6rFcuPcwX9NK4gj"  class="py-2.5 px-5 bg-gray-600 shadow-sm rounded-2xl transition-all duration-500 text-base text-white font-semibold text-center w-fit block mx-auto hover:bg-gray-700">Subscribe</a>
                        <!--List End-->
                    </div>
                    </div> 

                    <!--Pricing Card-->
                    <div class="flex flex-col mx-auto max-w-sm text-gray-900 rounded-2xl bg-gray-50 transition-all duration-500 hover:bg-gray-100 ">
                    
                        <div class="p-6 xl:py-9 xl:px-12 min-h-[604px]">
                        <h3 class="font-manrope text-2xl font-bold mb-3">TRAINER</h3>
                        <div class="flex items-center mb-6">
                            <span class="font-manrope mr-2 text-6xl font-semibold text-[#7770ff]">€200</span>
                            <span class="text-xl text-[#7770ff] ">/ month</span>
                        </div>
                        <!--List-->
                        <ul class="mb-12 space-y-6 text-left text-lg normal-case">
                            <li class="flex items-center space-x-4">
                                <!-- Icon -->
                                <span class="w-4 h-4 rounded-full bg-gray-600"></span>
                                <span>Trainer logo and certificate</span>
                            </li>
                            <li class="flex items-center space-x-4">
                                <!-- Icon -->
                                <span class="w-6 h-4 rounded-full bg-gray-600"></span>
                                <span>35% discount on all Sviato Academy products</span>
                            </li>
                            <li class="flex items-center space-x-4">
                                <!-- Icon -->
                                <span class="w-6 h-4 rounded-full bg-gray-600"></span>
                                <span>Unlimited access to the BeautyClass platform</span>
                            </li>
                            <li class="flex items-center space-x-4">
                                <!-- Icon -->
                                <span class="w-6 h-4 rounded-full bg-gray-600"></span>
                                <span>WebShop Trainer account with personalized features</span>
                            </li>
                            <li class="flex items-center space-x-4">
                                <!-- Icon -->
                                <span class="w-6 h-4 rounded-full bg-gray-600"></span>
                                <span>Exclusive access to Sviato Academy promo content</span>
                            </li>
                            <li class="flex items-center space-x-4">
                                <!-- Icon -->
                                <span class="w-4 h-4 rounded-full bg-gray-600"></span>
                                <span>Early access to pre-sale launches</span>
                            </li>
                            <li class="flex items-center space-x-4">
                                <!-- Icon -->
                                <span class="w-6 h-4 rounded-full bg-gray-600"></span>
                                <span>Authorization to teach Sviato techniques</span>
                            </li>
                            <li class="flex items-center space-x-4">
                                <!-- Icon -->
                                <span class="w-6 h-4 rounded-full bg-gray-600"></span>
                                <span>Possibility to organize the Worlds event</span>
                            </li>
                        </ul>
                        <a href="https://buy.stripe.com/bIYcQ3bqLdB10da3cg" class="py-2.5 px-5 bg-gray-600 shadow-sm rounded-2xl transition-all duration-500 text-base text-white font-semibold text-center w-fit block mx-auto hover:bg-gray-700">Subscribe</a>
                        <!--List End-->
                    </div>
                    </div> 
                </div>
                <!--Grid End-->
            
        </div>
    </section>
        </div>
    </section>
@endsection