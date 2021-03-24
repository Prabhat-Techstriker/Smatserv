<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $fillable = [
        'service',
        'parent_id',
        'price',
    ];


    public function subcategories() {
		return $this->hasMany('App\Models\Price', 'parent_id');
	}

}
