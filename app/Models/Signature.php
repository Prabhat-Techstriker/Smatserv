<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{
	use HasFactory;

	public $table = 'signature';

	protected $fillable = [
		'booking_id',
		'service_provide_id',
		'signature',
	];
}
