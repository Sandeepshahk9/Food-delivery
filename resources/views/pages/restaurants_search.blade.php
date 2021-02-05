@extends("app")

@section('head_title', 'Restaurant Search' .' | '.getcong('site_name') )

@section('head_url', Request::url())

@section("content")

<div class="sub-banner" style="background:url({{ URL::asset('upload/'.getcong('page_bg_image')) }}) no-repeat center top;">
    <div class="overlay">
      <div class="container">
	  <?
		$val =0;
		if($res!="" && count($res)>0) { 
          foreach($res as $rt) {
			$res_type2=$rt->restaurant_type;
			$res_array2 = explode(',',$res_type2);
			if($category_search!=1.2){
			if(in_array($category_search, $res_array2)) {
				$val=$val+1;
				
			} } } }
	  ?>
        <h1> <? if($val!=0) { echo $val; } else { echo $total_res; } ?> restaurants available 
			 <? //if($category_search!="1.2") { echo $category_search; } ?>
		</h1> 
      </div>
    </div>
  </div>

 <div class="restaurant_list_detail">
    <div class="container">
	<div class="row">
		{!! Form::open(array('url' => 'restaurants','class'=>'', 'name'=>'res_search','id'=>'res_search','role'=>'form', 'enctype' => 'multipart/form-data')) !!}
		<div class="col-md-3 col-sm-3 col-xs-3">
		   <div class="form-group">
			  <label for="comment">Short By:</label>
				
			  <select required name="rate" class="form-control" >
					<option value="">Select</option>
					<option <? if(isset($_POST['rate'])) { if($_POST['rate']=='flat') { echo 'selected'; } } ?> value="flat">Flat</option>
					<option <? if(isset($_POST['rate'])) { if($_POST['rate']=='desc') { echo 'selected'; } } ?> value="desc">Decending Rating</option>
					<option <? if(isset($_POST['rate'])) { if($_POST['rate']=='asc') { echo 'selected'; } } ?> value="asc">Acceding Rating</option>
				</select>
			</div>
			
		</div>
		
		<div class="col-md-3 col-sm-3 col-xs-3">
		   <div class="form-group">
			  <label for="comment">Category:</label>
			 
			  <select required id="category" name="category" class="form-control" >
					<option value="">Select</option>				
					 <?
					 $category = \App\Types::get();
					 if($category) {
						 foreach($category as $ct){
					 ?>
					<option <? if(isset($_POST['category'])) { if($_POST['category']==$ct->id) { echo 'selected'; } } ?> value="<?=$ct->id?>"><?=$ct->type?></option>
					<? }} ?>
				  
				</select>
			</div> 
			
		</div>
		<div class="col-md-3 col-sm-3 col-xs-3">
		   <div class="form-group">
			  <button type="submit" class="btn btn-success">Search</button>
			</div> 
			
		</div>
		 {!! Form::close() !!} 
	</div>
      <div class="row"> 
        <div class="col-md-9 col-sm-7 col-xs-12"> 
		 <?php 
		 
		 if($res!="" && count($res)>0) { 
          foreach($res as $i => $re) {
			$res_type=$re->restaurant_type;
			$res_array = explode(',',$res_type);
			if($category_search!=1.2){
			if(in_array($category_search, $res_array)) {
		  ?>
          
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
			   <? 
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
              <div class="type"> {{$str}} </div>
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
		 <? } } elseif($category_search=="1.2") { ?> 
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
			   <? 
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
              <div class="type"> {{$str}} </div>
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
		 <?} } } else { echo '<h1>No Record Found!</h1>'; } ?>
          
                        
           </div>
          
          @include("_particles.sidebar")

      </div>
    </div>
  </div>
<script>

var x = document.getElementById("demo"); 
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
getLocation();
</script>
@endsection
