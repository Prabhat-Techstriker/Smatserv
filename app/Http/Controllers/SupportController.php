<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\User_details;
use App\Models\SupportModel;

class SupportController extends Controller
{
	/*
	* Insert support message for admin
	*/
	public function create(Request $request)
	{
		$userData = $request->user();

		$request->validate([
			'support_text' => 'required|string',
		]);

		try {
			$request->request->add(['user_id' => $userData->id]);
			$insert = SupportModel::create($request->all());
			return response()->json(['status' => 'success', 'message' => 'data submitted successfully!.'], 200);
		} catch (\Exception $e) {
			return response()->json(['error' => 'failed to submit data!.'], 400);
		}
	}
}
