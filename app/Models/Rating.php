<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

	public $table = 'adviser_ratings';

	protected $fillable = [
		'provider_id',
		'rating',
		'description',
		'user_id'
	];

	public function provider()
	{
		return $this->belongsTo('App\Models\User','provider_id', 'id');
	}

	public function user()
	{
		return $this->belongsTo('App\Models\User','user_id', 'id');
	}

	public function provider_details()
	{
		return $this->belongsTo('App\Models\User_details','provider_id', 'user_id');
	}
}
