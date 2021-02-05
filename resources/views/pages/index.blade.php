@extends("app")
@section("content")
  
@include("_particles.search_slider") 

<!-- Content ================================================== --> 

<div id="blog_item" class="gap_1">
  <div class="container">
  <h1 class="mb5 zui-highlight margin_h">Choose one to start building your order</h1>
  <p class="sdask"><a href="https://1sol.in/restaurants">Check All Restaurants</a></p>
   
   <nav id="list_shortcuts">
    <ul>
    @foreach($types as $type)
    <li> <a title="Chinese" href="{{URL::to('restaurants/type/'.$type->id)}}" data-cuisine="chinese"> <img alt="{{$type->type}}" src="{{ URL::asset('upload/type/'.$type->type_image.'.jpg') }}"> <p class="text_type">{{$type->type}}</p> </a> </li>
    @endforeach
     

    </ul>
   </nav>
  </div>
  </div>
<div class="how_work">
	<img align="middle" src="{{ URL::asset('site_assets/img/howit.png') }}">
</div>
  <div class="white_bg">
    <div class="container">
      <div class="main_title">
        <h2 class="nomargin_top bg_bl">Choose from Most Popular</h2>         
      </div>
      <div class="row">
        @foreach($restaurants as $i => $restaurant)
        <div class="col-md-4 col-sm-6 col-xs-6"> <a class="strip_list" href="{{URL::to('restaurants/menu/'.$restaurant->restaurant_slug)}}">
          <div class="desc">
            <h3>{{ $restaurant->restaurant_name }}</h3>
          <div class="type"> {{$restaurant->type}} </div>
          <div class="location">{{$restaurant->restaurant_address}}  </div>
            
            <div class="rating"> 
                @for($x = 0; $x < 5; $x++)
                    
                @if($x < $restaurant->review_avg)
                  <i class="fa fa-star"></i>
                @else
                  <i class="fa fa-star fa fa-star-o"></i>
                @endif
               
                @endfor
                
              </div>
            <div class="thumb_strip"> <img src="{{ URL::asset('upload/restaurants/'.$restaurant->restaurant_logo.'-s.jpg') }}" alt="{{ $restaurant->restaurant_name }}"> </div>
          </div>
          </a> 
        </div>
        @endforeach
          
           
           
      </div>
    </div>
  </div>
  
  <div class="white_bg">
    <div class="container">
      <div class="main_title">
        <h2 class="nomargin_top bg_bl">Newly Register Restaurants</h2>         
      </div>
      <div class="row">
        @foreach($res as $i => $r)
        <div class="col-md-4 col-sm-6 col-xs-6"> <a class="strip_list" href="{{URL::to('restaurants/menu/'.$r->restaurant_slug)}}">
          <div class="desc">
            <h3>{{ $r->restaurant_name }}</h3>
          <div class="type"> {{$r->type}} </div>
          <div class="location">{{$r->restaurant_address}}  </div>
            
            <div class="rating"> 
                @for($x = 0; $x < 5; $x++)
                    
                @if($x < $r->review_avg)
                  <i class="fa fa-star"></i>
                @else
                  <i class="fa fa-star fa fa-star-o"></i>
                @endif
               
                @endfor
                
              </div>
            <div class="thumb_strip"> <img src="{{ URL::asset('upload/restaurants/'.$r->restaurant_logo.'-s.jpg') }}" alt="{{ $r->restaurant_name }}"> </div>
          </div>
          </a> 
        </div>
        @endforeach
          
           
           
      </div>
    </div>
  </div>
 
<!-- End section --> 
<!-- End Content =============================================== --> 
<script>
	var suggustionList = [
	<?
	$res = DB::table('restaurants')->get();
	foreach($res as $r) {
	echo "{'name':'".$r->restaurant_name."', 'id': ".$r->id."},";
	}
	?>
	
	];
	var config = {};
	config["data"] = suggustionList;
	config["attr"] = ["id"];
	config["searchBy"] = ["name"];
	config["suggFormat"] = "$0";
	config["displayFormat"] = "$0";

	$(".assinee").showSuggestion(config);

</script>
@endsection
