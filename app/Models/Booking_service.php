<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
Use App\Models\Booking_requests;

class Booking_service extends Model
{
	use HasFactory;

	public $table = 'booking_service';

	protected $fillable = [
		'service_provide_id',
		'service_provider_name',
		'service_price',
		'service_provider_latitude',
		'service_provider_longitude',
		'service_rating',
		'service_user_id',
		'service_user_name',
		'service_user_email',
		'service_user_contact',
		'service_user_latitude',
		'service_user_longitude',
		'pickup_latitude',
		'pickup_longitude',
		'pickup_address',
		'drop_latitude',
		'drop_longitude',
		'drop_address',
	];

	public function booking()
	{
		return $this->hasOne('App\Models\Booking_requests');
	}

	public function user()
	{
		return $this->belongsTo('App\Models\User','service_provide_id', 'id');
	}
}