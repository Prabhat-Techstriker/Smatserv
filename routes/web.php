<?php

use Illuminate\Support\Facades\Route;

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

/*Route::get('/', function () {
    return view('admin.login');
});*/

Auth::routes();

/*Route::get('/home', 'HomeController@index')->name('home');*/


Route::get('/', 'App\Http\Controllers\admin\AdminController@show');//->middleware('guest');
/*Route::get('/register', 'RegistrationController@show')
    ->name('register')
    ->middleware('guest');*/


// Register & Login User
//Route::post('/login', 'App\Http\Controllers\admin\AdminController@authenticate');

Route::get('/sendNotification', 'App\Http\Controllers\admin\AdminController@sendNotification');


// Protected Routes - allows only logged in users
Route::middleware('admin')->group(function () {
	Route::get('/dashboard', 'App\Http\Controllers\admin\AdminController@dashboard');
	Route::get('/admin/providers-list', 'App\Http\Controllers\admin\AdminController@providerList');
	Route::post('/admin/update-status/{userId}/{status}', 'App\Http\Controllers\admin\AdminController@updateStatus');
	Route::get('/admin/all-users-list', 'App\Http\Controllers\admin\AdminController@allUsers');
	Route::get('/admin/all-providers-list', 'App\Http\Controllers\admin\AdminController@allProviders');
	Route::get('/logout', 'App\Http\Controllers\admin\AdminController@logout');
	Route::post('/admin/filter-category', 'App\Http\Controllers\admin\AdminController@filterCategory');
	Route::post('/admin/delete-user', 'App\Http\Controllers\admin\AdminController@deleteUser');
	Route::get('/admin/add-vehicle', 'App\Http\Controllers\admin\AdminController@addVehicle');
	Route::post('/admin/add-price', 'App\Http\Controllers\admin\AdminController@addPrice');
	Route::get('/admin/vehicle-list', 'App\Http\Controllers\admin\AdminController@vehiclelist');
	Route::post('/admin/vehicle-delete', 'App\Http\Controllers\admin\AdminController@vehicleDelete');
	Route::get('/admin/list-edit/{id}', 'App\Http\Controllers\admin\AdminController@vehicleEdit');
	Route::post('/admin/edit', 'App\Http\Controllers\admin\AdminController@edit');
	Route::get('/admin/privacy-policy', 'App\Http\Controllers\admin\AdminController@privacy_policy');
	Route::post('/admin/add-privacy-policy-text', 'App\Http\Controllers\admin\AdminController@addprivacypolicyText');
	Route::get('/admin/about-us', 'App\Http\Controllers\admin\AdminController@aboutus');
	Route::get('/admin/contact-us', 'App\Http\Controllers\admin\AdminController@contactus');
	Route::post('/admin/add-contact-us', 'App\Http\Controllers\admin\AdminController@addContactus');
	Route::post('/admin/add-text', 'App\Http\Controllers\admin\AdminController@addText');
	Route::get('/admin/FAQ', 'App\Http\Controllers\admin\AdminController@FAQ');
	Route::post('/admin/add-FAQ', 'App\Http\Controllers\admin\AdminController@addFAQText');
	Route::get('/admin/support', 'App\Http\Controllers\admin\AdminController@Support');
	Route::get('/admin/payment-info', 'App\Http\Controllers\admin\AdminController@paymentInfo');
	Route::get('/admin/advertisement', 'App\Http\Controllers\admin\AdminController@advertisement');
	Route::post('/admin/advertiseupload', 'App\Http\Controllers\admin\AdminController@advertiseUpload');
	Route::get('/admin/offerspage', 'App\Http\Controllers\admin\AdminController@offersPage');
	Route::post('/admin/offers', 'App\Http\Controllers\admin\AdminController@offers');
	Route::get('/admin/review', 'App\Http\Controllers\admin\AdminController@ratingReview');
});