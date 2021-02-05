<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';

    protected $fillable = ['restaurant_id','menu_cat','menu_name', 'description','price','menu_image'];


	public $timestamps = false; 


	public static function getMenunfo($id) 
    { 
		return Menu::find($id);
	}
	
	public function scopeSearchByKeyword($query, $keyword)
    {
        if ($keyword!='') {
            $query->where(function ($query) use ($keyword) {
                $query->where("menu_name", "LIKE","%$keyword%");                     
            });
        }
        return $query;
    }
	 
}
