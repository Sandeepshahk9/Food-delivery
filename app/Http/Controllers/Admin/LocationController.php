<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\User;
use App\Menu;
use App\Categories;
use App\Restaurants;
use App\Location;

use App\Http\Requests;
use Illuminate\Http\Request;
use Session;
use Intervention\Image\Facades\Image; 
use Illuminate\Support\Facades\DB;
class LocationController extends MainAdminController
{
	public function __construct()
    {
		 $this->middleware('auth');
		  
		parent::__construct(); 	
		  
    }
    public function location_list()    { 
        $loc = DB::table('location')->get();
        
        if(Auth::User()->usertype!="Admin"){
            \Session::flash('flash_message', 'Access denied!');
            return redirect('admin/dashboard');            
        }
        
         
        return view('admin.pages.location',compact('loc'));
    }
    
    public function addeditlocation()    { 
         
        if(Auth::User()->usertype!="Admin"){
            \Session::flash('flash_message', 'Access denied!');
            return redirect('admin/dashboard');            
        }
       
        return view('admin.pages.owner.addeditlocation');
    }
	
	public function editlocation($loc_id)    { 
         
        if(Auth::User()->usertype!="Admin"){
            \Session::flash('flash_message', 'Access denied!');
            return redirect('admin/dashboard');            
        }
		$loc = DB::table('location')->where('id',$loc_id)->get();
		
        return view('admin.pages.owner.editlocation',compact('loc'));
    }
    
    public function addnew(Request $request)
    { 
    	
    	$data =  \Input::except(array('_token')) ;
	    
	    $rule=array(
		        'name' => 'required',
                'lat' => 'required',
                'log' => 'required'		         
		   		 );
	    
	   	 $validator = \Validator::make($data,$rule);
 
        if ($validator->fails())
        {
                return redirect()->back()->withErrors($validator->messages());
        } 
	    $inputs = $request->all();
		
		if(!empty($inputs['id'])){           
            $loc = Location::findOrFail($inputs['id']);
        }else{
            $loc = new Location;
        }
		
        
		$loc->name = $inputs['name'];
		$loc->lat = $inputs['lat'];
        $loc->log = $inputs['log'];
	    $loc->save();
		
		if(!empty($inputs['id'])){           
            \Session::flash('flash_message', 'Updated');
			return \Redirect::back();
        }else {
			\Session::flash('flash_message', 'Added');
			return \Redirect::back();
		}
    }     
    
    public function editmenu($id,$menu_id)    
    {     
    
    	  if(Auth::User()->usertype!="Admin"){

            \Session::flash('flash_message', 'Access denied!');

            return redirect('admin/dashboard');
            
        }
          


          $menu = Menu::findOrFail($menu_id);
          
          $categories = Categories::where("restaurant_id", $id)->orderBy('category_name')->get();

          $restaurant_id=$id;

          return view('admin.pages.addeditmenu',compact('menu','categories','restaurant_id'));
        
    }	 
    
    public function delete($loc_id)
    {
       
    	if(Auth::User()->usertype=="Admin" or Auth::User()->usertype=="Owner")
        {
 
             $loc = Location::findOrFail($loc_id);
             $loc->delete();

            \Session::flash('flash_message', 'Deleted');

            return redirect()->back();
        }
        else
        {
            \Session::flash('flash_message', 'Access denied!');

            return redirect('admin/dashboard');
            
        
        }

    }

    public function owner_menu()    
    { 
        
        
        $user_id=Auth::User()->id;

        $restaurant= Restaurants::where('user_id',$user_id)->first();

        $restaurant_id=$restaurant['id'];

        $menu = Menu::where("restaurant_id", $restaurant_id)->orderBy('menu_name')->get();
        
        if(Auth::User()->usertype!="Owner"){

            \Session::flash('flash_message', 'Access denied!');

            return redirect('admin/dashboard');
            
        }

 
        return view('admin.pages.owner.menu',compact('menu','restaurant_id'));
   
    }

    public function owner_addeditmenu()    { 

        if(Auth::User()->usertype!="Owner"){

            \Session::flash('flash_message', 'Access denied!');

            return redirect('admin/dashboard');
            
        }

        $user_id=Auth::User()->id;

        $restaurant= Restaurants::where('user_id',$user_id)->first();

        $restaurant_id=$restaurant['id'];

        $categories = Categories::where("restaurant_id", $restaurant_id)->orderBy('category_name')->get();

         

        return view('admin.pages.owner.addeditmenu',compact('categories','restaurant_id'));
    }
    
    public function locationeditmenu($item_id)    
    {     
    
          if(Auth::User()->usertype!="Owner"){

            \Session::flash('flash_message', 'Access denied!');

            return redirect('admin/dashboard');
            
        }
          
		$user_id=Auth::User()->id;

		$restaurant= Restaurants::where('user_id',$user_id)->first();

		$restaurant_id=$restaurant->id;

		$menu = Menu::findOrFail($menu_id);

		$categories = Categories::where("restaurant_id", $restaurant_id)->orderBy('category_name')->get();
		return view('admin.pages.owner.addeditmenu',compact('menu','categories','restaurant_id'));
        
    } 
	
	public function import_excel(Request $request)
    {
		
		$inputs = $request->all();
			
		$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
		if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$csvMimes)){
		if(is_uploaded_file($_FILES['file']['tmp_name'])){

		//open uploaded csv file with read only mode
		$csvFile = fopen($_FILES['file']['tmp_name'], 'r');

		//skip first line
		fgetcsv($csvFile);

		//parse data from csv file line by line
		while(($line = fgetcsv($csvFile)) !== FALSE){
			//echo $line[1]; die;	
			$menu = new Menu; 
			$menu->restaurant_id = $inputs['res_id'];
			$menu->menu_cat = $line[0];
			$menu->food_type =$line[1];
			$menu->menu_name = $line[2];
			$menu->sub_title = $line[3];
			$menu->description = $line[4];
			$menu->price = $line[5];
			$menu->description2 = $line[6];
			$menu->price2 = $line[7];
			$menu->description3 = $line[8];
			$menu->price3 = $line[9];
			$menu->description4 = $line[10];
			$menu->price4 = $line[11];
			$menu->description5 = $line[12];
			$menu->price5 = $line[13];
			$menu->description6 = $line[14];
			$menu->price6 = $line[15];
			$menu->description7 = $line[16];
			$menu->price7 = $line[17];
			$menu->description8 = $line[18];
			$menu->price8 = $line[19];
			$menu->description9 = $line[20];
			$menu->price9 = $line[21];			
			$menu->save();			
		}

		//close opened csv file
		fclose($csvFile);

		$qstring = '?status=succ';
		}else{
		$qstring = '?status=err';
		}
		}else{
		$qstring = '?status=invalid_file';
		}
		return redirect('admin/restaurants/view/'.$inputs['res_id'].'/menu');
	}
	
}
