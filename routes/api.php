<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Use App\Models\User;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1'], function () {
	Route::post('signup', 'App\Http\Controllers\UserController@signup');
	Route::post('signup-provider', 'App\Http\Controllers\UserController@signup_provider');
	Route::post('social-login-user', 'App\Http\Controllers\UserController@socialLoginUser');
	Route::post('social-login-provider', 'App\Http\Controllers\UserController@socialLoginProvider');
	Route::post('login', 'App\Http\Controllers\UserController@login');
	Route::post('forgot-password', 'App\Http\Controllers\UserController@forgotPassword');
	Route::get('get-price', 'App\Http\Controllers\UserController@getPrice');
	Route::post('add-vehicle', 'App\Http\Controllers\UserController@addVehicle');
	Route::post('provider-docs', 'App\Http\Controllers\UserController@providerDocsupload');

	Route::post('push', 'App\Http\Controllers\UserController@push');

	Route::group(['middleware' => 'auth:api'], function() {
		Route::get('logout', 'App\Http\Controllers\UserController@logout');
		Route::post('update-location', 'App\Http\Controllers\UserController@updateLocation');
		Route::post('switch-service-role', 'App\Http\Controllers\UserController@switchServiceRole');
		Route::post('get-all-user', 'App\Http\Controllers\UserController@getAllUser');
		Route::post('my-profile', 'App\Http\Controllers\UserController@getMe');
		Route::post('book-service', 'App\Http\Controllers\UserController@bookService');
		Route::post('update-my-profile', 'App\Http\Controllers\UserController@updateMyProfile');
		Route::post('all-notifications', 'App\Http\Controllers\UserController@allNotifications');
		Route::post('accept-request', 'App\Http\Controllers\UserController@acceptRequest');
		Route::post('get-distance-price', 'App\Http\Controllers\UserController@getDistancePrice');
		Route::post('reject-request', 'App\Http\Controllers\UserController@rejectRequest');
		Route::post('try-again', 'App\Http\Controllers\UserController@tryTosendRequest');
		Route::post('update-profile-picture', 'App\Http\Controllers\UserController@updateProfile_picture');
		Route::post('notification-list', 'App\Http\Controllers\PushnotificationController@notificationList');
		Route::post('complete-request', 'App\Http\Controllers\UserController@completeRequest');
		Route::post('start-request', 'App\Http\Controllers\UserController@startRequest');
		Route::post('cancel-request', 'App\Http\Controllers\UserController@cancelBookingrequest');
		Route::post('complete-request-signature', 'App\Http\Controllers\UserController@completeRequestSignature');
		Route::post('policy-data', 'App\Http\Controllers\UserController@policyData');
		Route::post('status', 'App\Http\Controllers\UserController@status');
		Route::post('user-status', 'App\Http\Controllers\UserController@userStatus');
		Route::post('mechanics-booking-list', 'App\Http\Controllers\UserController@mechanicsBookinglist');

		Route::post('update-tracking', 'App\Http\Controllers\TrackingController@updateTracking');
		Route::post('get-tracking', 'App\Http\Controllers\TrackingController@getTracking');
		Route::post('my-rides', 'App\Http\Controllers\TrackingController@getRides');

		Route::post('support-message', 'App\Http\Controllers\SupportController@create');

		Route::post('payment-info', 'App\Http\Controllers\PaymentController@paymentInfo');
		Route::post('get-payment-info', 'App\Http\Controllers\PaymentController@getpaymentInfo');

		Route::post('create-rating', 'App\Http\Controllers\RatingController@createRating');
		Route::post('get-rating', 'App\Http\Controllers\RatingController@getRatings');
	});
});
