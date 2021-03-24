<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\User_details;
use App\Models\Tracking;
use App\Models\Booking_service;
use App\Models\Booking_requests;

class TrackingController extends Controller
{
	public function updateTracking(Request $request){
		$finalData = array();
		$uid = $request->user()->id;
		try {
			$request->validate([
				'booking_id' 			=> 'required',
				//'provider_id' 			=> 'required|string',
				'tracking_latitude' 	=> 'required|string',
				'tracking_longitude' 	=> 'required|string',
			]);

			$insert = array('booking_id' =>  $request->booking_id,
				'provider_id' 			=> $uid,
				'tracking_latitude' 	=>  $request->tracking_latitude,
				'tracking_longitude' 	=>  $request->tracking_longitude
			);

			$update = 	Tracking::updateOrCreate(['booking_id' => $request->booking_id],$insert);
			$data 	=	Booking_service::with('user')->where('id',$request->booking_id)->first();

			$finalData['tracking'] = $update;
			$finalData['providerData'] = $data;

			return response()->json(['message' => "updated successfully!.",'data' => $finalData], 200);
		} catch (Exception $e) {
			return response()->json(['error' => 'failed to update data!.'], 400);
		}
	}

	public function getTracking(Request $request){
		$uid = $request->user()->id;
		$finalData = array();
		try {
			$update = 	Tracking::where(['booking_id' => $request->booking_id])->first();
			$pick_drop_lat_long = Booking_service::select('pickup_latitude','pickup_longitude','drop_latitude','drop_longitude')->where(['id' => $request->booking_id])->first();
			$finalData['trackingData'] = $update;
			$finalData['pic_drop'] = $pick_drop_lat_long;
			return response()->json(['message' => "fetched successfully!.",'data' => $finalData], 200);
		} catch (Exception $e) {
			return response()->json(['error' => 'failed to fetched data!.'], 400);
		}
	}

	public function getRides(Request $request){
		$user = $request->user();
		$request = $request->all();

		try {
			if($request['service_type'] == 2){
				$data = Booking_requests::with('booking_service')->where(['service_provide_id' => $user->id])->get();
			}else{
				$data = Booking_requests::with('booking_service')->where(['service_user_id' => $user->id])->get();
			}

			return response()->json(['message' => "fetched successfully!.",'data' => $data], 200);
		} catch (Exception $e) {
			return response()->json(['error' => 'failed to fetched data!.'], 400);
		}
	}
}
