<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentInfo extends Model
{
	use HasFactory;

	public $table = 'paymentinfo';

	protected $fillable = [
		'payment_ref_id',
		'provider_id',
		'user_id',
		'price',
		'booking_id'
	];

	public function provider()
	{
		return $this->belongsTo('App\Models\User','provider_id', 'id');
	}

	public function user()
	{
		return $this->belongsTo('App\Models\User','user_id', 'id');
	}

	public function user_details()
	{
		return $this->belongsTo('App\Models\User_details','provider_id', 'user_id');
	}
}
