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


class PushnotificationController extends Controller
{
	public function notificationList(Request $request)
	{
		$uid = $request->user();

		try {
			if ($uid->service_type == 1) {
				// In case user
				$arr_val = array();
				$result = Push_notification::where('user_id',$uid->id)->whereNotIn('notification_type',[0,5,10])->get();
				foreach ($result as $key => $value) {
					$value['notification_data'] = json_decode($value['notification_data']);
					$arr_val[] = $value;
				}
				$result = $arr_val;
			}else{
				// in case provider
				$arr_val = array();
				//$result = Push_notification::where('provider_id',$uid)->get();
					$result = Push_notification::where('provider_id',$uid->id)->whereIn('notification_type',[0,5])->get();
				foreach ($result as $key => $value) {
					$value['notification_data'] = json_decode($value['notification_data']);
					$arr_val[] = $value;
				}
				$result = $arr_val;
			}

			return response()->json(['message' => 'notification fetched successfully!.','notification' => $result], 200);
		} catch (Exception $e) {
			return response()->json(['error' => 'failed to fetched notifications!.'], 400);
		}
		
	}
}
