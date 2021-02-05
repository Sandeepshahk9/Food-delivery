@extends("admin.admin_app")

@section("content")

<div id="main">
	<div class="page-header">
		<h2> {{ isset($menu->menu_name) ? 'Edit: '. $menu->menu_name : 'Add Menu' }}</h2>
		
		<a href="{{ URL::to('admin/restaurants/view/'.$restaurant_id.'/menu') }}" class="btn btn-default-light btn-xs"><i class="md md-backspace"></i> Back</a>
	  
	</div>
	@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
	@endif
	 @if(Session::has('flash_message'))
				    <div class="alert alert-success">
				    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span></button>
				        {{ Session::get('flash_message') }}
				    </div>
	@endif
   
   	<div class="panel panel-default">
            <div class="panel-body">
                {!! Form::open(array('url' => array('admin/restaurants/view/'.$restaurant_id.'/menu/addmenu'),'class'=>'form-horizontal padding-15','name'=>'menu_form','id'=>'menu_form','role'=>'form','enctype' => 'multipart/form-data')) !!} 
                
                <input type="hidden" name="restaurant_id" value="{{$restaurant_id}}">
                <input type="hidden" name="id" value="{{ isset($menu->id) ? $menu->id : null }}">
                
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Menu category</label>
                    <div class="col-sm-4">
                        <select id="basic" name="menu_cat" class="selectpicker show-tick form-control">
                            <option value="">Select Type</option>
                            
                            @foreach($categories as $i => $category)    
                                @if(isset($menu->menu_cat) && $menu->menu_cat==$category->id)  
                                    <option value="{{$category->id}}" selected >{{$category->category_name}}</option>
                                     
                                @else
                                <option value="{{$category->id}}">{{$category->category_name}}</option> 
                                @endif                          
                            @endforeach
                        </select>
                    </div>
                </div>								
				<div class="form-group">                    
				<label for="" class="col-sm-3 control-label">Food Type <span style="font-size:10px; color:#f71b1b;">(Veg, Non-veg)</span></label>                    
				<div class="col-sm-4">                        
				<select id="food_type" name="food_type" class="selectpicker show-tick form-control">                            
				<option value="">Select Type</option>                            
				<option value="1" {{ isset($menu->food_type) && $menu->food_type=="1" ? 'selected':''}}>VEG</option>                            
				<option value="2" {{ isset($menu->food_type) && $menu->food_type=="2" ? 'selected':''}}>NON-VEG</option>                         
				<option value="3" {{ isset($menu->food_type) && $menu->food_type=="3" ? 'selected':''}}>BOTH</option>                         
				</select>                    
				</div>                
				</div>

                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Menu Name</label>
                      <div class="col-sm-9">
                        <input type="text" name="menu_name" value="{{ isset($menu->menu_name) ? $menu->menu_name : null }}" class="form-control">
                    </div>
                </div>
				
				 <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Sub Title</label>
                      <div class="col-sm-9">
                        <input type="text" name="sub_title" value="{{ isset($menu->sub_title) ? $menu->sub_title : null }}" class="form-control">
                    </div>
                </div>
				
				
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Sort Description</label>
                      <div class="col-sm-9">
                        <input type="text" name="description" value="{{ isset($menu->description) ? $menu->description : null }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Price</label>
                      <div class="col-sm-9">
                         
                        <input id="touch-spin-2" data-toggle="touch-spin" data-min="-1000000" data-max="1000000" data-prefix="$" data-step="1" type="text" value="{{ isset($menu->price) ? $menu->price : null }}" name="price" class="form-control"/>
                    </div>
                </div>
				
				<div class="form-group">
                    <label for="" class="col-sm-3 control-label">Sort Description2</label>
                      <div class="col-sm-9">
                        <input type="text" name="description2" value="{{ isset($menu->description2) ? $menu->description2 : null }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Price2</label>
                      <div class="col-sm-9">
                         
                        <input id="touch-spin-2" data-toggle="touch-spin" data-min="-1000000" data-max="1000000" data-prefix="$" data-step="1" type="text" value="{{ isset($menu->price2) ? $menu->price2 : null }}" name="price2" class="form-control"/>
                    </div>
                </div>
				
				<div class="form-group">
                    <label for="" class="col-sm-3 control-label">Sort Description 3</label>
                      <div class="col-sm-9">
                        <input type="text" name="description3" value="{{ isset($menu->description3) ? $menu->description3 : null }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Price 3</label>
                      <div class="col-sm-9">
                         
                        <input id="touch-spin-2" data-toggle="touch-spin" data-min="-1000000" data-max="1000000" data-prefix="$" data-step="1" type="text" value="{{ isset($menu->price3) ? $menu->price3 : null }}" name="price3" class="form-control"/>
                    </div>
                </div>
				
				<div class="form-group">
                    <label for="" class="col-sm-3 control-label">Sort Description 4</label>
                      <div class="col-sm-9">
                        <input type="text" name="description4" value="{{ isset($menu->description4) ? $menu->description4 : null }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Price 4</label>
                      <div class="col-sm-9">
                         
                        <input id="touch-spin-2" data-toggle="touch-spin" data-min="-1000000" data-max="1000000" data-prefix="$" data-step="1" type="text" value="{{ isset($menu->price4) ? $menu->price4 : null }}" name="price4" class="form-control"/>
                    </div>
                </div>
				
				<div class="form-group">
                    <label for="" class="col-sm-3 control-label">Sort Description 5</label>
                      <div class="col-sm-9">
                        <input type="text" name="description5" value="{{ isset($menu->description5) ? $menu->description5 : null }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Price 5</label>
                      <div class="col-sm-9">
                         
                        <input id="touch-spin-2" data-toggle="touch-spin" data-min="-1000000" data-max="1000000" data-prefix="$" data-step="1" type="text" value="{{ isset($menu->price5) ? $menu->price5 : null }}" name="price5" class="form-control"/>
                    </div>
                </div>
				
				<div class="form-group">
                    <label for="" class="col-sm-3 control-label">Sort Description 6</label>
                      <div class="col-sm-9">
                        <input type="text" name="description6" value="{{ isset($menu->description6) ? $menu->description6 : null }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Price 6</label>
                      <div class="col-sm-9">
                         
                        <input id="touch-spin-2" data-toggle="touch-spin" data-min="-1000000" data-max="1000000" data-prefix="$" data-step="1" type="text" value="{{ isset($menu->price6) ? $menu->price6 : null }}" name="price6" class="form-control"/>
                    </div>
                </div>
				
				<div class="form-group">
                    <label for="" class="col-sm-3 control-label">Sort Description 7</label>
                      <div class="col-sm-9">
                        <input type="text" name="description7" value="{{ isset($menu->description7) ? $menu->description7 : null }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Price 7</label>
                      <div class="col-sm-9">
                         
                        <input id="touch-spin-2" data-toggle="touch-spin" data-min="-1000000" data-max="1000000" data-prefix="$" data-step="1" type="text" value="{{ isset($menu->price7) ? $menu->price7 : null }}" name="price7" class="form-control"/>
                    </div>
                </div>
				
				<div class="form-group">
                    <label for="" class="col-sm-3 control-label">Sort Description 8</label>
                      <div class="col-sm-9">
                        <input type="text" name="description8" value="{{ isset($menu->description8) ? $menu->description8 : null }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Price 8</label>
                      <div class="col-sm-9">
                         
                        <input id="touch-spin-2" data-toggle="touch-spin" data-min="-1000000" data-max="1000000" data-prefix="$" data-step="1" type="text" value="{{ isset($menu->price8) ? $menu->price8 : null }}" name="price8" class="form-control"/>
                    </div>
                </div>
				
				<div class="form-group">
                    <label for="" class="col-sm-3 control-label">Sort Description 9</label>
                      <div class="col-sm-9">
                        <input type="text" name="description9" value="{{ isset($menu->description9) ? $menu->description9 : null }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Price 9</label>
                      <div class="col-sm-9">
                         
                        <input id="touch-spin-2" data-toggle="touch-spin" data-min="-1000000" data-max="1000000" data-prefix="$" data-step="1" type="text" value="{{ isset($menu->price9) ? $menu->price9 : null }}" name="price9" class="form-control"/>
                    </div>
                </div>
				
				
				<!--div class="form-group">                    
					<label for="" class="col-sm-3 control-label">Coupon</label>                    
					<div class="col-sm-9">						
						<label for="" class="control-label" style="float:left">Code</label> &nbsp; &nbsp; 
						                
						<input type="text" name="coupon_code" style="width:150px; float:left;" value="{{ isset($menu->coupon_code) ? $menu->coupon_code: null }}" class="form-control"> <label for="" class="control-label" style="float:left; margin-left:10px;">Discount (%)</label> &nbsp; &nbsp;                   
						<input type="text" name="coupon_discount" style="width:100px; float:left;" value="{{ isset($menu->coupon_discount) ? $menu->coupon_discount: null }}" class="form-control">                    
					</div>               
				</div-->
                <div class="form-group">
                    <label for="avatar" class="col-sm-3 control-label">Menu Image</label>
                    <div class="col-sm-9">
                        <div class="media">
                            <div class="media-left">
                                @if(isset($menu->menu_image))
                                 
                                    <img src="{{ URL::asset('upload/menu/'.$menu->menu_image.'-s.jpg') }}" width="100" alt="person">
                                @endif
                                                                
                            </div>
                            <div class="media-body media-middle">
                                <input type="file" name="menu_image" class="filestyle"> 
                            </div>
                        </div>
    
                    </div>
                </div> 
                <hr>
                <div class="form-group">
                    <div class="col-md-offset-3 col-sm-9 ">
                    	<button type="submit" class="btn btn-primary">{{ isset($menu->id) ? 'Edit Menu ' : 'Add Menu' }}</button>
                         
                    </div>
                </div>
                
                {!! Form::close() !!} 
            </div>
        </div>
   
    
</div>

@endsection