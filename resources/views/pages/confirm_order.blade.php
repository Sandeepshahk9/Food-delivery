@extends("app")

@section('head_title', 'Order Details' .' | '.getcong('site_name') )

@section('head_url', Request::url())

@section("content")

 <?php
 
// Merchant key here as provided by Payu
$MERCHANT_KEY = "pK0AApwA";
 
// Merchant Salt as provided by Payu
$SALT = "GCCd0llvay";
 
// End point - change to https://secure.payu.in for LIVE mode
$PAYU_BASE_URL = "https://test.payu.in";
 
$action = '';
 
$posted = array();

    //print_r($_POST);
  foreach($user as $key => $value) {    
    $posted[$key] = $value; 
 
  }

 
$formError = 0;
 

$hash = '';
// Hash Sequence
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";

    //$posted['productinfo'] = json_encode(json_decode('[{"name":"tutionfee","description":"","value":"500","isRequired":"false"},{"name":"developmentfee","description":"monthly tution fee","value":"1500","isRequired":"false"}]'));
 $hashVarsSeq = explode('|', $hashSequence);
    $hash_string = ''; 
 foreach($hashVarsSeq as $hash_var) {
      $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
      $hash_string .= '|';
    }
 
    $hash_string .= $SALT;
 
 
    $hash = strtolower(hash('sha512', $hash_string));
    $action = $PAYU_BASE_URL . '/_payment';
 

?> 
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
          <div class="box_style_2" id="order_process">
          <h2 class="inner">Select Your Payment Method</h2>
		    <div class="message">
                        <!--{!! Html::ul($errors->all(), array('class'=>'alert alert-danger errors')) !!}-->
                                    @if (count($errors) > 0)
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
            <label>Select Payment Method</label>
           <!--select class="form-control">
			<option value="">-- Choose option --</option>
			<option value="">Cash on Delivery</option>
			<option value="">Net Banking</option>
			<option value="">Credit / Debit / ATM card</option>
			<option value="">PhonePe (UPI, Wallet)</option>
		   </select-->
          </div>
         <div class="form-group">
			<ul class="nav nav-tabs nav-stacked payment-option-tabs">
							<div class="tab-content">
								<li>
								<a data-toggle="tab" id="click_cod" href="#home"> <input type="radio" name="" value=""> Cash on Delivery <img src="upload/cashondel.png" class="img-responsive" alt="cash" style="width:100px"/></a></button></li>
										<div id="home" class="tab-pane fade " style="padding:15px;">								 
											<!--p>Enter your OTP here</p-->
											{!! Form::open(array('url' => 'order_confirm_sms','class'=>'', 'name'=>'cod_form','id'=>'cod_form','role'=>'form', 'enctype' => 'multipart/form-data')) !!}
											<!--div class="row">
												<div class="col-sm-12">
												<span style="color:red; display:none;font-weight:bold" id="otp_msg"><i class="fa fa-times" aria-hidden="true"></i> OTP does not match ! Please Enter a  Valid OTP.</span>
												</div>
											</div--> 
											
											<!--input type="text" placeholder="Enter OTP" name="otp" id="otp" style="height: 42px;padding: 10px 10px; border-radius: 5px;border: 1px solid;"/-->	
											<input type="hidden" name="latitute" value="<?=$lat1?>"/>	
											<input type="hidden" name="lognitute" value="<?=$log1?>"/>	
											<input type="hidden" name="tot_price" id="tot_price" style="height: 42px;padding: 10px 10px; border-radius: 5px;border: 1px solid;"/>		
											<input type="hidden" name="distance_km" id="distance_km_org" style="height: 42px;padding: 10px 10px; border-radius: 5px;border: 1px solid;"/>		
											<input type="hidden" name="del_charge" id="del_charge_org" style="height: 42px;padding: 10px 10px; border-radius: 5px;border: 1px solid;"/>		
											<button type="button" id="sub1" class="btn btn-info" style="margin-top: 0px;" >Continue</button>										
											<!--button type="submit" id="sub2" style="display:none" class="btn btn-info" >Continue</button-->											
											 {!! Form::close() !!} 
										</div>
									
								  </div>
								 
							  </ul>
         </div>
          
		  
		 

       
     
      
        </div>
        <!-- End box_style_1 --> 
        </div>
    <div class="col-md-3 col-sm-5 col-xs-12 side-bar">   
    <div id="cart_box">
          <h3>Your order <i class="icon_cart_alt pull-right"></i></h3>
          <?
			/*$userInfo = DB::table('users')->where('id', Auth::id())->get();				
			$add = str_replace(" ","+",$userInfo[0]->address); 
			$city = str_replace(" ","+",$userInfo[0]->city);
			$pin = str_replace(" ","+",$userInfo[0]->postal_code); 
			$address = "India+".$add.$city.$pin; 			
			$url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false";
			$geocodeFromAddr = file_get_contents($url); 
			$response_a = json_decode($geocodeFromAddr);
			$lat1 = $response_a->results[0]->geometry->location->lat;
			$log1 = $response_a->results[0]->geometry->location->lng;*/
			?>
          <table class="table table_summary">
            <tbody>
			  <? $gst=0; ?>			
              @foreach(\App\Cart::where('user_id',Auth::id())->orderBy('id')->get() as $n=>$cart_item)			  
			  <?
			  $res_id = $cart_item->restaurant_id;
			  $get = DB::table('restaurants')->where('id', '=', $cart_item->restaurant_id)->where('gst_status', '=', 'yes')->first();	
			  if($get){
				$gst = $gst+(($cart_item->item_price*$get->gst)/100);
				
			  }
			  ?>
              <tr>
                <td><a href="{{URL::to('delete_item/'.$cart_item->id)}}" class="remove_item"><i class="fa fa-minus-circle"></i></a> <strong>{{$cart_item->quantity}}x</strong> {{$cart_item->item_name}} </td>
                <td><strong class="pull-right">{{getcong('currency_symbol')}}{{$cart_item->item_price+$cart_item->item_price2+$cart_item->item_price3+$cart_item->item_price4+$cart_item->item_price5+$cart_item->item_price6+$cart_item->item_price7+$cart_item->item_price8+$cart_item->item_price9}}</strong></td>
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
				  $price = DB::table('cart')->where('user_id', Auth::id())->sum('item_price'); 
				  $price2 = DB::table('cart')->where('user_id', Auth::id())->sum('item_price2'); 
				  $price3 = DB::table('cart')->where('user_id', Auth::id())->sum('item_price3'); 
				  $price4 = DB::table('cart')->where('user_id', Auth::id())->sum('item_price4'); 
				  $price5 = DB::table('cart')->where('user_id', Auth::id())->sum('item_price5'); 
				  $price6 = DB::table('cart')->where('user_id', Auth::id())->sum('item_price6'); 
				  $price7 = DB::table('cart')->where('user_id', Auth::id())->sum('item_price7'); 
				  $price8 = DB::table('cart')->where('user_id', Auth::id())->sum('item_price8'); 
				  $price9 = DB::table('cart')->where('user_id', Auth::id())->sum('item_price9');
				  $total = $price+$price2+$price3+$price4+$price5+$price6+$price7+$price8+$price9;
				?>
			  <?	
				$price = DB::table('cart')
                ->where('user_id', Auth::id())
                ->sum('item_price');
				$price = $total;
				
				
				
				$res_dt = DB::table('restaurants')->where('id', '=', $res_id)->first();
				$lat1=$lat1;
				$lon1=$log1;
				$lat2=$res_dt->latitute;
				$lon2=$res_dt->lognitute;
				$first_km = $res_dt->first_km;
				$first_km = explode('@',$first_km);
				
				$second_km = $res_dt->second_km;
				$second_km = explode('@',$second_km);
				
				$third_km = $res_dt->third_km;
				$third_km = explode('@',$third_km);
				
				$fourth_km = $res_dt->fourth_km;
				$fourth_km = explode('@',$fourth_km);
				
				$fifth_km = $res_dt->fifth_km;
				$fifth_km = explode('@',$fifth_km);
				
			/*		$theta = $lon1 - $lon2;
				$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
				$dist = acos($dist);
				$dist = rad2deg($dist);
				$miles = $dist * 60 * 1.1515;  */
				
			
$url="https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=".$lat1.",".$lon1."&destinations=".$lat2.",".$lon2."&mode=driving&language=pl-PL";
$json_string = $url;
$jsondata = file_get_contents($json_string);
$obj = json_decode($jsondata, TRUE); // Set second argument as TRUE
//print_r($obj['rows']); // Now this will works!

$dist   = $obj['rows'][0]['elements'][0]['distance']['value'];
					
					
			$km=($dist/1000);	
					
				
				
				//$unit = strtoupper($unit);
				//if ($unit == "K") {
			//	$km = ($miles * 1.609344);
				//$km = $km,1);
				$delCharge="";
				if($km>0 && $km<=2.5){
						if($first_km[1]==0){
							$first_km[1]=100;
						}
						if($price >= $first_km[1] && $price <= $first_km[2]){
							$delCharge = $first_km[0];
						}
						else if($price > $first_km[2]){
							$delCharge =0;
						}else{
							$delCharge ='3';
							$minOrder=$first_km[1];
						}
					}
					elseif($km>2.5 && $km<=5){
						if($price >= $second_km[1] && $price <= $second_km[2]){
							$delCharge = $second_km[0];
						}
						else if($price > $second_km[2]){
							$delCharge =0;
						}
						else{
							$delCharge ='3';
							$minOrder=$second_km[1];
						}
					}
					elseif($km>5 && $km<=7.5){
						if($price >= $third_km[1] && $price <= $third_km[2]){
							$delCharge = $third_km[0];
						}
						else if($price > $third_km[2]){
							$delCharge =0;
						}
						else{
							$delCharge ='3';
							$minOrder=$third_km[1];
						}
					}
					elseif($km>7.5 && $km<=10){
						if($price >= $fourth_km[1] && $price <= $fourth_km[2]){
							$delCharge = $fourth_km[0];
						}
						else if($price > $fourth_km[2]){
							$delCharge =0;
						}
						else{
							$delCharge ='3';
							$minOrder=$fourth_km[1];
						}
					}
					elseif($km>10 && $km<=12.5){
						if($price >=$fifth_km[1] && $price <= $fifth_km[2]){
							$delCharge = $fifth_km[0];
						}
						else if($price > $fifth_km[2]){
							$delCharge =0;
						}else{
							$delCharge ='3';
							$minOrder=$fifth_km[1];
						}
					}
					elseif($km>12.5){
						$delCharge ='1.2';
					}
				
				if($delCharge=='1.2') {
			  ?>
			  
			   <tr>
                <td class="total" style="color:#f40202; font-size:15px;"> <i>Delivery Not Possible</i> </td>
              </tr>
				<? } elseif($delCharge=='3') { ?>
			<tr>
                <td class="total" style="color:#f40202; font-size:15px;"> <i>Minimum Order Amount {{getcong('currency_symbol')}}{{$minOrder}}</i> </td>
              </tr>
			  <?
				} elseif($delCharge!='1.2') {
			  ?>
			  <tr>
                <td class="total" style="color:#0c7bb8; font-size:15px;"> <i>Delivery Charge (<span id="distance_km">{{number_format($km,1)}}km</span>)</i> <span class="pull-right"><i>{{getcong('currency_symbol')}} <? if($delCharge ==0 ) { echo '<span id="del_charge">free</span>'; } else { echo "<span id='del_charge'>".$delCharge."</span>"; }?></i></span></td>
              </tr>
				<? } ?>
				
				<?
				$coupon_app = DB::table('cart')->where(array('user_id'=>Auth::id(), 'restaurant_id'=>$res_id))->first(); 
				if(isset($coupon_app) && $coupon_app->discount!=0) {
					$price = ($price+$gst+$delCharge)-(($price*$coupon_app->discount)/100);
				?>
				
				<tr>
                    <td class="total" > 
					<i style="color:#45b201; font-size:15px;">Coupon Applied <?=$coupon_app->discount?>% Off</i> </td>
                </tr>
				<tr>			 
					<td class="total"> TOTAL <span class="pull-right">{{getcong('currency_symbol')}}<span id="tot_amount">{{$price}}</span></span></td>				
                </tr>
				<? } else {?>
				  <tr>	
					<td class="total"> TOTAL <span class="pull-right">{{getcong('currency_symbol')}}<span id="tot_amount">{{$gst+$price+$delCharge}}</span></span></td>				
				  </tr>
				<? } ?>
            </tbody>
          </table>
          <hr>
           <input type="hidden" id="otp_pass" value="<?=Session::get('otp')?>"/>
          <!--button type="submit" class="btn_full">Confirm Your Order</button-->
        </div>

         
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
  
  <script>
  setTimeout(function(){ 
	var tot_amount = $('#tot_amount').text();
	$('#tot_price').val(tot_amount);
	$('#amount').val(tot_amount);
	$('#distance_km_org').val($('#distance_km').text());
	$('#del_charge_org').val($('#del_charge').text());
  }, 2000);
  
  
  $( "#sub1" ).click(function() {	
		$.ajax({
          type: "GET",
          url: 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey=AE6RsjVm7U6T6KMuuGDnag&senderid=ONESOL&channel=2&DCS=0&flashsms=0&number=91<?=$user->mobile?>&text=Your Order Has Been Placed Successfully&route=clickhere',           
            success: function( res ) {               
            }
        });
		swal("Good job!", "Order Placed Sucessfully!", "success");
		$('#cod_form').submit(); 
	
	});
  
  /*$( "#click_cod" ).click(function() {
	$.ajax({
           type: "GET",
            url: 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey=AE6RsjVm7U6T6KMuuGDnag&senderid=ONESOL&channel=2&DCS=0&flashsms=0&number=91<?=$user->mobile?>&text=your OTP is <?=Session::get('otp')?>&route=clickhere',
          
            success: function( res ) {
               
            }
        });
  });*/
  </script>

@endsection
