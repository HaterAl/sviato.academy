<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\SurveyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require_once(__DIR__ . '/layouts.php');

Route::get('/', [PagesController::class, 'home'])
    ->name('home');

Route::get('/about', [PagesController::class, 'about'])
    ->name('about.index');

Route::get('/events', [EventController::class, 'index'])
    ->name('events.index');

// Route::get('/events/{slug}', [EventController::class, 'show'])
//     ->name('events.show');

Route::get('/community', [CommunityController::class, 'index'])
    ->name('community.index');

Route::get('/products', [ProductsController::class, 'index'])
    ->name('products.index');

Route::get('/contact-us', [PagesController::class, 'contactUs'])
    ->name('contact-us.index');
Route::post('/contact-us', [PagesController::class, 'submitContact'])
    ->name('contact-us.submit');

Route::view('/subscriptions', 'main.subscription.index')->name('subscriptions.index');
Route::view('/subscriptions/privacy-policy', 'main.subscription.privacy-policy.index')->name('privacy-policy.index');
Route::view('/subscriptions/terms-and-conditions', 'main.subscription.terms-and-conditions.index')->name('terms-and-conditions.index');

//Route::get('/survey', [SurveyController::class, 'index'])->name('survey');
//Route::post('/survey', [SurveyController::class, 'store'])->name('survey.store');

	
Route::get('/annex', function () {
    return redirect('https://docs.sviato.academy/annex/sviato_academy_specialties');
});

Route::get('/rules-studios-schools', function () {
    return redirect('https://docs.sviato.academy/annex/rules_for_studios_and_schools');
});

Route::get('/rules-logo-status', function () {
    return redirect('https://docs.sviato.academy/annex/rules_for_obtaining_logo_and_status');
});

Route::get('/mandatory-starter-kit', function () {
    return redirect('https://docs.sviato.academy/annex/mandatory_starter_kit_for_each_specialty');
});

Route::get('/discounts-bonuses', function () {
    return redirect('https://docs.sviato.academy/annex/sviato_academy_discounts_and_bonuses');
});

Route::get('/pricing-policy', function () {
    return redirect('https://docs.sviato.academy/annex/pricing_policy/regions');
});

Route::get('/quality-standards', function () {
    return redirect('https://docs.sviato.academy/annex/sviato_academy_quality_standards');
});

Route::get('/conditions-banners', function () {
    return redirect('https://docs.sviato.academy/annex/conditions_for_receiving_banners');
});

Route::get('/paid-countries', function () {
    return redirect('https://docs.sviato.academy/annex/list_of_low_paid_and_high_paid_countries');
});

Route::get('/privacy-statement', function () {
    return redirect('https://docs.sviato.academy/annex/privacy_statement');
});

Route::get('/l/{oldUrl}', [RedirectController::class, 'redirectToNewUrl'])
        ->where('oldUrl', '.*');
		
Route::get('/sH9lW2zR8xY4pQ7jV6cN3gA1oL0eU5rF/create-redirect', [RedirectController::class, 'createRedirect']);