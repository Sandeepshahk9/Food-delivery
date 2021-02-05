<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Restaurants;
use App\Categories;
use App\Menu;
use App\Types;
use App\Review;
use Illuminate\Http\Request;
use Session;
use Mail;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
 
class IndexController extends Controller
{
	 

    public function index()
    { 
		if(!$this->alreadyInstalled()) {
            return redirect('install');
        }
    	 
         $types=Types::orderBy('type')->get();  

         $restaurants = DB::table('restaurants')
                           ->leftJoin('restaurant_types', 'restaurants.restaurant_type', '=', 'restaurant_types.id')                           
                           ->select('restaurants.*','restaurant_types.type')
                           ->where('restaurants.review_avg', '>=', '4')
                           /*->where('restaurants.show_home', '=', 'yes')*/
                           ->orderBy('restaurants.review_avg', 'desc')
                           ->take(6)
                           ->get();
		$res = DB::table('restaurants')
                           ->leftJoin('restaurant_types', 'restaurants.restaurant_type', '=', 'restaurant_types.id')                           
                           ->select('restaurants.*','restaurant_types.type')                          
                           ->where('restaurants.show_home', '=', 'yes')
                           ->orderBy('restaurants.review_avg', 'desc')
                          /* ->take(6)*/
                           ->get();
        
          

        return view('pages.index',compact('restaurants','types','res'));
    }
    
    public function about_us()
    { 
                  
        return view('pages.about');
    }

    public function contact_us()
    {        
        return view('pages.contact');
    }

    /**
     * If application is already installed.
     *
     * @return bool
     */
    public function alreadyInstalled()
    {
        return file_exists(storage_path('installed'));
    }

    /**
     * Do user login
     * @return $this|\Illuminate\Http\RedirectResponse
     */
     
     public function login()
    { 
        if (Auth::check())
		{ return redirect('/'); }     
	
        return view('pages.login');
    }
	
	public function forgot_password()
    { 
        if (Auth::check())
		{ return redirect('/'); }  
        return view('pages.forgot_password');
    }
	
	public function change_newpassword($token)
    { 
        if (Auth::check())
		{ return redirect('/'); }  
        return view('pages.change_newpassword',compact('token'));
    }
	 
	public function postforgot_password(Request $request)
    {
		$inputs = $request->all();
		$user = DB::table('users')->where('email', '=', $inputs['email'])->get();
		if($user){
			$num ="SOL10000".rand(0,99999);
			$data = array(
            'link' => 'change_pass/'.$num			
             );
			$to_email = $inputs['email'];
			
			$subject = 'Forgot Password-'.time();			
			User::where('email', $inputs['email'])->update(['forgot_token' => $num]);
			//$email_to = $inputs['email'];
			 \Mail::send('emails.forgot_password', $data, function ($message) use ($subject, $to_email){
                $message->from(getcong('site_email'), getcong('site_name'));
                $message->to($to_email)->subject($subject);
            });
			Session::flash('success_msg', 'Check your email!'); 
			return redirect('/forgot_password');
		}
		else{
			Session::flash('error_msg', 'User Does not exist!'); 
			return redirect('/forgot_password');
		}
	}
	
	public function edit_newpassword(Request $request)
    { 
        
        $data =  \Input::except(array('_token')) ;        
        $inputs = $request->all();
        
        $rule=array(                
                'password' => 'required|min:3|confirmed'
                 );
         $validator = \Validator::make($data,$rule);
 
        if ($validator->fails())
        {
                return redirect()->back()->withErrors($validator->messages());
        }
		
		$info = DB::table('users')->where('forgot_token',$inputs['token'])->get();
		if($info) {
		/*  $user_id=Auth::user()->id;           
        $user = User::findOrFail($user_id);       
        $user->password= bcrypt($inputs['password']);  
        $user->save();*/
		User::where('forgot_token', $inputs['token'])->update(['forgot_token' => '','password'=>bcrypt($inputs['password'])]);
         \Session::flash('flash_message', 'Password has been changed...');
         return redirect('/login');
		}
		else{
			 \Session::flash('error_message', 'Invalid Token');
			return \Redirect::back();
		}

         
    } 
	
    public function postLogin(Request $request)
    {
        
    
        
      $this->validate($request, [
            'email' => 'required|email', 'password' => 'required',
        ]);


        $credentials = $request->only('email', 'password');

         
        
         if (Auth::attempt($credentials, $request->has('remember'))) {

            if(Auth::user()->usertype=='banned'){
                \Auth::logout();
                return array("errors" => 'You account has been banned!');
            }
			
            return $this->handleUserWasAuthenticated($request);
        }

       // return array("errors" => 'The email or the password is invalid. Please try again.');
        //return redirect('/admin');
       return redirect('/login')->withErrors('The email or the password is invalid. Please try again.');
        
    }
    
     /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  bool  $throttles
     * @return \Illuminate\Http\Response
     */
    protected function handleUserWasAuthenticated(Request $request)
    {

        if (method_exists($this, 'authenticated')) {
            return $this->authenticated($request, Auth::user());
        }
		if(Session::get('set_url')!=""){
			$url = Session::get('set_url'); 
			Session::set('set_url',"");	
			return redirect($url); 
		}else {
			return redirect('/'); 
		}
    }
    
    
    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::logout();

        \Session::flash('flash_message', 'Logout successfully...');

        return redirect('/login');
    }


    public function register()
    { 
		if (Auth::check())
		{
			return redirect('/');
		}
		Session::set('otp',rand(0,99999));
                   
        return view('pages.register');
    }

    public function register_user(Request $request)
    { 
        
        $data =  \Input::except(array('_token')) ;
        
        $inputs = $request->all();
        
        $rule=array(
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|max:75|unique:users',
                'password' => 'required|min:3|confirmed'
                 );
        
        
        
         $validator = \Validator::make($data,$rule);
 
        if ($validator->fails())
        {
                return redirect()->back()->withErrors($validator->messages());
        } 
          
       
        $user = new User;

        
     //   $user->usertype = $inputs['usertype'];
		if($inputs['password']==$inputs['password_confirmation']){
			if(md5($inputs['otp'])==md5(Session::get('otp'))){
				$user->first_name = $inputs['first_name']; 
				$user->last_name = $inputs['last_name'];       
				$user->email = $inputs['email'];         
				$user->password= bcrypt($inputs['password']); 
				$user->address= $inputs['address']; 
				$user->city= $inputs['city']; 
				$user->postal_code= $inputs['postal_code']; 
				$user->save();
				 \Session::flash('flash_message', 'Register successfully...');
			}else{
				\Session::flash('error_message', 'Check Your OTP');
			}
		}else{
			\Session::flash('error_message', 'Check Your Confirm Password');
		}

        return \Redirect::back();

         
    }    

	public function check_otp()
    {
        //if ($request->isMethod('post')){    
            return response()->json(['response' => 'This is get method']);
       // }

        //return response()->json(['response' => 'This is get method']);
    }
	
    public function profile()
    { 
        $user_id=Auth::user()->id;
        $user = User::findOrFail($user_id);

        return view('pages.profile',compact('user'));
    } 
    

    public function editprofile(Request $request)
    { 
        
        $data =  \Input::except(array('_token')) ;
        
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
        
         
            \Session::flash('flash_message', 'Changes Saved');

            return \Redirect::back();
         
         
    }        

    public function change_password()
    { 
        
        return view('pages.change_password');
    }

        
     public function edit_password(Request $request)
    { 
        
        $data =  \Input::except(array('_token')) ;
        
        $inputs = $request->all();
        
        $rule=array(                
                'password' => 'required|min:3|confirmed'
                 );
        
        
        
         $validator = \Validator::make($data,$rule);
 
        if ($validator->fails())
        {
                return redirect()->back()->withErrors($validator->messages());
        } 
          
       
        $user_id=Auth::user()->id;
           
        $user = User::findOrFail($user_id);
       
        $user->password= bcrypt($inputs['password']);  
        
         
        $user->save(); 

            \Session::flash('flash_message', 'Password has been changed...');

            return \Redirect::back();

         
    } 


    public function contact_send(Request $request)
    { 
        
        $data =  \Input::except(array('_token')) ;
        
        $inputs = $request->all();
        
        $rule=array(                
                'name' => 'required',
                'email' => 'required|email|max:75'
                 );
         $validator = \Validator::make($data,$rule);
 
        if ($validator->fails())
        {
                return redirect()->back()->withErrors($validator->messages());
        } 
          
            $data = array(
            'name' => $inputs['name'],
            'email' => $inputs['email'],
            'phone' => $inputs['phone'],
            'subject' => $inputs['subject'],
            'user_message' => $inputs['message'],
             );

            $subject=$inputs['subject'];

            \Mail::send('emails.contact', $data, function ($message) use ($subject){

                $message->from(getcong('site_email'), getcong('site_name'));

                 $message->to('1solofficial@gmail.com')->subject($subject);
              //  $message->to('manikmistry5@gmail.com')->subject($subject);

            });
        

            \Session::flash('flash_message', 'Thank You. Your Message has been Submitted.');

            return \Redirect::back();

         
    }    
}
