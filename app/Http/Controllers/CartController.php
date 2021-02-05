<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Restaurants;
use App\Cart;
use App\Order;
use App\Menu;
use App\Types;

use App\Http\Requests;
use Illuminate\Http\Request;
use Session;
use Intervention\Image\Facades\Image; 
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
	 
    public function add_cart_item($item_id,$field_name,$menu_price,$row_num,$slug)    
    { 
        if (!Auth::check())
		{ return redirect('/login'); }
        $user_id=Auth::user()->id; 

        $find_cart_item = Cart::where(['user_id'=>$user_id,'item_id'=>$item_id])->first();
		
        

       if($find_cart_item!="")
       {
		   
         //echo $singl_item_price= $find_cart_item->$field_name/$find_cart_item->quantity; die;
          $find_cart_item->increment('quantity');

          $new_quantity=$find_cart_item->quantity;

          $new_price=$menu_price+$find_cart_item->$field_name;

          $find_cart_item->$field_name=$new_price;
          

          $find_cart_item->save();
       }
       else
       {
		   
          $menu = Menu::findOrFail($item_id);
		  /*$users = Cart::where(['user_id'=>$user_id, 'restaurant_id'=>$menu->restaurant_id ])->get();
		  if($users == NULL) {
			  DB::table('cart')->where('user_id', $user_id)->delete();
		  }*/
		  
		    $users = Cart::where(['user_id'=>$user_id])->get();		
			if($users)
			{
				foreach($users as $u){
					//echo $menu->restaurant_id;
					if($menu->restaurant_id!=$u->restaurant_id) {
						//echo $u->id;
						DB::table('cart')->where('id', $u->id)->delete();
					}
					//$res_id=$u->restaurant_id;
					
				}
				
			}
		 // die;
          $cart = new Cart; 
          $cart->user_id = $user_id;
          $cart->restaurant_id =$menu->restaurant_id;
          $cart->item_id = $menu->id; 
          $cart->item_name = $menu->menu_name;       
          $cart->$field_name = $menu_price;         
          $cart->quantity= '1';             
          $cart->save();
       }              
      // return \Redirect::back();
	  return redirect('restaurants/menu/'.$slug."#tab_id".$row_num);
    }

     
    
    public function delete_cart_item($id)
    {       
        
        $cart = Cart::findOrFail($id); 
        $cart->delete();
        return redirect('order_details?lat1=&log1=&submit_cart=');

    }
    
	public function location_submit(Request $request)
    { 
		//echo 'hiii'; die;
		if (!Auth::check())
		{ return redirect('/login'); }
		$inputs = $request->all();
		//print_r($inputs); die;
        $loc = DB::table('location')->where('id',$inputs['location'])->get();
		//print_r($loc); die;
		if($loc){
			return redirect("order_details?lat1=".$loc[0]->lat."&log1=".$loc[0]->log."&submit_cart=");
		}
        
    } 
	
    public function order_details()
    { 
		if (!Auth::check())
		{ return redirect('/login'); }

        $user_id=Auth::user()->id;
        $user = User::findOrFail($user_id);		
		$locations = DB::table('location')->get();

        return view('pages.cart_order_details',compact('user','locations'));
    } 
	public function confirm_order_sms_details(Request $request)
    {

		$user_id=Auth::user()->id;
		$inputs = $request->all();
			//if(Session::get('otp') == $inputs['otp']) {
				
			$cart_res = Cart::where(['user_id'=>$user_id])->get();
			$menu_item="";
			$item_name="";
			
			$des="";
			$sum_qty=0;
			foreach ($cart_res as $n => $cart_item) {
				$menu = Menu::where(['id'=>$cart_item->item_id])->first();
				if($menu){
				if($n==0){
					$menu_item.=$cart_item->item_id;
					$item_name.=$cart_item->item_name;
					
					
					$des.=$cart_item->item_name;
					if($menu->sub_title!=NULL){
					$des.="-".$menu->sub_title;	
					}
					$des.=" (";
					if($cart_item->item_price!=0 && $menu->description!=""){
						$des.=$menu->description."(".($cart_item->item_price/$menu->price).") :&#8377;".$cart_item->item_price;
					}
					if($cart_item->item_price2!=0 && $menu->description2!=""){
						$des.=", ".$menu->description2."(".($cart_item->item_price2/$menu->price2).") :&#8377;".$cart_item->item_price2;
					}
					if($cart_item->item_price3!=0 && $menu->description3!=""){
						$des.=", ".$menu->description3."(".($cart_item->item_price3/$menu->price3).") :&#8377;".$cart_item->item_price3;
					}
					if($cart_item->item_price4!=0 && $menu->description4!=""){
						$des.=", ".$menu->description4."(".($cart_item->item_price4/$menu->price4).") :&#8377;".$cart_item->item_price4;
					}
					if($cart_item->item_price5!=0 && $menu->description5!=""){
						$des.=", ".$menu->description5."(".($cart_item->item_price5/$menu->price5).") :&#8377;".$cart_item->item_price5;
					}
					if($cart_item->item_price6!=0 && $menu->description6!=""){
						$des.=", ".$menu->description6."(".($cart_item->item_price6/$menu->price6).") :&#8377;".$cart_item->item_price6;
					}
					if($cart_item->item_price7!=0 && $menu->description7!=""){
						$des.=", ".$menu->description7."(".($cart_item->item_price7/$menu->price7).") :&#8377;".$cart_item->item_price7;
					}
					if($cart_item->item_price8!=0 && $menu->description8!=""){
						$des.=", ".$menu->description8."(".($cart_item->item_price8/$menu->price8).") :&#8377;".$cart_item->item_price8;
					}
					if($cart_item->item_price9!=0 && $menu->description9!=""){
						$des.=", ".$menu->description9."(".($cart_item->item_price9/$menu->price9).") :&#8377;".$cart_item->item_price9;
					}
					$des.=") ";
					
				}else{
					$menu_item.=",".$cart_item->item_id;
					$item_name.=",".$cart_item->item_name;
					
					$des.=", ".$cart_item->item_name;
					
					if($menu->sub_title!=NULL){
						$des.="-".$menu->sub_title;	
					}
					$des.=" (";
					
					if($cart_item->item_price!=0 && $menu->description!=""){
						$des.=$menu->description."(".($cart_item->item_price/$menu->price).") :&#8377;".$cart_item->item_price;
					}
					if($cart_item->item_price2!=0 && $menu->description2!=""){
						$des.=", ".$menu->description2."(".($cart_item->item_price2/$menu->price2).") :&#8377;".$cart_item->item_price2;
					}
					if($cart_item->item_price3!=0 && $menu->description3!=""){
						$des.=", ".$menu->description3."(".($cart_item->item_price3/$menu->price3).") :&#8377;".$cart_item->item_price3;
					}
					if($cart_item->item_price4!=0 && $menu->description4!=""){
						$des.=", ".$menu->description4."(".($cart_item->item_price4/$menu->price4).") :&#8377;".$cart_item->item_price4;
					}
					if($cart_item->item_price5!=0 && $menu->description5!=""){
						$des.=", ".$menu->description5."(".($cart_item->item_price5/$menu->price5).") :&#8377;".$cart_item->item_price5;
					}
					if($cart_item->item_price6!=0 && $menu->description6!=""){
						$des.=", ".$menu->description6."(".($cart_item->item_price6/$menu->price6).") :&#8377;".$cart_item->item_price6;
					}
					if($cart_item->item_price7!=0 && $menu->description7!=""){
						$des.=", ".$menu->description7."(".($cart_item->item_price7/$menu->price7).") :&#8377;".$cart_item->item_price7;
					}
					if($cart_item->item_price8!=0 && $menu->description8!=""){
						$des.=", ".$menu->description8."(".($cart_item->item_price8/$menu->price8).") :&#8377;".$cart_item->item_price8;
					}
					if($cart_item->item_price9!=0 && $menu->description9!=""){
						$des.=", ".$menu->description9."(".($cart_item->item_price9/$menu->price9).") :&#8377;".$cart_item->item_price9;
					}
					$des.=") ";
				  }
				  }
				$sum_qty =$sum_qty+$cart_item->quantity;
			  }
			  
			//echo $des; die;
			$restau_id = $cart_item->restaurant_id;
			$order = new Order; 
            $order->user_id = $user_id;
            $order->restaurant_id =$cart_item->restaurant_id;
            $order->item_id = $menu_item; 
            $order->item_name = $item_name;       
            $order->order_description = $des;       
            $order->item_price = $inputs['tot_price'];         
            $order->quantity= $sum_qty;  
            
            $order->status= 'Pending';             
            $order->save();
			
			$user_details = DB::table('users')->where('id',$user_id)->get(); 
			$restaurant_details = DB::table('restaurants')->where('id',$restau_id)->get(); 
			$email_cc=$user_details[0]->email;
			date_default_timezone_set("Asia/Kolkata");
			$data = array(
			'name'=>$user_details[0]->first_name." ".$user_details[0]->last_name,
			'email'=>$user_details[0]->email,
			'Mobile No:'=>$user_details[0]->mobile,
			'restaurant'=> $restaurant_details[0]->restaurant_name,
			'menu_name'=>$item_name,
			'order_des'=>$des,
			'price' => $inputs['tot_price'],
			'distance' => $inputs['distance_km'],
			'del_charge' => $inputs['del_charge'],
			'quantity' => $sum_qty,
			'time' => date('d/m/Y h:i:s a'),
			'link'=>"https://www.google.com/maps/?q=".$inputs['latitute'].",".$inputs['lognitute']
			);
			
			$subject="Place Order-".time();

			 \Mail::send('emails.order_item', $data, function ($message) use ($subject,$email_cc){
                $message->from(getcong('site_email'), getcong('site_name'));
                $message->to(getcong('site_email'))->cc($email_cc)->subject($subject);
            });
			Cart::where('user_id', '=', $user_id)->delete();
		return redirect('myorder');	
	}
	
	public function send_otp()
    {
		$msg = 'no';
			
		$request = Request::create('https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey=wzTDnxHO0kqOOWQ59euQ4w&senderid=TESTIN&channel=2&DCS=0&flashsms=0&number=918961045792&text=test message hello&route=clickhere', 'GET'); 
		 $response = array(
            'status' => 'success',
            'msg' => $msg,
        );
        return \Response::json($response);
	}
	
	
	public function apply_coupon($coupon_code,$user_id)
    {
		//$user_id=Auth::user()->id;
		
		$cp_discount = 0; 
		$msg = 'no'; 
		$res = DB::table('cart')->where('user_id', $user_id)->first();
	
			$cp_res = DB::table('restaurants')->where(array('coupon_code'=>$coupon_code,'id'=>$res->restaurant_id))->first();
			if($cp_res){				
				$msg = 'yes';
				DB::table('cart')->where(['user_id'=>$user_id,'restaurant_id'=>$res->restaurant_id])->update(['discount' =>$cp_res->coupon_discount]);
			}
				 
		 
		 $response = array(
            'status' => 'success',
            'msg' => $msg,
        );
        return \Response::json($response);
	}
	
	public function auto_refresh($tot,$res_id)
    {
		$msg='no';
		$tot=$tot-1;
		$cp_res = \App\Menu::where('restaurant_id',$res_id)->count();
		if($cp_res>$tot){
			$msg="yes";
		}
				 
		 $response = array(
            'status' => 'success',
            'msg' => $msg,
        );
        return \Response::json($response);
	}

    public function confirm_order_details(Request $request)
    { 
		
		if (!Auth::check())
		{ return redirect('/login'); }
	
		$user_id=Auth::user()->id;
		
        $user = User::findOrFail($user_id);	
		$inputs = $request->all();	
		$user->first_name = $inputs['first_name']; 
        $user->last_name = $inputs['last_name'];       
        $user->email = $inputs['email'];
        $user->mobile = $inputs['mobile'];
        $user->city = $inputs['city'];
        $user->postal_code = $inputs['postal_code'];
        $user->address = $inputs['address'];         
        $user->save();
		
		$lat1 = $inputs['lat1']; 
		$log1 = $inputs['log1']; 
		Session::set('otp',rand(0,99999));
       /* $data =  \Input::except(array('_token')) ;
        
        $inputs = $request->all();
        
        
            $rule=array(
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|max:75',
                'mobile' => 'required',
                'city' => 'required',
                'postal_code' => 'required',
                'address' => 'required'
                 );
       
        
         $validator = \Validator::make($data,$rule);
 
        if ($validator->fails())
        {
                return redirect()->back()->withErrors($validator->messages());
        } 

        $user_id=Auth::user()->id;
           
        $user = User::findOrFail($user_id);
 
         
        
        $user->first_name = $inputs['first_name']; 
        $user->last_name = $inputs['last_name'];       
        $user->email = $inputs['email'];
        $user->mobile = $inputs['mobile'];
        $user->city = $inputs['city'];
        $user->postal_code = $inputs['postal_code'];
        $user->address = $inputs['address'];         
         
         
        $user->save();

        $cart_res=Cart::where('user_id',$user_id)->orderBy('id')->get();

        

        foreach ($cart_res as $n => $cart_item) {
            
            $order = new Order; 
 
            $order->user_id = $user_id;
            $order->restaurant_id =$cart_item->restaurant_id;
            $order->item_id = $cart_item->item_id; 
            $order->item_name = $cart_item->item_name;       
            $order->item_price = $cart_item->item_price;         
            $order->quantity= $cart_item->quantity;  

            $order->created_date= strtotime(date('Y-m-d'));  

            $order->status= 'Pending';
             
            $order->save();

          }

           //$order_list = Order::where(array('user_id'=>$user_id,'status'=>'Pending'))->orderBy('item_name','desc')->get();
          $order_list = Cart::where('user_id',$user_id)->orderBy('id')->get();

            $data = array(
            'name' => $inputs['first_name'],
            'order_list' => $order_list
            
             );

            $subject=getcong('site_name').' Order Confirmed';
            
            $user_order_email=$inputs['email'];

            //User Email

            \Mail::send('emails.order_item', $data, function ($message) use ($subject,$user_order_email){

                $message->from(getcong('site_email'), getcong('site_name'));

                $message->to($user_order_email)->subject($subject);

            });
            
            //Admin/Owner Email

            $subject2='New Order Placed';
            


            $owner_admin_order_email=[getcong('site_email')];

            \Mail::send('emails.order_item_owner_admin', $data, function ($message) use ($subject2,$owner_admin_order_email){

                $message->from(getcong('site_email'), getcong('site_name'));

                $message->to($owner_admin_order_email)->subject($subject2);

            });


            /*$cart = Cart::findOrFail($cart_item->id);        
          
            $cart->delete();*/

       //echo 'hii'; die;
		/*$url = "http://websms.webaspiration.com/api/mt/SendSMS?user=onesol&password=onesolution&senderid=ONESOL&channel=Promo&DCS=0&flashsms=0&number=918961045792&text=Your Order Has Been Placed Successfully!&route=##";
		$curlConnection = curl_init();

		curl_setopt($curlConnection, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
		curl_setopt($curlConnection, CURLOPT_URL, $url);
		curl_setopt($curlConnection, CURLOPT_POST, TRUE);
		curl_setopt($curlConnection, CURLOPT_POSTFIELDS, $postData);
		curl_setopt($curlConnection, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($curlConnection, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curlConnection, CURLOPT_SSL_VERIFYPEER, FALSE);

		echo $results = curl_exec($curlConnection); die;*/
		//echo $arr = json_decode($results); die;
        return view('pages.confirm_order',compact('user','lat1','log1'));
    } 


     public function user_orderlist()
    { 
		if (!Auth::check())
		{ return redirect('/login'); }
        $user_id=Auth::user()->id;
        $order_list = Order::where('user_id',$user_id)->orderBy('id','desc')->orderBy('created_date','desc')->get();

        return view('pages.my_order',compact('order_list'));
    }

     public function cancel_order($order_id)
    { 
		if (!Auth::check())
		{ return redirect('/login'); }
        $order = Order::findOrFail($order_id);
        

        $order->status = 'Cancel'; 
        $order->save();
        
        
        \Session::flash('flash_message', 'Order has been cancel');

        return \Redirect::back();

        
    }

 

}
