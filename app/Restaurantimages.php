<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurantimages extends Model
{
    protected $table = 'restaurant_images';
    protected $fillable = ['restaurant_id', 'images'];
	//public $timestamps = false;

}
