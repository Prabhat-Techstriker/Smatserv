<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportModel extends Model
{
	use HasFactory;

	public $table = 'support';

	protected $fillable = [
		'user_id',
		'support_text',
	];

	public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
