<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Push_notification extends Model
{
	use HasFactory;

	public $table = 'pushnotification';

	protected $fillable = [
		'reciver_id',
		'message',
		'notification_data',
		'notification_type',
		'booking_id',
		'user_id',
		'provider_id'
	];
}
