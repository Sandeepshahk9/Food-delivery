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
	<? if(isset($restaurant)) { ?>
		<div class="box_style_2 sidebar_time_list">
          <h4 class="nomargin_top">Opening time <i class="fa fa-clock-o pull-right"></i></h4>
          <ul class="opening_list">		  
            <li>Monday<span>{{$restaurant->open_monday}}</span></li>
            <li>Tuesday<span>{{$restaurant->open_tuesday}}</span></li>
            <li>Wednesday <span>{{$restaurant->open_wednesday}}</span></li>
            <li>Thursday<span>{{$restaurant->open_thursday}}</span></li>
            <li>Friday<span>{{$restaurant->open_friday}}</span></li>
            <li>Saturday<span>{{$restaurant->open_saturday}}</span></li>
            <li>Sunday <span>{{$restaurant->open_sunday}}</span></li>
          </ul>
        </div> 
	 <? } ?>
                 
      <div id="help" class="box_style_2"> 
      <i class="fa fa-life-bouy"></i>
        <h4>{{getcong_widgets('need_help_title')}}</h4>
        <a href="tel://{{getcong_widgets('need_help_phone')}}" class="phone">{{getcong_widgets('need_help_phone')}}</a> <small>{{getcong_widgets('need_help_time')}}</small> 
      </div>
</div>