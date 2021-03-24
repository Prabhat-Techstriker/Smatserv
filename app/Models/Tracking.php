<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
	use HasFactory;

	public $table = 'tracking';

	protected $fillable = [
		'booking_id',
		'provider_id',
		'tracking_latitude',
		'tracking_longitude',
	];
}
