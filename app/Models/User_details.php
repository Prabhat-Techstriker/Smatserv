<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
Use App\Models\User;

class User_details extends Model
{
    use HasFactory;

    public $table = 'users_details';

    protected $fillable = [
        'user_id',
        'service_provide_type',
		'vehicle_type',
		'vehicle_number',
		'type_of_mechanic',
		'courier_type',
		'haulage_type',
		'rate_per_hour',
		'identification_document',
        'description',
		'bussiness_certificate'
    ];


    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
