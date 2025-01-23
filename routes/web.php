<?php

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

Route::get('/', 'HomeController@index')->name("home");
Route::get('/remove', 'HomeController@remove')->name("home.remove");
Route::get('/add', 'HomeController@addToWishlist')->name("home.add");
Route::get('/set_view', 'HomeController@setView')->name("home.set_view");
Route::get('/set', 'HomeController@setCurrency')->name("home.set");

Route::get('/adriatic-cruises-croatia', 'CruiseController@index')->name("cruises.index");
Route::get('/adriatic-cruises-croatia/{slug}', 'CruiseController@show')->name("cruises.show");
Route::get('/brochure/adriatic-cruises-croatia/{slug}.pdf', 'CruiseController@download')->name("cruises.download");
Route::post('/adriatic-cruises-croatia', 'CruiseController@loadMore')->name("cruises.more");
Route::post('/send-inquiry', 'CruiseController@sendMail')->name("cruises.sendMail");
Route::get('/special-offer-deals','CruiseController@lmd')->name("cruises.lmd");
Route::get('/cruise-and-stay','CruiseController@cruiseAndStay')->name("cruises.cruiseAndStay");
Route::get('/google-dynamic-csv','CruiseController@googleDynamicCsv')->name("cruises.googleDynamicCsv");

Route::post('/cruise/sendMail', 'CruiseController@sendMail')->name("cruise.sendMail");

Route::get('/small-ships-cruise-croatia', 'ShipController@index')->name("ships.index");
Route::get('/small-ships-cruise-croatia/{slug}', 'ShipController@show')->name("ships.show");

Route::get('/charters', 'CharterController@index')->name("charters.index");
Route::get('/charters/{slug}', 'CharterController@show')->name("charters.show");


Route::get('/cruise-ports', 'StartingPortController@index')->name("ports.index");
Route::get('/cruise-croatia-coast', 'DestinationController@index')->name("destinations.index");
Route::get('/cruise-croatia-coast/{slug}', 'DestinationController@show')->name("destinations.show");
Route::get('/cruise-ports/{slug}', 'DestinationController@oldSlug')->name('destinations.redirect');

Route::get('/cruise-news', 'BlogController@index')->name("blogs.index");
Route::get('/cruise-news/{slug}', 'BlogController@show')->name("blogs.show");

Route::post('/booking-inquiry/step-1', 'BookingController@step1')->name("booking.step1");
//Route::get('/booking-inquiry/step-2', 'BookingController@step2')->name("booking.step2");
Route::post('/booking-inquiry/step-2', 'BookingController@step2')->name("booking.step2");
//Route::get('/booking-inquiry/step-3', 'BookingController@step3');
Route::post('/booking-inquiry/step-3', 'BookingController@step3')->name("booking.step3");
Route::post('/booking-inquiry/sendInquiry', 'BookingController@sendInquiry')->name("booking.send-inquiry");
Route::post('/booking-inquiry/checkInquiry', 'BookingController@checkInquiry')->name("booking.check-inquiry");

Route::get('/contact', 'ContactController@index')->name("contact");
Route::post('/contact/sendMail', 'ContactController@sendMail')->name('contact.sendMail');

Route::post('/newsletter', 'NewsletterController@index')->name("newsletter");

Route::get('/terms-and-conditions', 'TermsController@index')->name("terms");
Route::get('/privacy-policy', 'PrivacyController@index')->name("privacy");
Route::get('/about-us', 'AboutUsController@index')->name("about-us");
Route::get('/frequently-asked-questions', 'AboutUsController@faq')->name("faq");

Route::post("/cookie-consent","CookieController@index")->name("cookie-consent");

//Route::get('/covid', 'CovidController@index')->name('covid');
