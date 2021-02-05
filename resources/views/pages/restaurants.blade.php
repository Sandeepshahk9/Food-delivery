@extends("app")

@section('head_title', 'Restaurants' .' | '.getcong('site_name') )

@section('head_url', Request::url())

@section("content")
 <? //echo $category_search; die; ?>
 <div class="sub-banner" style="background:url({{ URL::asset('upload/'.getcong('page_bg_image')) }}) no-repeat center top;">
    <div class="overlay">
      <div class="container">
        <h1>{{$res_count}} Restaurants Avaiable</h1>
      </div>
    </div>
  </div>

 <div class="restaurant_list_detail">
    <div class="container">
	{!! Form::open(array('url' => 'restaurants','class'=>'', 'name'=>'res_search','id'=>'res_search','role'=>'form', 'enctype' => 'multipart/form-data')) !!}
	<div class="row">
		
		<div class="col-md-3 col-sm-3 col-xs-3">
		   <div class="form-group">
			  <label for="comment">Short By:</label>
			 
			  <select required name="rate" class="form-control">
					<option value="">Select</option>
					<option value="flat">Flat</option>
					<option value="desc">Decending Rating</option>
					<option value="asc">Acceding Rating</option>					
				</select>
			</div>
			
		</div>
		
		<div class="col-md-3 col-sm-3 col-xs-3">
		   <div class="form-group">
			  <label for="comment">Category:</label>
			 
			  <select required name="category" class="form-control" >
					<option value="">Select</option>
					 <?
					 $category = \App\Types::get();
					 if($category) {
						 foreach($category as $ct){
					 ?>
					<option value="<?=$ct->id?>"><?=$ct->type?></option>
					<? }} ?>
				  
				</select>
			</div> 
			
		</div>
		<div class="col-md-3 col-sm-3 col-xs-3">
		   <div class="form-group">
			  <button type="submit" class="btn btn-success">Search</button>
			</div> 
			
		</div>
		 
	</div>
	{!! Form::close() !!} 
	<div class="row"> 	
		
        <div class="col-md-9 col-sm-7 col-xs-12"> 
		<?php if($res) { ?>
          @foreach($res as $i => $re)
          
          <div data-wow-delay="0.{{$i}}s" class="strip_list wow fadeIn animated" style="visibility: visible; animation-delay: 0s; animation-name: fadeIn;">
            <div class="row">         
            <div class="col-md-9 col-sm-12">
              <div class="desc">
              <div class="thumb_strip"> 
                <a href="{{URL::to('restaurants/menu/'.$re->restaurant_slug)}}">

                    <img src="{{ URL::asset('upload/restaurants/'.$re->restaurant_logo.'-s.jpg') }}" alt="{{ $re->restaurant_name }}">

                  </a>  
                </div>         
              <h3>{{ $re->restaurant_name }}</h3>
			  <? $res_type=$re->restaurant_type;
				 $res_arr = explode(',',$res_type);
				 $str = "";
				 foreach($res_arr as $k=>$rid){
					 $rtype = DB::table('restaurant_types')->where('id',$rid)->get();
					 if($k == 0){
						$str.=$rtype[0]->type;
					 }
					 else{
						$str.=", ".$rtype[0]->type;  
					  }
				 }
				 
			  ?>
		<div class="type"> {{$str}}  </div>
              <div class="location">{{$re->restaurant_address}}  </div>

              <div class="rating"> 
                @for($x = 0; $x < 5; $x++)
                    
                @if($x < $re->review_avg)
                  <i class="fa fa-star"></i>
                @else
                  <i class="fa fa-star fa fa-star-o"></i>
                @endif
               
                @endfor
                (<small><a href="{{URL::to('restaurants/'.$re->restaurant_slug)}}">Read {{\App\Review::getTotalReview($re->id)}} reviews</a></small>)
              </div>

               
              </div>
            </div>  
            <div class="col-md-3 col-sm-12">
              <div class="go_to">
              <div> <a class="btn_1" href="{{URL::to('restaurants/menu/'.$re->restaurant_slug)}}">View Menu</a> </div>
              </div>
            </div>
            </div>
          </div>
          @endforeach
		<? } else { echo '<h1>No Record Found!</h1>'; } ?>
          @include('_particles.pagination', ['paginator' => $res]) 
 
                        
           </div>
           
<div class="col-md-3 col-sm-5 col-xs-12 side-bar">   
        
      <div id="cart_box">
      <h3>Your order <i class="fa fa-shopping-cart pull-right"></i></h3>
      <table class="table table_summary">
      <tbody>
      </tbody>
      </table>  
      @foreach(\App\Cart::where('user_id',Auth::id())->orderBy('id')->get() as $n=>$cart_item)
            <table class="table table_summary">
              <tbody>
              <tr>
                <td><a href="{{URL::to('delete_item/'.$cart_item->id)}}" class="remove_item"><i class="fa fa-minus-circle"></i></a> <strong>{{$cart_item->quantity}}x</strong> {{$cart_item->item_name}} </td>
                <td><strong class="pull-right">{{getcong('currency_symbol')}}{{$cart_item->item_price+$cart_item->item_price2+$cart_item->item_price3+$cart_item->item_price4+$cart_item->item_price5+$cart_item->item_price6+$cart_item->item_price7+$cart_item->item_price8+$cart_item->item_price9}}</strong></td>
              </tr>
             </tbody>
            </table> 
      @endforeach    
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
      <hr>
      @if($total>0)
      <table class="table table_summary">
        <tbody>
        <tr>
          <td class="total"> TOTAL <span class="pull-right">{{getcong('currency_symbol')}} 
		  <? echo $total; ?></span></td>
        </tr>
        </tbody>
      </table>
      <hr>
          <!--a class="btn_full" href="{{URL::to('order_details')}}">Order now</a-->		  
		  <form method="get" action="{{URL::to('order_details')}}">	
			<?
			/*$lat ="";
			$long="";
			if (Auth::check()!="") {
			$userInfo = DB::table('users')->where('id', Auth::id())->get();				
			$add = str_replace(" ","+",$userInfo[0]->address); 
			$city = str_replace(" ","+",$userInfo[0]->city);
			$pin = str_replace(" ","+",$userInfo[0]->postal_code); 
			$address = "India+".$add.$city.$pin; 
			$url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false"; 
			$geocodeFromAddr = file_get_contents($url); 
			$response_a = json_decode($geocodeFromAddr);
			$lat = $response_a->results[0]->geometry->location->lat;
			$long = $response_a->results[0]->geometry->location->lng;
			}*/
			?>		  
		  <input type="hidden" name="lat1" id="lat1" />					  
		  <input type="hidden" name="log1" id="log1"/>		         
		  <button type="submit" class="btn_full" name="order_submit">Order now</button>		  </form>		 
          @else
            <a class="btn_full" href="#0">Empty Cart</a>  
          @endif
    </div>  
                 
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
