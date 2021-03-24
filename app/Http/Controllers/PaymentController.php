<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking_service;
use App\Models\Booking_requests;
use App\Models\PaymentInfo;


class PaymentController extends Controller
{
	public function paymentInfo(Request $request)
	{
		$uid = $request->user()->id;
		$request->request->add(['user_id' => $uid]); 
		$request->all();
		try {
			$poviderDetails = User::where('id',$request->provider_id)->first();
			$userDetails 	= User::where('id',$request->user_id)->first();

				$user_details 	= PaymentInfo::create($request->all());

			/* Upadte user status 0 in user table */
				$updateUser 	= User::where('id',$request->user_id)->update(['user_status' => 0]);
				$updaterequest 	= Booking_requests::where('booking_service_id',$request->booking_id)->update(['booking_status' => 9]);
			/* --------------------------------- */

			$data['provider_id']					= $request->provider_id;
			$data['service_provider_name']			= $poviderDetails->name;
			$data['service_price']					= $request->price;
			$data['service_user_id']				= $request->user_id;
			$data['service_user_name']				= $userDetails->name;
			$data['booking_service_id']				= $request->booking_id;
			$data['payment_ref_id']					= ($request->payment_ref_id == "Cash") ? 0 : 1;
			
			$message = "Payment successfull!.";

			sendPushnotification($poviderDetails->device_token,'Smatserv', $message , $data ,10);
			return response()->json(['status' => 'success', 'message' => 'payment info saved successfully!.'], 200);
		} catch (\Exception $e) {
			return response()->json(['message' => 'failed to saved payment info!.'], 409);
		}
	}

	public function getpaymentInfo(Request $request)
	{
		$uData = $request->user();
		try {
			if ($request->service_type == 1) {
				$data 	= PaymentInfo::with('user','provider')->where('user_id',$uData->id)->get();
			} else {
				$data 	= PaymentInfo::with('user','provider')->where('provider_id',$uData->id)->get();
			}
			return response()->json(['status' => 'success', 'message' => 'payment info fetched successfully!.','data' => $data], 200);
		} catch (\Exception $e) {
			return response()->json(['message' => 'failed to fetched payment info!.'], 409);
		}
	}
}
