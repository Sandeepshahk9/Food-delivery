<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="https://1sol.in/public/site_assets/css/showsuggestion.css" rel="stylesheet" type="text/css">
<script src="https://1sol.in/public/site_assets/js/showsuggestion.js"></script>
<script src="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.js"></script>
    <link rel="stylesheet" href="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.css">
<link rel="icon" sizes="192x192" href="{{ URL::asset('upload/'.getcong('site_logo')) }}">
  <div class="top-bar">
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
	      <div class="logo"> <a href="{{ URL::to('/') }}"><img src="{{ URL::asset('upload/'.getcong('site_logo')) }}" alt="" ></a> </div>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
		<div id="subheader" class="earch-form-none">
			<div id="sub_content" class="animated zoomIn">
			  <div class="container-4 main_g">
				{!! Form::open(array('url' => 'restaurants','class'=>'','id'=>'search','role'=>'form')) !!} 
				  <input type="text" class="assinee" placeholder="Restaurant name or address..." name="search_keyword" id="search"/>
				  <button class="icon" type="submit"><i class="fa fa-search"></i></button>
				{!! Form::close() !!} 
			</div>
			</div>
		</div>
		<div class="contact-no-xs">
			<h2>1Sol<br>+0130-2248001</h2>
		</div>
    </div>
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
		<!--a href="order_details"><i class="fa fa-shopping-cart cart_a"></i></a-->
		
		<? 
		/*$latitute="";
		$lognitute="";*/
		if(Auth::id()) {
			
			?>
		<form method="get" action="{{URL::to('order_details')}}">
		<?
			/*$userInfo = DB::table('users')->where('id',Auth::id())->get();				
			$add = str_replace(" ","+",$userInfo[0]->address); 
			$city = str_replace(" ","+",$userInfo[0]->city);
			$pin = str_replace(" ","+",$userInfo[0]->postal_code); 
			$address = "India+".$add."".$city."".$pin;			
			$url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false";
			$geocodeFromAddr = file_get_contents($url); 
			$response_a = json_decode($geocodeFromAddr);
			$latitute = $response_a->results[0]->geometry->location->lat;
			$lognitute = $response_a->results[0]->geometry->location->lng;*/
			?>
		<input type="hidden" name="lat1" id="lat2" />
		<input type="hidden" name="log1" id="lon2" />
		<button type="submit" name="submit_cart" class="cart-btn-shp"style="background: none;border: none;display: block;  margin: auto;">		
		<i class="fa fa-shopping-cart cart_a"></i>
		<? $cartNum=0; ?>
		<span class="number-order-list">
		 @foreach(\App\Cart::where('user_id',Auth::id())->orderBy('id')->get() as $n=>$cart_item)
		 <? 
		 if(isset($cart_item)) {
		 $cartNum=$cart_item->quantity+$cartNum;
		 }
		 ?>
		  @endforeach
		  
		  {{ $cartNum }}
		
		</span>
		
		 
		</form><? } ?>
	</div>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mobile-sec-option-form">
		<div id="subheader" >
			<div id="sub_content" class="animated zoomIn">
			  <div class="container-4 main_g">
				{!! Form::open(array('url' => 'restaurants','class'=>'','id'=>'search','role'=>'form')) !!} 
				  <input type="text" class="assinee" placeholder="Restaurant name or address..." name="search_keyword" id="search"/>
				  <button class="icon" type="submit"><i class="fa fa-search"></i></button>
				{!! Form::close() !!} 
			</div>
			</div>
		</div>
		
    </div>
  </div>
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  <header class="sticky1">
    <div class="container">
      <nav class="animenu">
      <button class="animenu_toggle"> 
         <span class="animenu_toggle_bar"></span> 
         <span class="animenu_toggle_bar"></span> 
         <span class="animenu_toggle_bar"></span> 
      </button>
      <ul class="animenu_nav">
            <li> <a href="{{ URL::to('/') }}">Home</a></li>
            <li><a href="{{URL::to('restaurants')}}">Restaurants</a></li>

            @if(Auth::check() and Auth::user()->usertype=='User')

             <li> <a href="javascript:void(0);">My Account<i class="icon-down-open-mini"></i></a>
              <ul class="animenu_nav_child">
                <li><a href="{{ URL::to('profile') }}">Edit Profile</a></li>
                <li><a href="{{ URL::to('change_pass') }}">Change Password</a></li>
                <li><a href="{{URL::to('myorder')}}">My Order</a></li>
                <li><a href="{{ URL::to('logout') }}">Logout</a></li>                
              </ul>
            </li>
            @elseif(Auth::check() and Auth::user()->usertype=='Owner')
              <li> <a href="javascript:void(0);">My Account<i class="icon-down-open-mini"></i></a>
              <ul class="animenu_nav_child">
                <li><a href="{{ URL::to('admin/dashboard') }}">Dashboard</a></li>
                <li><a href="{{ URL::to('logout') }}">Logout</a></li>                
              </ul>
            </li>
            @elseif(Auth::check() and Auth::user()->usertype=='Admin')
              <li> <a href="javascript:void(0);">My Account<i class="icon-down-open-mini"></i></a>
              <ul class="animenu_nav_child">
                <li><a href="{{ URL::to('admin/dashboard') }}">Dashboard</a></li>
                <li><a href="{{ URL::to('logout') }}">Logout</a></li>                
              </ul>
            </li>

              
            @else
 
            <li><a href="{{ URL::to('login') }}">Login</a></li>
            <li><a href="{{ URL::to('register') }}">Register</a></li>

            @endif

            <li><a href="{{ URL::to('about') }}">About us</a></li>
            <li><a href="{{ URL::to('contact') }}">Contact</a></li>              
          </ul>
       
       
    </nav>
    </div>
  </header>
   