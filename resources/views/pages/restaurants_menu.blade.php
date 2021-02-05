@extends("app")

@section('head_title', $restaurant->restaurant_name.' Menu' .' | '.getcong('site_name') )

@section('head_url', Request::url())

@section("content")
<?  $y=0; ?>
  <div class="sub-banner" style="background:url({{ URL::asset('upload/'.getcong('page_bg_image')) }}) no-repeat center top;">
    <div class="overlay">
      <div class="container">
        <div id="sub_content" class="animated zoomIn">
    <div class="col-md-2 col-sm-3">
      <div id="thumb"><img src="{{ URL::asset('upload/restaurants/'.$restaurant->restaurant_logo.'-b.jpg') }}" alt="{{ $restaurant->restaurant_name }}"></div>
    </div>  
    <div class="col-md-10 col-sm-9">  
      <h1>{{ $restaurant->restaurant_name }}</h1>
      <div class="sub_cont_rt">{{ $restaurant->type }}</div>
      <div class="sub_cont_lt"><i class="fa fa-map-marker"></i>{{$restaurant->restaurant_address}}</div>
      <div class="rating"> 
         @for($x = 0; $x < 5; $x++)
                    
                @if($x < $restaurant->review_avg)
                  <i class="fa fa-star"></i>
                @else
                  <i class="fa fa-star fa fa-star-o"></i>
                @endif
               
                @endfor 
                (<small><a href="{{URL::to('restaurants/'.$restaurant->restaurant_slug)}}"> Read {{\App\Review::getTotalReview($restaurant->id)}} Reviews </a></small>)
      </div>
      <div class="rstl_list_btn"><a href="{{URL::to('restaurants/'.$restaurant->restaurant_slug)}}">View Restaurant</a></div>
      </div>
    </div>
      </div>
    </div>
  </div>
  
  <div class="restaurant_list_detail">
    <div class="container">
      <div class="row">
		<div class="col-md-9 col-sm-7 col-xs-12">
			<div id="subheader" style="margin-bottom:20px;">
				<div id="sub_content" class="animated zoomIn">
				  <div class="container-4 main_g">
					{!! Form::open(array('url' => 'restaurants/menu/'.$slug,'class'=>'','id'=>'search','role'=>'form')) !!} 
					  <input type="text" value="<? //if(isset($_POST['search_keyword'])) { echo $_POST['search_keyword']; }?>" class="assinee" placeholder="Menu Name..." name="search_keyword" id="search"/>
					  <button class="icon" type="submit" style="right:6%"><i class="fa fa-search"></i></button>
					{!! Form::close() !!} 
				</div>
				</div>
			</div>		
		</div>
		</div>
		<div class="row">
	
		<div class="col-md-3 col-sm-3 col-xs-12">
			<div id="cart_box" class="categories">
            <h3>Type</h3>
             
            <ul>
             <li>
                <label><a href="{{URL::to('restaurants/')}}">All</a></label>
              </li>
              @foreach(\App\Types::orderBy('type')->get() as $type)
              <li>
                <label><a href="{{URL::to('restaurants/type/'.$type->id)}}">{{$type->type}}</a></label>
              </li>
              @endforeach
              
            </ul>
          </div>  
		</div>
		
		
        <div class="col-md-6 col-sm-6 col-xs-12">   
		
      <div id="main_menu" class="box_style_2">
	   <form id="myForm">
        <h2 class="inner">Menu List</h2>
		<? $y=1; ?>
         @foreach(\App\Categories::where('restaurant_id',$restaurant->id)->orderBy('category_name')->get() as $n=>$cat)
		<? if(isset($cat)) { ?>
        <h3 id="{{$cat->category_name}}" class="nomargin_top">{{$cat->category_name}}</h3>
        <table class="table table-striped cart-list">
          <thead>
          <tr>
            <th>Item</th>
            <th>Price</th>
            <th>Order</th>
          </tr>
          </thead>
          <tbody>
            
			<? 
			$menu_itm = DB::table('menu')                        
                           ->select('*')                          
                           ->where('menu_cat', '=', $cat->id)
                           ->where('restaurant_id', "=", $restaurant->id)
                           ->where('menu_name', "LIKE", "%$keyword%")
                           ->get();
			if($menu_itm) {
				
				foreach($menu_itm as $menu_item) {
			?>
          <tr id="tab_id<?=$y?>">
            <td>

              <div class="rstl_img"><a href="#menu_{{$menu_item->id}}">
                @if($menu_item->menu_image)
                <img src="{{ URL::asset('upload/menu/'.$menu_item->menu_image.'-s.jpg') }}" />               
                @endif
              </a>
			  
			  </div>
                        <div id="menu_{{$menu_item->id}}" class="modalDialog">
                          <div>
                            <a href="#close" title="Close" class="close">X</a>
                            <h2>{{$menu_item->menu_name}}</h2>
                              @if($menu_item->menu_image)
                              <img src="{{ URL::asset('upload/menu/'.$menu_item->menu_image.'-b.jpg') }}" />
                               @else
                              <img src="{{ URL::asset('upload/menu_img_s.png') }}" />
                              @endif 
							 
                          </div>
                        </div>
                        <div class="rstl_img_contant">
                        <h5>{{$menu_item->menu_name}}  
						 @if($menu_item->food_type=="1")
						<a href="#" title="VEG"><i style="color:#009302;padding: 4px; border: 1px solid;    font-size: 11px;" class="fa fa-circle" aria-hidden="true"></i></a>
						@endif 
						
						 @if($menu_item->food_type=="2")
						<a href="#" title="NON-VEG"><i style="color:#f91b1b;padding: 4px; border: 1px solid;    font-size: 11px;" class="fa fa-circle" aria-hidden="true"></i></a>
						@endif
						
						 @if($menu_item->food_type=="3")
						<a href="#" title="VEG"><i style="color:#009302;padding: 4px; border: 1px solid;    font-size: 11px;" class="fa fa-circle" aria-hidden="true"></i></a>&nbsp;
						<a href="#" title="NON-VEG"><i style="color:#f91b1b;padding: 4px; border: 1px solid;    font-size: 11px;" class="fa fa-circle" aria-hidden="true"></i></a>
						@endif
						</h5>
                        <p>{{$menu_item->sub_title}}</p>
                        </div>

              
            </td>
            <td style="    padding-left: 8x!important;"><strong>
			<?
			   if(isset($menu_item->price) && isset($menu_item->description) && $menu_item->description!=""&& $menu_item->price!=0)
			   {
				   echo '<input type="radio" name="des" value="item_price@'.$menu_item->id.'@'.$y.'@'.$menu_item->price.'"> '.$menu_item->description." ".getcong('currency_symbol')." ".$menu_item->price."</br>";
			   }
			   if(isset($menu_item->price2) && isset($menu_item->description2) && $menu_item->description2!=""&& $menu_item->price2!=0)
			   {
				   echo '<input type="radio" name="des" value="item_price2@'.$menu_item->id.'@'.$y.'@'.$menu_item->price2.'"> '.$menu_item->description2." ".getcong('currency_symbol')." ".$menu_item->price2."</br>";
			   }
			   if(isset($menu_item->price3) && isset($menu_item->description3) && $menu_item->description3!=""&& $menu_item->price3!=0)
			   {
				   echo '<input type="radio" name="des" value="item_price3@'.$menu_item->id.'@'.$y.'@'.$menu_item->price3.'"> '.$menu_item->description3." ".getcong('currency_symbol')." ".$menu_item->price3."</br>";
			   }
			   if(isset($menu_item->price4) && isset($menu_item->description4) && $menu_item->description4!=""&& $menu_item->price4!=0)
			   {
				   echo '<input type="radio" name="des" value="item_price4@'.$menu_item->id.'@'.$y.'@'.$menu_item->price4.'"> '.$menu_item->description4." ".getcong('currency_symbol')." ".$menu_item->price4."</br>";
			   }
			   if(isset($menu_item->price5) && isset($menu_item->description5) && $menu_item->description5!=""&& $menu_item->price5!=0)
			   {
				   echo '<input type="radio" name="des" value="item_price5@'.$menu_item->id.'@'.$y.'@'.$menu_item->price5.'"> '.$menu_item->description5." ".getcong('currency_symbol')." ".$menu_item->price5."</br>";
			   }
			   if(isset($menu_item->price6) && isset($menu_item->description6) && $menu_item->description6!=""&& $menu_item->price6!=0)
			   {
				   echo '<input type="radio" name="des" value="item_price6@'.$menu_item->id.'@'.$y.'@'.$menu_item->price6.'"> '.$menu_item->description6." ".getcong('currency_symbol')." ".$menu_item->price6."</br>";
			   }
			   if(isset($menu_item->price7) && isset($menu_item->description7) && $menu_item->description7!=""&& $menu_item->price7!=0)
			   {
				   echo '<input type="radio" name="des" value="item_price7@'.$menu_item->id.'@'.$y.'@'.$menu_item->price7.'"> '.$menu_item->description7." ".getcong('currency_symbol')." ".$menu_item->price7."</br>";
			   }
			   if(isset($menu_item->price8) && isset($menu_item->description8) && $menu_item->description8!=""&& $menu_item->price8!=0)
			   {
				   echo '<input type="radio" name="des" value="item_price8@'.$menu_item->id.'@'.$y.'@'.$menu_item->price8.'"> '.$menu_item->description8." ".getcong('currency_symbol')." ".$menu_item->price8."</br>";
			   }
			   if(isset($menu_item->price9) && isset($menu_item->description9) && $menu_item->description9!=""&& $menu_item->price9!=0)
			   {
				   echo '<input type="radio" name="des" value="item_price9@'.$menu_item->id.'@'.$y.'@'.$menu_item->price9.'"> '.$menu_item->description9." ".getcong('currency_symbol')." ".$menu_item->price9."</br>";
			   }
			   
			?>
			
			
			</strong></td>
            <td class="options">
                @if(Auth::check())
                    <a href="{{URL::to('add_item/'.$menu_item->id.'/item_price/'.$menu_item->price.'/'.$y.'/'.$slug)}}" id="link<?=$y?>" ><i class="fa fa-plus-square-o"></i></a>                  
                  @else                    
                    <a href="{{URL::to('login')}}"><i class="fa fa-plus-square-o"></i></a> 
                  @endif                
          </tr>
			<? $y++; } }  ?>
          
          </tbody>
        </table>
		<? } ?>
        <hr>
        @endforeach
			<input type="hidden" id="tot" value="<?=$y?>"/>
			<input type="hidden" id="res_id" value="<?=$restaurant->id?>"/>
         </form> 
		 <? if($y == 0) { ?>
		 <img src="{{ URL::asset('upload/empty.png') }}" alt="{{ $restaurant->restaurant_name }}" class="img-responsive"/></br>
		 No Record Found
		 <? } ?>
        </div>
           </div>
         
          @include("_particles.sidebar")

      </div>
    </div>
  </div>
<script>

    /*setInterval(function(){ 
		var tot = $('#tot').val();
		 var res_id = $('#res_id').val();
		// alert(user_id);
      
        $.ajax({
            type: "GET",
            url: 'https://1sol.in/auto_refresh/'+tot+'/'+res_id,
            //data: {title: ""},
            success: function( res ) {
                if(res.msg=="yes"){				
					window.location.href=window.location;
				}
            }
        });
	
	}, 5000);*/


 
 $('#myForm input').on('change', function() {
   var str = $('input[name=des]:checked', '#myForm').val();
   //alert(str);
   var res = str.split("@");   
   var price = res[3];
   //alert(price);
  $("#link"+res[2]).attr("href", "https://1sol.in/add_item/"+res[1]+"/"+res[0]+"/"+price+"/"+res[2]+"/"+"<?=$slug?>");
  //$("#link"+parseInt(res[2])).attr("href", "#");
});
 
 /*var x = document.getElementById("demo"); 
 function getLocation() {
	
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    $("#lat1").val(position.coords.latitude); 
    $("#log1").val(position.coords.longitude);
}
getLocation();*/
</script>

@endsection
