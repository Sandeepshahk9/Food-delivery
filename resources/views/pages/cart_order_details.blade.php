@extends("app")

@section('head_title', 'Order Details' .' | '.getcong('site_name') )

@section('head_url', Request::url())

@section("content")
 <script src="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.js"></script>
    <link rel="stylesheet" href="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.css">
<script src="https://1sol.in/site_assets/select/jquery-customselect.js"></script>
    <link href="https://1sol.in/site_assets/select/jquery-customselect.css" rel='stylesheet' />	
<?php
if($_GET['lat1']=="" || $_GET['log1']=="") {
?>	
<script>
 $(document).ready(function(){
        $("#myModal").modal('show');		
    });
</script>
<? } ?>

  <!-- Modal -->
  <div class="modal fade  mod-order-detls-hist" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title text-center">Location</h4>
        </div>
        <div class="modal-body">
          <p>Please select your location</p>
		  {!! Form::open(array('url' => array('location_submit'),'class'=>'','name'=>'location_details','id'=>'location_details','role'=>'form','enctype' => 'multipart/form-data')) !!}
			<select class="select2 select select3 custom-select" id="location" name="location" required>
			<option value="">--  Select one --</option>
			<?
			if($locations) {
				foreach($locations as $locs) {
			?>
			<option value="<?=$locs->id?>"><?=$locs->name?></option>
			<? }} ?>
			</select></br>
		  <button type="submit" name="submit" class="btn btn-default sub-mi-btn">Submit</button>
		  {!! Form::close() !!} 
        </div>
        
      </div>
      
    </div>
  </div>
  
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
          <h2 class="inner">Your Order Details</h2>
		 
          {!! Form::open(array('url' => array('order_details'),'class'=>'','name'=>'order_details','id'=>'order_details','role'=>'form','enctype' => 'multipart/form-data')) !!} 

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
             <input type="hidden" name="lat1" value="<?=$_GET['lat1']?>"/> 
             <input type="hidden" name="log1" value="<?=$_GET['log1']?>"/>
             <input type="hidden" id="user_id" name="user_id" value="<?=$user->id?>"/>
      
        </div>
        <!-- End box_style_1 --> 
        </div>
    <div class="col-md-3 col-sm-5 col-xs-12 side-bar">   
    <div id="cart_box">
          <h3>Your order <i class="icon_cart_alt pull-right"></i></h3>
          
          <table class="table table_summary">
            <tbody>
			  <? $gst=0; $res_id=""; ?>			
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
          @if($total>0)
          <table class="table table_summary">
            <tbody>
			@if(isset($gst) && $gst>0)
              <tr>
                <td class="total" style="color:#0c7bb8"> <i>GST</i> <span class="pull-right"><i>{{getcong('currency_symbol')}}{{isset($gst) && $gst>0 ? $gst:''}}</i></span></td>
              </tr>
			  @endif
			  <?
				$delCharge="";
				if($_GET['lat1']==NULL) {
					$delCharge ='1.1';
				}
				elseif($_GET['log1']==NULL) {
					$delCharge ='1.1';
				} else {
					$res_dt = DB::table('restaurants')->where('id', '=', $res_id)->first();
					$lat1=$_GET['lat1'];
					$lon1=$_GET['log1'];
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
					/*$price = DB::table('cart')
					->where('user_id', Auth::id())
					->sum('item_price');*/
					$price = $total;
					

$url="https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=".$lat1.",".$lon1."&destinations=".$lat2.",".$lon2."&mode=driving&language=pl-PL";
$json_string = $url;
$jsondata = file_get_contents($json_string);
$obj = json_decode($jsondata, TRUE); // Set second argument as TRUE
//print_r($obj['rows']); // Now this will works!

$dist   = $obj['rows'][0]['elements'][0]['distance']['value'];
					
					
				$km=($dist/1000);	
					
					
				
					
				/*	$theta = $lon1 - $lon2;
					$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
					$dist = acos($dist);
					$dist = rad2deg($dist);
					$miles = $dist * 60 * 1.1515;
					//$unit = strtoupper($unit);
					//if ($unit == "K") {
					$km = ($miles * 1.609344);
					//$km = number_format($km,1);    */
					
					
					
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
				}
				
				if($delCharge == "1.1"){
					//echo $delCharge;
				?>
							  
			   <tr>
                <td class="total" style="color:#f40202; font-size:15px;"> <i>Please Allow Your Location, Otherwise you can not place your order</i> </td>
              </tr>
			  <?php
				}	
				elseif($delCharge==3) {
				?>
				<tr>
                <td class="total" style="color:#f40202; font-size:15px;"> <i>Minimum Order Amount {{getcong('currency_symbol')}}{{$minOrder}}  </i> </td>
              </tr>
			<?php
				} elseif($delCharge=="1.2") {
			  ?>			  
			   <tr>
                <td class="total" style="color:#f40202; font-size:15px;"> <i>Delivery Not Possible</i> </td>
              </tr>
			  <?
				} else {
					//echo $delCharge;
			  ?>
			  <tr>
                <td class="total" style="color:#0c7bb8; font-size:15px;"> <i>Delivery Charge ({{number_format($km,1)}}km)</i> <span class="pull-right"><i>{{getcong('currency_symbol')}} <? if($delCharge ==0 ) { echo 'free'; } else { echo $delCharge; }?></i></span></td>
              </tr>
				
				<?
				$coupon_app = DB::table('cart')->where(array('user_id'=>Auth::id(), 'restaurant_id'=>$res_id))->first(); 
				if(isset($coupon_app) && $coupon_app->discount!=0) {
					$total = ($total+$gst+$delCharge)-(($total*$coupon_app->discount)/100);
				?>
				<tr>
                    <td class="total" > 
					<i style="color:#45b201; font-size:15px;">Coupon Applied <?=$coupon_app->discount?>% Off</i> </td>
                </tr>				
				<tr>
				<td class="total"> TOTAL <span class="pull-right">{{getcong('currency_symbol')}}{{$total}}</span></td>
				</tr>
				<? } else { ?>
				<tr>
                    <td class="total" > 
					<i style="color:#45b201; font-size:15px;">Apply Coupon</i></br>
					<i id="cp_error" style="color:#e00218; display:none; font-size:15px;">Wrong Coupon Code! </i>
					</td>
                </tr>
				<tr>
                    <td class="total" style="color:#45b201;"><input type="text" id="cp_code" class="form-control" placeholder="Coupon Code"/>  <button type="button" class="btn_full apply_coupon">Apply</button></td>
                </tr>				
              <tr>	 
			 
                <td class="total"> TOTAL <span class="pull-right">{{getcong('currency_symbol')}}{{$gst+$total+$delCharge}}</span></td>
              </tr>
				<? } }?>
            </tbody>
          </table>
          <hr>
           <?php
		  if($delCharge =='1.1') { echo ""; }
		  elseif($delCharge =='1.2') { echo ""; }
		  elseif($delCharge =='3') { echo ""; }
			else{
		   ?>
          <button type="submit" class="btn_full">Confirm Your Order</button>
			<?  } ?>
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
  
 <script>
 $(".apply_coupon").click(function(){
         
		 var coupon_code = $('#cp_code').val();
		 var user_id = $('#user_id').val();
		// alert(user_id);
      
        $.ajax({
            type: "GET",
            url: 'https://1sol.in/apply_coupon/'+coupon_code+'/'+user_id,
            //data: {title: ""},
            success: function( res ) {
                //$("#ajaxResponse").append("<div>"+msg+"</div>");
				if(res.msg=="no"){
					$("#cp_error").show();
				}
				else if(res.msg=="yes"){
					swal("Good job!", "Coupon Applied Sucessfully!", "success");
					window.location.href=window.location;
				}
            }
        });
		
});
 </script>

@endsection
