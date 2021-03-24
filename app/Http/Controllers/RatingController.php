<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\User_details;
use App\Models\Rating;

class RatingController extends Controller
{
	public function createRating(Request $request)
	{
		$uid 	= $request->user()->id;
		$request->validate([
			'provider_id' => 'required|integer',
			'rating' => 'required',
		]);
		$request->request->add(['user_id' => $uid]); 
		$data 	= $request->all();
		
		try {
			$data = Rating::create($data);
			return response()->json(['message' => "rating inserted successfully!.",'data' => $data], 200);
		} catch (Exception $e) {
			return response()->json(['error' => 'failed to inserted rating!.'], 400);
		}
	}

	public function getRatings(Request $request)
	{
		$uid 	= $request->user()->id;
		
		try {
			$data 	= Rating::where(['provider_id' => $uid])->sum('rating');
			$count 	= Rating::where(['provider_id' => $uid])->count();
			
			$totalRating = $data/$count;
			return response()->json(['message' => "rating inserted successfully!.",'data' => $totalRating], 200);
		} catch (Exception $e) {
			return response()->json(['error' => 'failed to inserted rating!.'], 400);
		}
	}
}
