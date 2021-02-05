<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'location';

    protected $fillable = ['name','lat','lon'];


	public $timestamps = false; 


	public static function getMenunfo($id) 
    { 
		return Menu::find($id);
	}
	
	public function scopeSearchByKeyword($query, $keyword)
    {
        if ($keyword!='') {
            $query->where(function ($query) use ($keyword) {
                $query->where("name", "LIKE","%$keyword%");                     
            });
        }
        return $query;
    }
	 
}
