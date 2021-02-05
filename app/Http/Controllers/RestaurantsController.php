<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Restaurants;
use App\Categories;
use App\Menu;
use App\Types;
use App\Review;

use App\Http\Requests;
use Illuminate\Http\Request;
use Session;
use Intervention\Image\Facades\Image; 
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\UrlGenerator;

class RestaurantsController extends Controller
{
	 
    public function index(Request $request)    
    { 
        $res = DB::table('restaurants')
			   ->leftJoin('restaurant_types', 'restaurants.restaurant_type', '=', 'restaurant_types.id')
			   ->select('restaurants.*','restaurant_types.type')
			   //->where('restaurants.cat_id', '=', $cat->id)
			   ->orderBy('id', 'desc')
			   ->paginate(10);		
        
         $res->setPath($request->url()); 
		 //print_r($res); die;
         $res_count = count($res); 
         $category_search=NULL; 
        return view('pages.restaurants',compact('res','res_count','category_search'));
    }

    public function restaurants_type(Request $request,$type)    
    { 
        $res = DB::table('restaurants')
                           ->leftJoin('restaurant_types', 'restaurants.restaurant_type', '=', 'restaurant_types.id')                           
                           ->select('restaurants.*','restaurant_types.type')
                           ->where('restaurant_types.id', '=', $type)
                           ->orderBy('id', 'desc')
                           ->paginate(10);
        
        $res->setPath($request->url()); 
		$res_count = count($res); 
        return view('pages.restaurants',compact('res','res_count'));
    }

    public function restaurants_rating(Request $request,$rating)    
    { 
        
              
        //$restaurants = Restaurants::orderBy('restaurant_name')->get();

        $restaurants = DB::table('restaurants')
                           ->leftJoin('restaurant_types', 'restaurants.restaurant_type', '=', 'restaurant_types.id')                           
                           ->select('restaurants.*','restaurant_types.type')
                           ->where('restaurants.review_avg', '=', $rating)
                           ->orderBy('id', 'desc')
                           ->paginate(10);
        
         $restaurants->setPath($request->url()); 

         
         
        return view('pages.restaurants',compact('restaurants'));
    }
    public function restaurants_search_home($cat)    
    {   
		$keyword ='restaurants';
		$category_search = $cat;	
		$result = DB::table('restaurants');
		$result->leftJoin('restaurant_types', 'restaurants.restaurant_type', '=', 'restaurant_types.id');
		$result->select('restaurants.*','restaurant_types.type'); 
		$result->orderBy('restaurants.review_avg', 'desc');
		$res = $result->get();
		$total_res=count($res); 
        return view('pages.restaurants_search',compact('res','total_res','keyword','category_search'));
    }

    public function restaurants_search(Request $request)    
    {           
        
        $inputs = $request->all();
		
		if(isset($inputs['category']))	{
			$category_search = $inputs['category'];	
		}
		else{
			$category_search ="1.2";
		}		
		if(isset($inputs['rate']) && isset($inputs['category'])) {	
			if($inputs['rate']=='flat'){
				$inputs['rate']='asc';
			}
			$result = DB::table('restaurants');
            $result->leftJoin('restaurant_types', 'restaurants.restaurant_type', '=', 'restaurant_types.id');                           
            $result->select('restaurants.*','restaurant_types.type'); 
			$result->orderBy('restaurants.review_avg', $inputs['rate']);
            $res = $result->get();
		}else {
			//echo 'hii'; die;
		   $keyword = $inputs['search_keyword'];
		   $res = Restaurants::SearchByKeyword($keyword)->get();
		   $category_search="1.2";
		}

       $total_res=count($res);  
	   
       return view('pages.restaurants_search',compact('res','total_res','keyword','category_search'));
    }
     
    public function restaurants_menu($slug)    
    {
		$current_url = url()->current();
		Session::set('set_url',$current_url);
		$restaurant = Restaurants::where("restaurant_slug", $slug)->first();		
		$slug = $slug; 
		$keyword=""; 
		return view('pages.restaurants_menu',compact('restaurant','slug','keyword'));
        
    } 

	public function restaurants_search_menu($slug, Request $request)    
    { 
        $inputs = $request->all();
        $keyword = $inputs['search_keyword']; 
		$restaurant = Restaurants::where("restaurant_slug", $slug)->first();
		$total_res=count($restaurant);  
		$slug = $slug; 
        return view('pages.restaurants_menu',compact('restaurant','total_res','keyword','slug'));
    }	
    
    public function restaurants_details($slug,Request $request)    
    {     
          $restaurant = Restaurants::where("restaurant_slug", $slug)->first();
          
          $reviews = DB::table('restaurant_review')                            
                           ->select('restaurant_review.*')
                           ->where('restaurant_review.restaurant_id', '=', $restaurant->id)
                           ->orderBy('restaurant_review.id', 'desc')
                           ->paginate(10);
        
           $reviews->setPath($request->url()); 

           $total_review = Review::where("restaurant_id", $restaurant->id)->count();
          
          return view('pages.restaurants_details',compact('restaurant','reviews','total_review'));
        
    }	 
    
    
     public function restaurant_review(Request $request)    
    {     
         
        
        $inputs = $request->all();

        $user_id=Auth::user()->id;

        $review = new Review; 

        $review->restaurant_id = $inputs['restaurant_id']; 
        $review->user_id = $user_id;       
        $review->review_text = $inputs['review_text'];
        $review->food_quality = $inputs['food_quality'];
        $review->price = $inputs['price'];
        $review->punctuality = $inputs['punctuality'];
        $review->courtesy = $inputs['courtesy'];      
        $review->date= strtotime(date('Y-m-d'));  

        $review->save();

        $food_quality=round(DB::table('restaurant_review')->where('restaurant_id', $inputs['restaurant_id'])->avg('food_quality'));

        $price=round(DB::table('restaurant_review')->where('restaurant_id', $inputs['restaurant_id'])->avg('price'));

        $punctuality=round(DB::table('restaurant_review')->where('restaurant_id', $inputs['restaurant_id'])->avg('punctuality'));

        $courtesy=round(DB::table('restaurant_review')->where('restaurant_id', $inputs['restaurant_id'])->avg('courtesy'));

        $total_avg=round($food_quality+$price+$punctuality+$courtesy)/4;

        $restaurant_obj = Restaurants::findOrFail($inputs['restaurant_id']);

        $restaurant_obj->review_avg = $total_avg;  
        $restaurant_obj->save();  

          return \Redirect::back();
    }   
    	
}
