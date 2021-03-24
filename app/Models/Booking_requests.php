<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking_requests extends Model
{
	use HasFactory;

	public $table = 'booking_requests';

	protected $fillable = [
		'service_provide_id',
		'service_user_id',
		'booking_service_id',
		'booking_status',
		'cancel_reason'
	];

	public function booking_service()
	{
		return $this->belongsTo('App\Models\Booking_service');
	}
}
