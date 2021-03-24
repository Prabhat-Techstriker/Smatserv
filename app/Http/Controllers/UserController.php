<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\User_details;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Mail;
use Notification;
use App\Notifications\Forgotpassword;
use App\Models\Booking_service;
use App\Models\Booking_requests;
use App\Models\Push_notification;
use App\Models\Service_prices;
use File;
use App\Models\Price;
use App\Models\Signature;
use App\Models\policies;
use DB;
use App\Models\PaymentInfo;

class UserController extends Controller
{
	/**
	 * Create user
	 *
	 * @param  [string] name
	 * @param  [string] email
	 * @param  [string] phone_number
	 * @param  [string] password
	 * @param  [integer] service type (1=>user,2=>provider)
	 */
	public function signup(Request $request)
	{
		$data = $request->all();

		if ($data['social_type'] == 0) {
			$request->validate([
				'name' => 'required|string',
				'email' => 'required|string|email|unique:users',
				'phone_number' => 'string|unique:users',
				'password' => 'required|string|confirmed',
				'service_type' => 'required|integer',
			]);

			$user = array(
				'name' => $request->name,
				'email' => $request->email,
				'phone_number' => $request->phone_number,
				'service_type' => $request->service_type,
				'password' => bcrypt($request->password),
				'latitude' => $request->latitude,
				'longitude' => $request->longitude,
				'is_verified' => false,
				'social_type' => false,
				'address' => $request->address,
			);

			$user = User::create($user);

			$get_user_data = User::where('id', $user->id)->first();
		} else {
			/*In case of social signup*/
			$request->validate([
				'name' => 'required|string',
				'email' => 'required|string|email',
				'service_type' => 'required|integer',
			]);

			$user = array(
				'name' => $request->name,
				'email' => $request->email,
				'phone_number' => NULL,
				'service_type' => $request->service_type,
				'password' => bcrypt($request->password), // for social login
				'latitude' => $request->latitude,
				'longitude' => $request->longitude,
				'is_verified' => false,
				'social_type' => true,
				'profile_picture' => $request->profile_picture,
				'address' => $request->address,
			);

			$exist = User::where('email', $request->email)->first();

			if ($exist) {
				$get_user_data = User::where('email', $exist->email)->first();
			} else {
				$user = User::create($user);

				$get_user_data = User::where('id', $user->id)->first();
			}
		}

		if ($get_user_data) {
			$tokenResult = $get_user_data->createToken('Personal Access Token');
			$token = $tokenResult->token;
			$token->expires_at = Carbon::now()->addWeeks(1);
			if ($request->remember_me)
				$token->expires_at = Carbon::now()->addWeeks(1);
			$token->save();

			return response()->json([
				'access_token' => $tokenResult->accessToken,
				'token_type' => 'Bearer',
				'expires_at' => Carbon::parse(
					$tokenResult->token->expires_at
				)->toDateTimeString(),
				'user' => $user,
				'message' => 'User register Successfully!.'
			]);
		} else {
			return response()->json(['status' => 'error', 'message' => 'User not found!.'], 201);
		}
	}


	public function signup_provider(Request $request)
	{
		$data = $request->all();


		$matchThese = ['email' => $request->email];

		$results = User::where($matchThese)->first();


		if (!empty($results) && $results['service_type'] == 1) {
			$request->validate([
				'name' 	=> 'required|string',
				'email' => 'required|string|email',
				'phone_number' => 'required|string',
				'password' => 'required|string|confirmed',
				'service_type' => 'required|integer',
				'identification_document' => 'required|file|mimes:jpg,jpeg,png',
				'bussiness_certificate' => 'required|file|mimes:jpg,jpeg,png',
				'device_token' => 'required'
			]);
		}else{
			$request->validate([
				'name' 	=> 'required|string',
				'email' => 'required|string|email|unique:users',
				'phone_number' => 'string|unique:users',
				'password' => 'required|string|confirmed',
				'service_type' => 'required|integer',
				'identification_document' => 'required|file|mimes:jpg,jpeg,png',
				'bussiness_certificate' => 'required|file|mimes:jpg,jpeg,png',
				'device_token' => 'required',
				'rate_per_hour' =>  'required',
			]);
		}

		$user = array(
			'name' => $request->name,
			'email' => $request->email,
			'phone_number' => $request->phone_number,
			'service_type' => 2,
			'password' => bcrypt($request->password),
			'latitude' => $request->latitude,
			'longitude' => $request->longitude,
			'device_token' => $request->device_token,
			'address' => $request->address,
		);

		$filenameWithExt = $request->file('identification_document')->getClientOriginalName();
		$filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
		$extension = $request->file('identification_document')->getClientOriginalExtension();
		$mimeType = $request->file('identification_document')->getClientMimeType();
		$fileNameToStore = str_replace(" ", "-", $filename) . '_' . time() . '.' . $extension;
		$path = $request->file('identification_document')->storeAs('images', $fileNameToStore);

		$filename_withext = $request->file('bussiness_certificate')->getClientOriginalName();
		$file_name = pathinfo($filename_withext, PATHINFO_FILENAME);            
		$extension_bussi = $request->file('bussiness_certificate')->getClientOriginalExtension();
		$mimeType = $request->file('bussiness_certificate')->getClientMimeType();
		$file_name_to_store = str_replace(" ", "-", $file_name).'_'.time().'.'.$extension_bussi;
		$path_bussi = $request->file('bussiness_certificate')->storeAs('images', $file_name_to_store);

		if (!empty($results) && $results['service_type'] == 2) {
			return response()->json(['status' => 'error', 'message' => 'service provider already registerd with this email!.'], 400);
		}elseif (!empty($results) && $results['service_type'] == 1) {

			$user = User::updateOrCreate(['email' => $request->email],$user);
		}else{
			$user = User::create($user);
		}

		if ($user) {
			try {
				$user_details = array(
					'user_id' => $user->id,
					'service_provide_type' => $request->service_provide_type,
					'vehicle_type' => $request->vehicle_type,
					'vehicle_number' => $request->vehicle_number,
					'type_of_mechanic' => $request->type_of_mechanic,
					'courier_type' => $request->courier_type,
					'haulage_type' => $request->haulage_type,
					'rate_per_hour' => $request->rate_per_hour,
					'identification_document' => $path,
					'description' => $request->description,
					'bussiness_certificate' => $path_bussi,
				);
				$user_details = User_details::create($user_details);
				$data = User_details::where('user_id', $user_details->user_id)->with('user')->first();
				return response()->json(['status' => 'success', 'message' => 'service provider created successfully!.','user_data' => $data], 200);
			} catch (\Exception $e) {
				return response()->json(['message' => 'failed to create user!.'], 409);
			}
		}
	}


	/**
	 * Login user and create token
	 */
	public function login(Request $request)
	{
		$request->validate([
			'phone_or_email' => 'required|string',
			'password' => 'required|string',
			'service_type' => 'required|string',
		]);

		$data = $request->all();
		$login_type = filter_var($data['phone_or_email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'phone_number';

		try {
			$token = Auth::attempt([$login_type => $data['phone_or_email'], 'password' => $data['password']]);
			$user_val = $request->user();

			if (!$token) {
				return response()->json(['error' => 'Credentials wrong'], 401);
			}

			$user = User::where('id',$user_val->id)->with('user_details')->first();

			if ($request->service_type == 1) {
				$user->service_type = 1;
				$user->save();

				$tokenResult = $user->createToken('Personal Access Token');
				$token = $tokenResult->token;
				$token->expires_at = Carbon::now()->addWeeks(1);
				if ($request->remember_me)
					$token->expires_at = Carbon::now()->addWeeks(1);
				$token->save();
				return response()->json([
					'access_token' => $tokenResult->accessToken,
					'token_type' => 'Bearer',
					'expires_at' => Carbon::parse(
						$tokenResult->token->expires_at
					)->toDateTimeString(),
					'user' => $user
				]);
			}else{
				$user->service_type = 2;
				$user->save();
				$data = User::where('id', $user->id)->with('user_details')->first();				

				$retVal = ($data['user_details']) ? true : false ;
				
				if ($retVal == true) {
					switch($user['admin_approved']){      
					case 0:
						return response()->json(['message' => 'Your approval is pending.please wait for approval!.',"admin_approval" => $user->admin_approved,'user' => $data], 200);
					case 1:
						$tokenResult = $user->createToken('Personal Access Token');
						$token = $tokenResult->token;
						$token->expires_at = Carbon::now()->addWeeks(1);
						if ($request->remember_me)
							$token->expires_at = Carbon::now()->addWeeks(1);
						$token->save();
						return response()->json([
							'access_token' => $tokenResult->accessToken,
							'token_type' => 'Bearer',
							'expires_at' => Carbon::parse(
								$tokenResult->token->expires_at
							)->toDateTimeString(),
							'user' => $user
						]);
					}
				}else{
					return response()->json(['message' => 'Please fill the bussiness details first!.','user_details' => $data], 400);
				}
			}
		} catch (\Exception $e) {
			return response()->json(['error' => 'something went wrong.'], 500);
		}
	}

	public function socialLoginUser(Request $request)
	{
		$request->validate([
			'name' 				=> 'required|string',
			'email' 			=> 'required|string|email',
			'service_type' 		=> 'required|integer',
			'profile_picture' 	=> 'required|string',
			'gmail_token'		=> 'required|string',
		]);

		$user = User::where('email', $request->email)->with('user_details')->first();
		
		if (empty($user)) {
			$user = array(
				'name' => $request->name,
				'email' => $request->email,
				'service_type' => $request->service_type,
				'social_type' => true,
				'profile_picture' => $request->profile_picture,
				'gmail_token' => $request->gmail_token,
				'password' => bcrypt(mt_rand()),
			);
			$user = User::create($user);
			$user->service_type = 1;
			$user->save();
		}else{
			$user->service_type = 1;
			$user->save();
		}

		try {
			$tokenResult = $user->createToken('Personal Access Token');
			$token = $tokenResult->token;
			$token->expires_at = Carbon::now()->addWeeks(4);
			$token->save();

			return response()->json([
				'access_token' => $tokenResult->accessToken,
				'token_type' => 'Bearer',
				'expires_at' => Carbon::parse(
					$tokenResult->token->expires_at
				)->toDateTimeString(),
				'user' => $user,
				'message' => 'User register Successfully!.'
			]);
		} catch (\Exception $e) {
			return response()->json(['error' => 'something went wrong.please try again!.'], 500);
		}
	}

	/**
	 * social login for provider
	 *
	 * @return [string] email
	 * @return [string] token
	 * @return [string] social type
	 */
	public function socialLoginProvider(Request $request)
	{
		$data;
		$request->validate([
				'name' 				=> 'required|string',
				'email' 			=> 'required|string|email',
				'service_type' 		=> 'required|integer',
				'profile_picture' 	=> 'required|string',
				'gmail_token'		=> 'required|string',
				'device_token'		=> 'required'
			]);

		$user = User::where('email', $request->email)->with('user_details')->first();
		
		if (empty($user)) {
			$user = array(
				'name' => $request->name,
				'email' => $request->email,
				'service_type' => $request->service_type,
				'social_type' => true,
				'profile_picture' => $request->profile_picture,
				'gmail_token' => $request->gmail_token,
				'password' => bcrypt(mt_rand()),
				'device_token'		=> $request->device_token
			);
			$user_data = User::create($user);
			$user = User::where('id', $user_data)->with('user_details')->first();
			$user->service_type = 2;
			$user->save();
		}else{
			$user->service_type = 2;
			$user->save();
		}

		try {
			$tokenResult = $user->createToken('Personal Access Token');
			$token = $tokenResult->token;
			$token->expires_at = Carbon::now()->addWeeks(4);
			$token->save();

			return response()->json([
				'access_token' => $tokenResult->accessToken,
				'token_type' => 'Bearer',
				'expires_at' => Carbon::parse(
					$tokenResult->token->expires_at
				)->toDateTimeString(),
				'user' => $user,
				'message' => 'Provider register Successfully!.'
			]);
		} catch (\Exception $e) {
			return response()->json(['error' => 'something went wrong.please try again!.'], 500);
		}
	}


	/**
	 * Update location
	 *
	 * @return [string] latitude
	 * @return [string] longitude
	 */
	public function updateLocation(Request $request)
	{
		$data = $request->all();
		$uid = $request->user()->id;
		$request->validate([
			'latitude' => 'required|string',
			'longitude' => 'required|string',
			'device_token' => 'required|string',
		]);

		try {
			$update_user_data = User::where('id', $uid)->update($request->all());
			return response()->json(['status' => 'success', 'message' => 'location updated successfully!.'], 200);
		
		} catch (\Exception $e) {
			return response()->json(['error' => 'something went wrong.please try again!.'], 500);
		}
	}


	/**
	* switch role (user to provider (vise versa)
	*/
	public function switchServiceRole(Request $request){
		$data = $request->all();
		$user = $request->user()->id;
		
		$request->validate([
			'service_type' => 'required|string',
		]);

		$data_user = User::with('user_details')->find($user);

		if ($data_user->service_type == 1 && $request->service_type == 2) {
			if(empty($data_user['user_details'])) {
				return response()->json(['message' => 'Please fill the bussiness details first!.','user_details' => $data_user], 200);
			}else{
				$user = User::where('id', $user)->update(['service_type' => 2]);
				if ($data_user['admin_approved'] == 1) {
					return response()->json(['status' => 'success', 'message' => 'switch on provider successfully!.','user_details' => $data_user], 200);
				}else{
					return response()->json(['message' => 'Your approval is pending.please wait for approval!.'], 200);
				}
			}
		}else{
			try {
				$user = User::where('id', $user)->update(['service_type' => 1]);
				return response()->json(['message' => 'switch user successfully!.','user_details' => $data_user], 200);
			} catch (Exception $e) {
				return response()->json(['status' => 'error', 'message' => 'failed to switch on user!.'], 400);
			}

			
		}
	}

	/**
	 * get all users based on role (User or Provider)
	 *
	 * @return [int] service_type
	 */

	public function getAllUser(Request $request){
		$request->validate([
			'service_type' => 'required|integer',
			'service_category' => 'required|string',
			'latitude' => 'required',
			'longitude' => 'required'
		]);

		$category = $request['service_category'];
		try {
			$data = User::where(['service_type'=>$request->service_type,'job_status' => 0])->selectRaw('*, ( 6371 * acos( cos( radians( ? ) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians( ? ) ) + sin( radians( ? ) ) * sin( radians( latitude ) ) ) ) AS distance', [$request->latitude, $request->longitude, $request->latitude])
			->having('distance', '<', 10)
			->orderBy('distance')			
			->with('user_details')
			->whereHas('user_details', function($users) use ($category){
						$users->where('service_provide_type','=',$category);
					})
			->withCount(['provider_rating as provider_rating_sum'=> function($query) {
					$query->select(DB::raw('sum(rating)'));
				}])
			->withCount('provider_rating')
			->get();
			return response()->json(['status' => 'success', 'message' => 'users fetched successfully!.' ,'users' => $data], 200);
		} catch (\Exception $e) {
			return response()->json(['error' => 'something went wrong.please try again!.'], 500);
		}
	}


	/**
	 * Forgot password
	 *
	 * @return [string] email
	 */
	public function forgotPassword(Request $request){
		$request->validate([
			'email' => 'required|string|email'
		]);
		$password = $this->password_generate(7);
		$get_user_data = User::where('email', trim($request->email))->first();

		if ($get_user_data) {
			unset($get_user_data['password']);
			$get_user_data['password'] = bcrypt($password);
			$user = User::where('email', trim($request->email))->update(['password' => $get_user_data['password']]);
			if($user){
				try {
				
					$details = [
						'name' => $get_user_data->name,
						'password' => $password
					];

					Notification::send($get_user_data , new Forgotpassword($details));

					return response()->json(['status' => 'success', 'message' => 'mail sent successfully!.'], 200);
				} catch (\Exception $e) {
					return response()->json(['error' => 'enable to send mail.please try again!.'], 400);
				}
				
			}else{
				return response()->json(['error' => 'something went wrong.please try again!.'], 500);
			}	
		}else{
			return response()->json(['error' => 'your mail not registered!.'], 400);
		}
	}

	/*create random password*/
	function password_generate($chars) 
	{
		$data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
		return substr(str_shuffle($data), 0, $chars);
	}


	/**
	 * Get profile 
	 *
	 * @return [string] message
	 */
	public function getMe(Request $request){
		$uid = $request->user()->id;
		
		try {
			$get_user_profile = User::where('id', $uid)->with('user_details')->first();
			if ($get_user_profile->service_type == 1) {
				$rideCount = Booking_requests::where(['service_user_id' => $get_user_profile->id])->count();
				$rideTotalPrice = Booking_service::where(['service_user_id' => $get_user_profile->id])->count();
				$totalAmount = 0;
			} else {
				$rideCount 	= Booking_requests::where(['service_provide_id' => $get_user_profile->id , 'booking_status' => 9])->count();
				$totalAmount = PaymentInfo::where('provider_id',$get_user_profile->id)->sum('price');
			}
			
			$get_user_profile->rideCount = $rideCount;
			$get_user_profile->totalAmount = $totalAmount;

			return response()->json(['status' => 'success', 'message' => 'profile fetched successfully!.' ,'profile' => $get_user_profile], 200);
		} catch (\Exception $e) {
			return response()->json(['error' => 'something went wrong.please try again!.'], 500);
		}
	}


	public function updateProfile_picture(Request $request){
		$uid = $request->user()->id;
		$request->validate([
			'profile_picture' => 'required',
		]);

		$get_user = User::where('id',$uid)->with('user_details')->first();
		try {
			if ($request->profile_picture) {

				$file_path = storage_path('app/'.$get_user->profile_picture);
				if(File::exists($file_path)) File::delete($file_path);
				
				$filenameWithExt = $request->file('profile_picture')->getClientOriginalName();
				$filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
				$extension = $request->file('profile_picture')->getClientOriginalExtension();
				$mimeType = $request->file('profile_picture')->getClientMimeType();
				$fileNameToStore = str_replace(" ", "-", $filename) . '_' . time() . '.' . $extension;
				$path = $request->file('profile_picture')->storeAs('images', $fileNameToStore);

				$get_user = User::where('id',$uid)->with('user_details')->update(['profile_picture' => $path]);
			}
			return response()->json(['message' => 'profile picture updated successfully!.','profile_picture' => $path], 200);
		} catch (Exception $e) {
			return response()->json(['error' => 'failed to update profile picture!.'], 400);
		}
	}

	/**
	 * Get profile 
	 *
	 * @return [string] message
	 */
	public function updateMyProfile(Request $request){
		$request->validate([
			'service_type' => 'required|string',
		]);
		$uid = $request->user()->id;
		$get_user = User::where('id',$uid)->with('user_details')->first();
		$data = $request->all();

		if ($request->service_type == 1) {

			$userres = User::updateOrCreate(['id' => $uid],$data);
			$get_user_after_update = User::where('id',$uid)->with('user_details')->first();
			return response()->json(['status' => 'success', 'message' => 'profile updated successfully!.' ,'profile' => $get_user_after_update], 200);
		} else {

			$user = array(
				'name' => $request->name,
				'phone_number' => $request->phone_number,
				'service_type' => $request->service_type,
				'address' => $request->address,
			);

			if ($request->identification_document) {
				$filenameWithExt = $request->file('identification_document')->getClientOriginalName();
				$filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
				$extension = $request->file('identification_document')->getClientOriginalExtension();
				$mimeType = $request->file('identification_document')->getClientMimeType();
				$fileNameToStore = str_replace(" ", "-", $filename) . '_' . time() . '.' . $extension;
				$path = $request->file('identification_document')->storeAs('images', $fileNameToStore);
			}else{
				$path = '';
			}
			
			if ($request->bussiness_certificate) {
				$filename_withext = $request->file('bussiness_certificate')->getClientOriginalName();
				$file_name = pathinfo($filename_withext, PATHINFO_FILENAME);            
				$extension_bussi = $request->file('bussiness_certificate')->getClientOriginalExtension();
				$mimeType = $request->file('bussiness_certificate')->getClientMimeType();
				$file_name_to_store = str_replace(" ", "-", $file_name).'_'.time().'.'.$extension_bussi;
				$path_bussi = $request->file('bussiness_certificate')->storeAs('images', $file_name_to_store);
			}else{
				$path_bussi = '';
			}
			

			$userres = User::updateOrCreate(['id' => $uid],$user);

			$user_details = array(
				'user_id' => $uid,
				'service_provide_type' => $request->service_provide_type,
				'vehicle_type' => $request->vehicle_type,
				'vehicle_number' => $request->vehicle_number,
				'type_of_mechanic' => $request->type_of_mechanic,
				'courier_type' => $request->courier_type,
				'haulage_type' => $request->haulage_type,
				'rate_per_hour' => $request->rate_per_hour,
				'identification_document' => $path,
				'description' => $request->description,
				'bussiness_certificate' => $path_bussi,
			);
			$user_details = User_details::updateOrCreate(['user_id' => $uid],$user_details);

			if ($userres['admin_approved'] == 1) {
				$admin_approved = true;
			}else{
				$admin_approved = false;
			}

			try {
				$get_user_after_update = User::where('id',$uid)->with('user_details')->first();

				return response()->json(['message' => 'Your approval is pending.please wait for approval!.','user' => $get_user_after_update , 'admin_approved' => $admin_approved], 200);
			} catch (Exception $e) {
				return response()->json(['error' => 'failed to update profile!.'], 400);
			}
		} 
	}

	/**
	 * Booking a service
	 *
	*/
	public function bookService(Request $request){
		
		$uid = $request->user()->id;
		$message = 'Request received.';

		try {
			if ($request->category == 'Mechanic') {

				$request->validate([
					'service_provide_id' 			=> 'required',
					'service_provider_name' 		=> 'required|string',
					'service_price' 				=> 'required',
					'service_provider_latitude' 	=> 'required',
					'service_provider_longitude' 	=> 'required',
					'service_user_id' 				=> 'required',
					'service_user_name' 			=> 'required|string',
					'service_user_email' 			=> 'required|string|email',
					'service_user_contact' 			=> 'required|string',
					'service_user_latitude' 		=> 'required',
					'service_user_longitude' 		=> 'required',
				]);

				//$exist_req = Booking_service::where(['service_user_id' => $request->service_user_id , 'service_provide_id' => $request->service_provide_id])->first();
				$exist_req = Booking_requests::where(['service_user_id' => $request->service_user_id, 'service_provide_id' => $request->service_provide_id])
				->orderBy('id','desc')->first();
				
				//if ($exist_req) {
				if(!empty($exist_req->booking_status) && ($exist_req->booking_status == 1|| $exist_req->booking_status == 20) ){
					return response()->json(['error' => 'Already sent request!.'], 400);
				}

				$booking_service = Booking_service::create($request->all());
				$booking_id = $booking_service->id;

				$data = Booking_service::where('id',$booking_id)->first();
				$data['booking_service_id'] = $booking_id;
				$data['provider_id'] = $request->service_provide_id;
				
				$device_token_provider = User::where('id' , $booking_service->service_provide_id)->with('user_details')->first();

				$token = $device_token_provider['device_token'];
				$data['providerData'] = $device_token_provider;

				$booking_request['service_provide_id'] 	= $data['provider_id'];
				$booking_request['service_user_id'] 	= $request->service_user_id;
				$booking_request['booking_service_id'] 	= $booking_id;
				$booking_request['booking_status'] 		= 20;

				$booking_req = Booking_requests::create($booking_request);

				sendPushnotification($token,'Smatserv', $message , $data ,5);

			}else{
					$rejectIds = array();
					//print_r($request->all());die("--");
					// get near by user provider 
					$res = $this->getNearbyprovider(2,$request->user()->latitude,$request->user()->longitude,$request->category,$request->vehicle);

					if ($res->toArray()) {
						$arraRes = $res->toArray();
					}else{
						return response()->json(['message' => "Providers not found near by your location!."], 200);die;
					}
					
					$data['service_user_id']		= $request->user()->id;
					$data['service_user_name']		= $request->user()->name;
					$data['service_user_email']		= $request->user()->email;
					$data['service_user_contact']	= $request->user()->phone_number;
					$data['service_user_longitude']	= $request->user()->longitude;
					$data['service_user_latitude']	= $request->user()->latitude;
					

					$arr = array();
					foreach ($arraRes as $key => $value) {
						if(!empty($ids) && $value['id'] == $ids) {
							unset($key);
						}else{
							$arr[] = $value;
						}
					}

					/*----------------calculate distance from pickup and provider current location----------------*/
					$distance2 = $this->getDistancecalculation($request->pickup_latitude,$request->pickup_longitude,$arr[0]['latitude'],$arr[0]['longitude'],'K');
					/*--------------------------------------------------------------------------------------------*/
					
					if ($distance2 > 3) {
						return response()->json(['message' => "No providers found near by your location!."], 200);die;
					}

					$data['service_provide_id'] 			= $arr[0]['id'];
					$data['service_provider_name'] 			= $arr[0]['name'];
					$data['service_provider_latitude'] 		= $arr[0]['latitude'];
					$data['service_provider_longitude'] 	= $arr[0]['longitude'];
					$data['service_price']					= $request->total_fare;
					$data['pickup_latitude']				= $request->pickup_latitude;
					$data['pickup_longitude']				= $request->pickup_longitude;
					$data['pickup_address']					= $request->pickup_address;
					$data['drop_latitude']					= $request->drop_latitude;
					$data['drop_longitude']					= $request->drop_longitude;
					$data['drop_address']					= $request->drop_address;
					$data['total_fare']						= $request->total_fare;	

		
					$booking_service = Booking_service::create($data);
					$booking_id = $booking_service->id;
					$data['booking_service_id'] = $booking_id;
					$data['provider_id'] = $data['service_provide_id'];

					$device_token_provider = User::where('id' , $data['provider_id'])->with('user_details')->first();
					$data['providerData'] = $device_token_provider;
					
					sendPushnotification($arr[0]['device_token'],'Smatserv', $message , $data ,5);
				}
			
			return response()->json(['message' => "Your booking request sent successfully.please wait for service provider's repsonse!.",'request' => $data], 200);
		} catch (Exception $e) {
			return response()->json(['error' => 'failed to book service!.'], 400);
		}
	}

	/*
	* Get lists of bookings for me Mechanic
	*/
	public function mechanicsBookinglist(Request $request){
		$uid = $request->user()->id;
		
		try {
			$data = Booking_requests::with('booking_service')->where(['service_provide_id' => $uid,'booking_status' => 1])->get();
			return response()->json(['message' => "bookings feteched successfully!.",'requests' => $data], 200);
		} catch (Exception $e) {
			return response()->json(['error' => 'failed to book service!.'], 400);
		}
	}

	function getNearbyprovider($serviceType,$latitude,$longitude,$category,$vehicle,$notinids='')
	{
		try {
			$data = User::where(['admin_approved' => 1,'service_type' => 2,'job_status' => 0])->selectRaw('*, ( 6371 * acos( cos( radians( ? ) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians( ? ) ) + sin( radians( ? ) ) * sin( radians( latitude ) ) ) ) AS distance', [$latitude, $longitude, $latitude])
							->having('distance', '<', 10)
							->orderBy('distance','ASC')			
							->with('user_details')->whereHas('user_details', function($users) use ($category,$notinids,$vehicle){
										$users->where('service_provide_type','=',$category);
										$users->where('vehicle_type','=',$vehicle);
										if ($notinids) {
											$users->whereNotIn('user_id',[$notinids]);
										}
									})
							->limit(5)
							->get();
			return $data;
		} catch (Exception $e) {
		}
	}

	function getDistancecalculation($pick_latitude,$pick_longitude,$drop_latitude,$drop_longitude,$unit){
		$theta = $pick_longitude - $drop_longitude;
		$dist = sin(deg2rad($pick_latitude)) * sin(deg2rad($drop_latitude)) +  cos(deg2rad($pick_latitude)) * cos(deg2rad($drop_latitude)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		$unit = strtoupper($unit);

		if ($unit == "K") {
			return ($miles * 1.609344);
		} else if ($unit == "N") {
			return ($miles * 0.8684);
		} else {
			return $miles;
		}
	}

	function getRateperhour($category){
		$getData = Service_prices::where('service_name' , $category)->first();
		return $getData->price;
	}

	public function cancelBookingrequest(Request $request){
		$uid = $request->user()->id;
		$request->validate([
			'booking_service_id'	=>	'required',
		]);
		
		try {
			$booking_service = Booking_service::where(['id' => $request->booking_service_id])->first();

			$providerData 	= User::where('id',$booking_service->service_provide_id)->first();
			$providerToken 	= $providerData->device_token;

			$userData 	= User::where('id',$booking_service->service_user_id)->first();
			$userToken 	= $userData->device_token;

			if ($uid == $booking_service->service_provide_id) {
				$createData  = array('service_provide_id' => $uid , 'service_user_id' => $booking_service->service_user_id , 'booking_service_id' => $request->booking_service_id, 'booking_status' => 0 , 'cancel_reason' => isset($request->cancel_reason) ? $request->cancel_reason : '');
				$person = "Provider";
				$pushnotifytype = 7;
				$token 	= $userToken;
			}elseif ($uid == $booking_service->service_user_id) {
				$createData  = array('service_user_id' => $uid , 'service_provide_id' => $booking_service->service_provide_id , 'booking_service_id' => $request->booking_service_id, 'booking_status' => 0 , 'cancel_reason' => isset($request->cancel_reason) ? $request->cancel_reason : '');
				$person = "User";
				$pushnotifytype = 0;
				$token 	= $providerToken;
			}

			$message = $person." cancel the request!.";



			//$booking_req = Booking_requests::create($createData);
			$booking_req = Booking_requests::updateOrCreate(
								['booking_service_id' => $request->booking_service_id],
								$createData
							);

			$update_job_status 	= User::where(['id' => $booking_service->service_provide_id])->update(['job_status' => 0]);
			$update_job_status1 = User::where(['id' => $booking_service->service_user_id])->update(['user_status' => 0]);

			$push_notification_data['service_user_id'] 			= $booking_service['service_user_id'];
			$push_notification_data['provider_id'] 				= $booking_service['service_provide_id'];
			$push_notification_data['booking_service_id'] 		= $booking_service['id'];
			$push_notification_data['request_status'] 			= 0; // for cancel
			$push_notification_data["service_user_email"]		= $booking_service['service_user_email'];
			$push_notification_data["service_price"]			= $booking_service['service_price'];
			$push_notification_data["pickup_latitude"]			= $booking_service['pickup_latitude'];
			$push_notification_data["pickup_longitude"]			= $booking_service['pickup_longitude'];
			$push_notification_data["drop_latitude"]			= $booking_service['drop_latitude'];
			$push_notification_data["drop_longitude"]			= $booking_service['drop_longitude'];

			sendPushnotification($token,'Smatserv', $message , $push_notification_data ,$pushnotifytype);

			return response()->json(['message' => "Booking request cancelled!."], 200);
		} catch (Exception $e) {
			return response()->json(['error' => 'failed to cancelled request!.'], 400);
		}
	}


	function acceptRequest(Request $request) {
		/*Function based on provider*/
		$uid = $request->user()->id;
		
		$providerData = User::with('user_details')->where('id',$uid)->first();

		$data = array();
		$message = $providerData->name." accepted your request.";
		try {
			$booking_request = array(
				'service_provide_id' 	=> $uid,
				'service_user_id' 		=> $request->service_user_id,
				'booking_service_id' 	=> $request->booking_service_id,
				'booking_status' 		=> 1
			);

			$booking_service = Booking_service::where('id',$booking_request['booking_service_id'])->first();

			$booking_req = Booking_requests::updateOrCreate(['booking_service_id' => $request->booking_service_id],$booking_request);

			$device_token_provider = User::where('id' , $booking_request['service_user_id'])->first();
			$token = $device_token_provider['device_token'];

			if($providerData->user_details->service_provide_type != 'Mechanic'){
				$update_job_status = User::where(['id' => $uid])->update(['job_status' => 1]);

				$update_job_status1 = User::where(['id' => $request->service_user_id])->update(['user_status' => 1]);
			}

			$data['service_user_id'] 			= $booking_request['service_user_id'];
			$data['provider_id'] 				= $booking_request['service_provide_id'];
			$data['booking_service_id'] 		= $booking_request['booking_service_id'];
			$data['request_status'] 			= 1;
			$data["service_user_email"]			= $booking_service['service_user_email'];
			$data["service_price"]				= $booking_service['service_price'];
			$data["pickup_latitude"]			= $booking_service['pickup_latitude'];
			$data["pickup_longitude"]			= $booking_service['pickup_longitude'];
			$data["drop_latitude"]				= $booking_service['drop_latitude'];
			$data["drop_longitude"]				= $booking_service['drop_longitude'];
			$booking_req['user_details']		= $device_token_provider;

			sendPushnotification($token,'Smatserv', $message , $data ,1);

			return response()->json(['message' => "Booking request accepted!.",'result' => $booking_req], 200);
		} catch (Exception $e) {
			return response()->json(['error' => 'failed to accept request!.'], 400);
		}
	}

	function rejectRequest(Request $request) { 
		/*Function based on provider*/
		$uid = $request->user()->id;
		$request->validate([
			'booking_service_id'	=>	'required',
		]);
		$data = array();
		$providerData = User::with('user_details')->where('id',$uid)->first();
		$message = $providerData->name." reject your request.";
		try {

			$booking_request = array(
				'service_provide_id' 	=> $uid,
				'service_user_id' 		=> $request->service_user_id,
				'booking_service_id' 	=> $request->booking_service_id,
				'booking_status' 		=> 2
			);

			$booking_req = Booking_requests::create($booking_request);

			$data['service_user_id'] 			= $booking_request['service_user_id'];
			$data['provider_id'] 				= $booking_request['service_provide_id'];
			$data['booking_service_id'] 		= $booking_request['booking_service_id'];
			$data['request_status'] 			= 2;

			$device_token_provider = User::where('id' , $booking_request['service_user_id'])->first();
			$token = $device_token_provider['device_token'];

			$update_job_status = User::where(['id' => $uid])->update(['job_status' => 0]);

			$update_job_status1 = User::where(['id' => $request->service_user_id])->update(['user_status' => 0]);

			sendPushnotification($token,'Smatserv', $message , $data ,2);

			return response()->json(['message' => "Booking request rejected!.",'provider_id' => $uid], 200);
		} catch (Exception $e) {
			return response()->json(['error' => 'something went wrong!.'], 409);
		}
	}

	function completeRequest(Request $request) {
		//Function based on provider
		$uid = $request->user()->id;
		$request->validate([
			'booking_service_id'	=>	'required'
		]);
		$data = array();
		$message = "Service completed by provider!.";

		try {
				$completeRequest = Booking_requests::where(['booking_service_id' => $request->booking_service_id,'service_provide_id' => $uid])->first();

				$booking_service_data = Booking_service::where('id',$request->booking_service_id)->first();

				if ($completeRequest) {
					$updateRequest = Booking_requests::where(['booking_service_id' => $request->booking_service_id,'service_provide_id' => $uid])->update(['booking_status' => 3]);
					$update_job_status = User::where(['id' => $uid])->update(['job_status' => 0]);


				$data['service_user_id'] 			= $completeRequest['service_user_id'];
				$data['provider_id'] 				= $completeRequest['service_provide_id'];
				$data['booking_service_id'] 		= $completeRequest['booking_service_id'];

				$data['service_user_email'] 		= $booking_service_data['service_user_email'];
				$data['service_price'] 				= $booking_service_data['service_price'];
				$data['request_status'] 			= 3;

				$device_token_user = User::with('user_details')->where('id' , $completeRequest['service_user_id'])->first();

				$token = $device_token_user['device_token'];

				$update_job_status = User::where(['id' => $uid])->update(['job_status' => 0]);

				$update_user_status = User::where(['id' => $completeRequest['service_user_id']])->update(['user_status' => 2]);

				sendPushnotification($token,'Smatserv', $message , $data ,3);

				return response()->json(['message' => "Booking request completed!."], 200);
			}
			
		} catch (Exception $e) {
			return response()->json(['error' => 'something went wrong!.'], 409);
		}
	}

	function startRequest(Request $request) {
		//Function based on provider
		$uid = $request->user()->id;
		$request->validate([
			'booking_service_id'	=>	'required'
		]);
		$data = array();
		$message = "Your service started!.";

		try {
			$completeRequest = Booking_requests::where(['booking_service_id' => $request->booking_service_id,'service_provide_id' => $uid])->first();

			if ($completeRequest) {
				$updateRequest = Booking_requests::where(['booking_service_id' => $request->booking_service_id,'service_provide_id' => $uid])->update(['booking_status' => 4]);

				$data['service_user_id'] 			= $completeRequest['service_user_id'];
				$data['provider_id'] 				= $completeRequest['service_provide_id'];
				$data['booking_service_id'] 		= $completeRequest['booking_service_id'];
				$data['request_status'] 			= 4;

				$device_token_provider = User::where('id' , $completeRequest['service_user_id'])->first();
				$token = $device_token_provider['device_token'];

				$update_job_status = User::where(['id' => $uid])->update(['job_status' => 1]);

				sendPushnotification($token,'Smatserv', $message , $data ,4);

				return response()->json(['message' => "Booking request start!."], 200);
			}
			
		} catch (Exception $e) {
			return response()->json(['error' => 'something went wrong!.'], 409);
		}
	}

	function tryTosendRequest(Request $request) { //alias "Try again"
		$message = 'Request received.';
		$rejectIds = array();
		try {
			$res = $this->getNearbyprovider(2,$request->user()->latitude,$request->user()->longitude,$request->category,$request->vehicle,$request->noids);

			if ($res->toArray()) {
				$arraRes = $res->toArray();
			}else{
				return response()->json(['message' => "Providers not found near by your location!."], 200);die;
			}
			
			$data['service_user_id']		= $request->user()->id;
			$data['service_user_name']		= $request->user()->name;
			$data['service_user_email']		= $request->user()->email;
			$data['service_user_contact']	= $request->user()->phone_number;
			$data['service_user_longitude']	= $request->user()->longitude;
			$data['service_user_latitude']	= $request->user()->latitude;
			

			$arr = array();
			foreach ($arraRes as $key => $value) {
				if(!empty($ids) && $value['id'] == $ids) {
					unset($key);
				}else{
					$arr[] = $value;
				}
			}

			/*----------------calculate distance from pickup and provider current location----------------*/
			$distance2 = $this->getDistancecalculation($request->pickup_latitude,$request->pickup_longitude,$arr[0]['latitude'],$arr[0]['longitude'],'K');
			/*--------------------------------------------------------------------------------------------*/
			
			if ($distance2 > 3) {
				return response()->json(['message' => "No providers found near by your location!."], 200);die;
			}

			$data['service_provide_id'] 			= $arr[0]['id'];
			$data['service_provider_name'] 			= $arr[0]['name'];
			$data['service_provider_latitude'] 		= $arr[0]['latitude'];
			$data['service_provider_longitude'] 	= $arr[0]['longitude'];
			$data['service_price']					= $arr[0]['user_details']['rate_per_hour'];
			$data['pickup_latitude']				= $request->pickup_latitude;
			$data['pickup_longitude']				= $request->pickup_longitude;
			$data['pickup_address']					= $request->pickup_address;
			$data['drop_latitude']					= $request->drop_latitude;
			$data['drop_longitude']					= $request->drop_longitude;
			$data['drop_address']					= $request->drop_address;

			$booking_service = Booking_service::create($data);
			$booking_id = $booking_service->id;
			$data['booking_service_id'] = $booking_id;
			$data['provider_id'] = $data['service_provide_id'];

			sendPushnotification($arr[0]['device_token'],'Smatserv', $message , $data ,2);
			
			return response()->json(['message' => "Your booking request sent successfully.please wait for service provider's repsonse!.",'request' => $data], 200);
		} catch (Exception $e) {
			return response()->json(['error' => 'failed to book service!.'], 400);
		}
	}

	public function allNotifications(Request $request){
		$request->validate([
			'reciver_id' => 'required',
		]);

		try {
			$notification = Push_notification::where('reciver_id' , $request->reciver_id)->get();
			$data_arr = array();
			foreach ($notification as $data){
				if ($data->notification_data != NULL) {
					$data->notification_data = json_decode($data->notification_data);
					$data_arr[] = $data;
				}else{
					$data_arr[] = $data;
				}
			}
			return response()->json(['message' => "Notifications fetched successfully!.",'notifications' => $data_arr], 200);
		} catch (Exception $e) {
			return response()->json(['error' => 'failed to get notifications!.'], 400);
		}
	}

	public function completeRequestSignature(Request $request){
		$request->validate([
			'signature' => 'image|mimes:jpeg,png,jpg',
			'booking_id' => 'required',
			'service_provide_id' => 'required',
		]);

		try {
			$filename_withext = $request->file('signature')->getClientOriginalName();
			$file_name = pathinfo($filename_withext, PATHINFO_FILENAME);            
			$extension_bussi = $request->file('signature')->getClientOriginalExtension();
			$mimeType = $request->file('signature')->getClientMimeType();
			$file_name_to_store = str_replace(" ", "-", $file_name).'_'.time().'.'.$extension_bussi;
			$path = $request->file('signature')->storeAs('images', $file_name_to_store);

			$createArray = array('booking_id' => $request->booking_id, 'service_provide_id' => $request->service_provide_id, 'signature' => $path);

			$signature = Signature::create($createArray);

			return response()->json(['message' => "user signature get successfully!.",'signature' => $signature], 200);
		} catch (Exception $e) {
			return response()->json(['error' => 'failed to get signature!.'], 400);
		}
	}


	public function policyData(Request $request){
		$data = policies::where('page_name' , $request->page_name)->first();
		return response()->json(['message' => "data get successfully!.",'data' => $data], 200);
	}

	public function addVehicle(Request $request){
		try {
			$results['parent_id']   = $request->category;
			$results['service']     = $request->vehicle;
			$results['price']       = $request->price;

			Price::create($results);
			return response()->json(['message' => "vehicle added successfully!."], 201);
		} catch (Exception $e) {
			return response()->json(['message' => "failed to add vehicle!."], 409);
		}
	}

	public function getPrice(Request $request){
		try {
			$parentCategories = Price::where('parent_id',0)->get();
			$categories = [];
			foreach ($parentCategories as $i => $category) {
				$categories[] = Price::with('subcategories')->where('id',$category->id)->first();
			}

			return response()->json(['message' => "data fetched successfully!.",'vehicle' => $categories], 200);
		} catch (Exception $e) {
			return response()->json(['error' => 'failed to fetched data!.'], 400);
		}
	}

	public function status(Request $request){
		try {
			$uid = $request->user()->id;
			$status = array();

			$provider = User::select('job_status')->where('id',$uid)->first();
			//$requestStatus = Booking_requests::select('booking_status')->where('booking_service_id',$request->booking_id)->first();

			$status['provider_job_satus'] = $provider->job_status;
			//$status['request_satus'] = $requestStatus->booking_status;

			return response()->json(['message' => "status fetched successfully!.",'status' => $status], 200);
		} catch (Exception $e) {
			return response()->json(['error' => 'failed to fetched data!.'], 400);
		}
	}

	public function userStatus(Request $request){
		try {
			$user = $request->user();

			/*$exist_service 		= Booking_service::where('service_user_id',$user->id)->orderBy('created_at', 'desc')->first();
			$exist_requests 	= Booking_requests::where('booking_service_id',$exist_service->id)->first();
			// $exist_requests 	= Booking_requests::where('booking_service_id',$exist_service->id)->count();

			if ($exist_requests['booking_status'] == 3) {
				$user->user_status = 0;
				$user->save();
			}*/

			return response()->json(['message' => "user status fetched successfully!.",'user_status' => $user->user_status], 200);
		} catch (Exception $e) {
			return response()->json(['error' => 'failed to fetched data!.'], 400);
		}
	}

	public function push()
	{
		echo env('FCM_KEY');
		$token = 'd_epLMl8Q6mLly6WTCTgPQ:APA91bHuB6ln_dCdZq5yYUpH_QUZAFdGPCTfw_BLLkBQMw7ZpOxcCDhqYm3h-fRpZrZaRxnsSFObc7DyC71U2x79zB1X4pv0aAP7CvVqvjR1YLFHs_CIrI1Iu7rF3aFyuMcs7DIoQA1Y';
		sendPushnotification($token,'Smatserv', 'message' , '' ,5);
	}

	/**
	 * Logout user (Revoke the token)
	 *
	 * @return [string] message
	 */
	public function logout(Request $request)
	{
		$request->user()->device_token = null;
		$request->user()->save();
		$request->user()->token()->revoke();
		return response()->json([
			'success' => 1,
			'message' => 'Successfully logged out!.',
		]);
	}
}
