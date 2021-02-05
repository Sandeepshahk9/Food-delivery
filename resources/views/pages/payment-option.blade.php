@extends("app")

@section('head_title', 'Order Details' .' | '.getcong('site_name') )

@section('head_url', Request::url())

@section("content")
 
<div class="sub-banner" style="background:url({{ URL::asset('upload/'.getcong('page_bg_image')) }}) no-repeat center top;">
    <div class="overlay">
      <div class="container">
        <h1>Your Order Details</h1>
      </div>
    </div>
  </div>

 <div class="restaurant_list_detail">
    <div class="container">
      <div class="row">
        <div class="col-md-9 col-sm-7 col-xs-12">
          <!--<div class="box_style_2" id="order_process">
          <h2 class="inner">Your Order Details</h2>
		 
          {!! Form::open(array('url' => 'order_details','class'=>'','id'=>'order_details','role'=>'form')) !!} 

            <div class="message">-->
                        <!--{!! Html::ul($errors->all(), array('class'=>'alert alert-danger errors')) !!}-->
                                 <!--   @if (count($errors) > 0)
                          <div class="alert alert-danger">
                          
                              <ul>
                                  @foreach ($errors->all() as $error)
                                      <li>{{ $error }}</li>
                                  @endforeach
                              </ul>
                          </div>
                      @endif
                                    
        </div>
        @if(Session::has('flash_message'))
            <div class="alert alert-success">             
                {{ Session::get('flash_message') }}
            </div>
        @endif

          <div class="form-group">
            <label>First name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="{{$user->first_name}}" placeholder="First name">
          </div>
          <div class="form-group">
            <label>Last name</label>
            <input type="text" class="form-control" id="last_name" value="{{$user->last_name}}" name="last_name" placeholder="Last name">
          </div>
          <div class="form-group">
            <label>Telephone/mobile</label>
            <input type="text" id="mobile" name="mobile" value="{{$user->mobile}}" class="form-control" placeholder="Telephone/mobile">
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" id="email" name="email" value="{{$user->email}}" class="form-control" placeholder="Your email">
          </div>           
          <div class="row">
            <div class="col-md-6 col-sm-6">
              <div class="form-group">
                <label>City</label>
                <input type="text" id="city" name="city" value="{{$user->city}}" class="form-control" placeholder="Your city">
              </div>
            </div>
            <div class="col-md-6 col-sm-6">
              <div class="form-group">
                <label>Postal code</label>
                <input type="text" id="postal_code" name="postal_code" value="{{$user->postal_code}}" class="form-control" placeholder=" Your postal code">
              </div>
            </div>
          </div>
           
          <hr>
          <div class="row">
            <div class="col-md-12">
              <label>Your full address</label>
              <textarea class="form-control" style="height:150px" placeholder="Address" name="address" id="address">{{$user->address}}</textarea>
            </div>
          </div>
             
      
        </div>-->
        <!-- End box_style_1 --> 
        </div>
    <div class="col-md-3 col-sm-5 col-xs-12 side-bar">   
    <div id="cart_box">
          <h3>Your order <i class="icon_cart_alt pull-right"></i></h3>
          
          <table class="table table_summary">
            <tbody>
			  <? $gst=0; ?>			
              @foreach(\App\Cart::where('user_id',Auth::id())->orderBy('id')->get() as $n=>$cart_item)			  
			  <?
			  $get = DB::table('restaurants')->where('id', '=', $cart_item->restaurant_id)->where('gst_status', '=', 'yes')->first();	
			  if($get){
				$gst = $gst+(($cart_item->item_price*$get->gst)/100);
				$lat1=$_GET['lat1'];
				$lon1=$_GET['log1'];
				$lat2=$get->latitute;
				$lon2=$get->lognitute;
				$first_km = $get->first_km;
				$first_km = explode('@',$first_km);
				
				$second_km = $get->second_km;
				$second_km = explode('@',$second_km);
				
				$third_km = $get->third_km;
				$third_km = explode('@',$third_km);
				
				$fourth_km = $get->fourth_km;
				$fourth_km = explode('@',$fourth_km);
				
				$fifth_km = $get->fifth_km;
				$fifth_km = explode('@',$fifth_km);
			  }
			  ?>
              <tr>
                <td><a href="{{URL::to('delete_item/'.$cart_item->id)}}" class="remove_item"><i class="fa fa-minus-circle"></i></a> <strong>{{$cart_item->quantity}}x</strong> {{$cart_item->item_name}} </td>
                <td><strong class="pull-right">{{getcong('currency_symbol')}}{{$cart_item->item_price}}</strong></td>
              </tr>
              @endforeach
               
            </tbody>
          </table>
           
          <!-- Edn options 2 -->
         
          <hr>
          @if(DB::table('cart')->where('user_id', Auth::id())->sum('item_price')>0)
          <table class="table table_summary">
            <tbody>
			@if(isset($gst) && $gst>0)
              <tr>
                <td class="total" style="color:#0c7bb8"> <i>GST</i> <span class="pull-right"><i>{{getcong('currency_symbol')}}{{isset($gst) && $gst>0 ? $gst:''}}</i></span></td>
              </tr>
			  @endif
			  <?	
				$price = DB::table('cart')
                ->where('user_id', Auth::id())
                ->sum('item_price');
				
				$theta = $lon1 - $lon2;
				$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
				$dist = acos($dist);
				$dist = rad2deg($dist);
				$miles = $dist * 60 * 1.1515;
				//$unit = strtoupper($unit);
				//if ($unit == "K") {
				$km = ($miles * 1.609344);
				//$km = $km,1);
				
				if($km>0 && $km<=2.5){
					if($first_km[1]==0){
						$first_km[1]=100;
					}
					if($price <= $first_km[1]){
						$delCharge = $first_km[0];
					}
					else if($price > $first_km[2]){
						$delCharge =0;
					}
				}
				elseif($km>2.5 && $km<=5){
					if($price <= $second_km[1]){
						$delCharge = $second_km[0];
					}
					else if($price > $second_km[2]){
						$delCharge =0;
					}
				}
				elseif($km>5 && $km<=7.5){
					if($price <= $third_km[1]){
						$delCharge = $third_km[0];
					}
					else if($price > $third_km[2]){
						$delCharge =0;
					}
				}
				elseif($km>7.5 && $km<=10){
					if($price <= $fourth_km[1]){
						$delCharge = $fourth_km[0];
					}
					else if($price > $fourth_km[2]){
						$delCharge =0;
					}
				}
				elseif($km>10 && $km<=12.5){
					if($price <=$fifth_km[1]){
						$delCharge = $fifth_km[0];
					}
					else if($price > $fifth_km[2]){
						$delCharge =0;
					}
				}
				elseif($km>12.5){
					$delCharge ='no';
				}
				
				if($delCharge=='no') {
			  ?>
			  
			   <tr>
                <td class="total" style="color:#f40202; font-size:15px;"> <i>Delivery Not Possible</i> </td>
              </tr>
			  <?
				} elseif($delCharge!='no') {
			  ?>
			  <tr>
                <td class="total" style="color:#0c7bb8; font-size:15px;"> <i>Delivery Charge ({{number_format($km,1)}}km)</i> <span class="pull-right"><i>{{getcong('currency_symbol')}} <? if($delCharge ==0 ) { echo 'free'; } else { echo $delCharge; }?></i></span></td>
              </tr>
				<? } ?>
              <tr>	 
			 
                <td class="total"> TOTAL <span class="pull-right">{{getcong('currency_symbol')}}{{$gst+$price+$delCharge}}</span></td>
              </tr>
            </tbody>
          </table>
          <hr>
           
          <button type="submit" class="btn_full">Confirm Your Order</button>
        </div>

          {!! Form::close() !!} 
          @else
            <a class="btn_full" href="#">Empty Cart</a> </div>
          @endif
        <!-- End cart_box -->                                                                               
    <div id="help" class="box_style_2"> 
      <i class="fa fa-life-bouy"></i>
        <h4>{{getcong_widgets('need_help_title')}}</h4>
        <a href="tel://{{getcong_widgets('need_help_phone')}}" class="phone">{{getcong_widgets('need_help_phone')}}</a> <small>{{getcong_widgets('need_help_time')}}</small> 
      </div>
        </div>
                
      </div>
    </div>
  </div>
  

@endsection
