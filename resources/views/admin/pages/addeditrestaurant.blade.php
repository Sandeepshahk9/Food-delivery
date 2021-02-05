@extends("admin.admin_app")
@section("content")


<div id="main">
	<div class="page-header">
		<h2> {{ isset($restaurant->restaurant_name) ? 'Edit: '. $restaurant->restaurant_name : 'Add Restaurant' }}</h2>
		
		<a href="{{ URL::to('admin/restaurants') }}" class="btn btn-default-light btn-xs"><i class="md md-backspace"></i> Back</a>
	  
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
                {!! Form::open(array('url' => array('admin/restaurants/addrestaurant'),'class'=>'form-horizontal padding-15','name'=>'category_form','id'=>'category_form','role'=>'form','enctype' => 'multipart/form-data')) !!} 
                <input type="hidden" name="id" value="{{ isset($restaurant->id) ? $restaurant->id : null }}">
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Restaurant Type</label>
                    <div class="col-sm-9">
                        <select id="basic" multiple name="restaurant_type[]" class="selectpicker show-tick form-control">
                            <option value="" >Select Type</option>
                            
                            @foreach($types as $i => $type)    
                                <? if(isset($restaurant->restaurant_type)) { 
								    $types = explode(",",$restaurant->restaurant_type);									
								?>
                                    <option value="{{$type->id}}" <? foreach($types as $t){ if($t==$type->id) { echo 'selected'; } } ?>>{{$type->type}}</option>
									<? } else {?>
                                <option value="{{$type->id}}">{{$type->type}}</option> 
                               <? } ?>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Restaurant Name</label>
                      <div class="col-sm-9">
                        <input type="text" name="restaurant_name" value="{{ isset($restaurant->restaurant_name) ? $restaurant->restaurant_name : null }}" class="form-control">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Restaurant Slug</label>
                    <div class="col-sm-9">
                        <input type="text" name="restaurant_slug" value="{{ isset($restaurant->restaurant_slug) ? $restaurant->restaurant_slug : null }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Address</label>
                    <div class="col-sm-9">
                        <textarea name="restaurant_address" id="restaurant_address" cols="60" rows="3" class="form-control">{{ isset($restaurant->restaurant_address) ? $restaurant->restaurant_address : null }}</textarea>
                    </div>
                </div>								
				<div class="form-group">                    
					<label for="" class="col-sm-3 control-label">GST (%) <span style="font-size:10px; color:#f71b1b;"> YES for GST applicable, NO for non-applicable</span> </label>                    
					<div class="col-sm-9">						
					<select id="gst_status" style="width:100px; float:left;" name="gst_status" class=" form-control"> 					
					<option value="yes" {{ isset($restaurant->gst_status) && $restaurant->gst_status=="yes" ? 'selected':''}}>YES</option>							
					<option value="no" {{ isset($restaurant->gst_status) && $restaurant->gst_status=="no" ? 'selected':''}}>NO</option> 						
					</select></br>                         
					<input type="text" name="gst" style=" margin-left:20px; margin-top:-20px; width:100px; float:left;" value="{{ isset($restaurant->gst) ? $restaurant->gst : null }}" class="form-control">                    
					</div>               
				</div>
				<div class="form-group">                    
					<label for="" class="col-sm-3 control-label">Show Home Page</label>                    
					<div class="col-sm-9">	
					<select id="show_home" style="width:100px; float:left;" name="show_home" class=" form-control"> 					
					<option>Select</option>				
					<option value="yes" {{ isset($restaurant->show_home) && $restaurant->show_home=="yes" ? 'selected':''}}>YES</option>				
					<option value="no" {{ isset($restaurant->show_home) && $restaurant->show_home=="no" ? 'selected':''}}>NO</option> 						
					</select>                    
					</div>               
				</div>
				<div class="form-group">                    
					<label for="" class="col-sm-3 control-label">Latitute <span style="font-size:10px; color:#f71b1b;">of the location</span></label>                    
					<div class="col-sm-9">						
					                       
					<input type="text" name="latitute" value="{{ isset($restaurant->latitute) ? $restaurant->latitute : null }}" class="form-control">                    
					</div>               
				</div>
				<div class="form-group">                    
					<label for="" class="col-sm-3 control-label">Lognitute <span style="font-size:10px; color:#f71b1b;">of the location</span></label>                    
					<div class="col-sm-9">						
					                       
					<input type="text" name="lognitute" value="{{ isset($restaurant->lognitute) ? $restaurant->lognitute : null }}" class="form-control">                    
					</div>               
				</div>
				<div class="form-group">                    
					<label for="" class="col-sm-3 control-label">0km -2.5km</label>                    
					<div class="col-sm-9">						
						<label for="" class="control-label" style="float:left">Delivery Charge</label> &nbsp; &nbsp; 
						<?
							if(isset($restaurant->first_km)){
								$first_km = explode("@",$restaurant->first_km);
							}
							
							if(isset($restaurant->second_km)){
								$second_km = explode("@",$restaurant->second_km);
							}
							
							if(isset($restaurant->third_km)){
								$third_km = explode("@",$restaurant->third_km);
							}
							
							if(isset($restaurant->fourth_km)){
								$fourth_km = explode("@",$restaurant->fourth_km);
							}
							
							if(isset($restaurant->fifth_km)){
								$fifth_km = explode("@",$restaurant->fifth_km);
							}
						?>                  
						<input type="text" name="first_km1" style="width:100px; float:left;" value="{{ isset($first_km[0]) ? $first_km[0]: null }}" class="form-control"> <label for="" class="control-label" style="float:left; margin-left:10px;">Min Order Amount</label> &nbsp; &nbsp;                   
						<input type="text" name="first_km2" style="width:100px; float:left;" value="{{ isset($first_km[1]) ? $first_km[1]: null }}" class="form-control"> <label for="" class="control-label" style="float:left; margin-left:10px;">Free Delivery Amount</label> &nbsp; &nbsp;                   
						<input type="text" name="first_km3" style="width:100px; float:left;" value="{{ isset($first_km[2]) ? $first_km[2]: null }}" class="form-control">                    
					</div>               
				</div>
				
				<div class="form-group">                    
					<label for="" class="col-sm-3 control-label">2.5km -5km</label>                    
					<div class="col-sm-9">						
						<label for="" class="control-label" style="float:left">Delivery Charge</label> &nbsp; &nbsp;                   
						<input type="text" name="second_km1" style="width:100px; float:left;" value="{{ isset($second_km[0]) ? $second_km[0]: null }}" class="form-control"> <label for="" class="control-label" style="float:left; margin-left:10px;">Min Order</label> &nbsp; &nbsp;                   
						<input type="text" name="second_km2" style="width:100px; float:left;" value="{{ isset($second_km[1]) ? $second_km[1]: null }}" class="form-control"> <label for="" class="control-label" style="float:left; margin-left:10px;">Free Delivery</label> &nbsp; &nbsp;                   
						<input type="text" name="second_km3" style="width:100px; float:left;" value="{{ isset($second_km[2]) ? $second_km[2]: null }}" class="form-control">                    
					</div>               
				</div>
				
				<div class="form-group">                    
					<label for="" class="col-sm-3 control-label">5km -7.5km</label>                    
					<div class="col-sm-9">						
						<label for="" class="control-label" style="float:left">Delivery Charge</label> &nbsp; &nbsp;                   
						<input type="text" name="third_km1" style="width:100px; float:left;" value="{{ isset($third_km[0]) ? $third_km[0]: null }}" class="form-control"> <label for="" class="control-label" style="float:left; margin-left:10px;">Min Order</label> &nbsp; &nbsp;                   
						<input type="text" name="third_km2" style="width:100px; float:left;" value="{{ isset($third_km[1]) ? $third_km[1]: null }}" class="form-control"> <label for="" class="control-label" style="float:left; margin-left:10px;">Free Delivery</label> &nbsp; &nbsp;                   
						<input type="text" name="third_km3" style="width:100px; float:left;" value="{{ isset($third_km[2]) ? $third_km[2]: null }}" class="form-control">                   
					</div>               
				</div>
				
				<div class="form-group">                    
					<label for="" class="col-sm-3 control-label">7.5km -10km</label>                    
					<div class="col-sm-9">						
						<label for="" class="control-label" style="float:left">Delivery Charge</label> &nbsp; &nbsp;                   
						<input type="text" name="fourth_km1" style="width:100px; float:left;" value="{{ isset($fourth_km[0]) ? $fourth_km[0]: null }}" class="form-control"> <label for="" class="control-label" style="float:left; margin-left:10px;">Min Order</label> &nbsp; &nbsp;                   
						<input type="text" name="fourth_km2" style="width:100px; float:left;" value="{{ isset($fourth_km[1]) ? $fourth_km[1]: null }}" class="form-control"> <label for="" class="control-label" style="float:left; margin-left:10px;">Free Delivery</label> &nbsp; &nbsp;                   
						<input type="text" name="fourth_km3" style="width:100px; float:left;" value="{{ isset($fourth_km[2]) ? $fourth_km[2]: null }}" class="form-control"> 	
					</div>               
				</div>
				
				<div class="form-group">                    
					<label for="" class="col-sm-3 control-label">10km -12.5km</label>                    
					<div class="col-sm-9">						
						<label for="" class="control-label" style="float:left">Delivery Charge</label> &nbsp; &nbsp;                   
						<input type="text" name="fifth_km1" style="width:100px; float:left;" value="{{ isset($fifth_km[0]) ? $fifth_km[0]: null }}" class="form-control"> <label for="" class="control-label" style="float:left; margin-left:10px;">Min Order</label> &nbsp; &nbsp;                   
						<input type="text" name="fifth_km2" style="width:100px; float:left;" value="{{ isset($fifth_km[1]) ? $fifth_km[1]: null }}" class="form-control"> <label for="" class="control-label" style="float:left; margin-left:10px;">Free Delivery</label> &nbsp; &nbsp;                   
						<input type="text" name="fifth_km3" style="width:100px; float:left;" value="{{ isset($fifth_km[2]) ? $fifth_km[2]: null }}" class="form-control"> 
					  
					</div>               
				</div>
				
				
				
				
				
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Description</label>
                    <div class="col-sm-9">
                        <textarea name="restaurant_description" id="restaurant_description" cols="30" rows="8" class="summernote">{{ isset($restaurant->restaurant_description) ? $restaurant->restaurant_description : null }}</textarea>
                    </div>
                </div>
               <div class="form-group">                    
					<label for="" class="col-sm-3 control-label">Coupon</label>                    
					<div class="col-sm-9">						
						<label for="" class="control-label" style="float:left">Code</label> &nbsp; &nbsp; 
						                
						<input type="text" name="coupon_code" style="width:150px; float:left;" value="{{ isset($restaurant->coupon_code) ? $restaurant->coupon_code: null }}" class="form-control"> <label for="" class="control-label" style="float:left; margin-left:10px;">Discount (%)</label> &nbsp; &nbsp;                   
						<input type="text" name="coupon_discount" style="width:100px; float:left;" value="{{ isset($restaurant->coupon_discount) ? $restaurant->coupon_discount: null }}" class="form-control">                    
					</div>               
				</div>
                 <div class="form-group">
                    <label for="avatar" class="col-sm-3 control-label">Restaurant Logo</label>
                    <div class="col-sm-9">
                        <div class="media">
                            <div class="media-left">
                                @if(isset($restaurant->restaurant_logo))
                                 
                                    <img src="{{ URL::asset('upload/restaurants/'.$restaurant->restaurant_logo.'-s.jpg') }}" width="100" alt="person">
                                @endif
                                                                
                            </div>
                            <div class="media-body media-middle">
                                <input type="file" name="restaurant_logo" class="filestyle"> 
                            </div>
                        </div>
    
                    </div>
                </div>
				
                
                <h4>Opening time</h4> 

                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Monday</label>
                    <div class="col-sm-9">
                        <input type="text" name="open_monday" value="{{ isset($restaurant->open_monday) ? $restaurant->open_monday : null }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Tuesday</label>
                    <div class="col-sm-9">
                        <input type="text" name="open_tuesday" value="{{ isset($restaurant->open_tuesday) ? $restaurant->open_tuesday : null }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Wednesday</label>
                    <div class="col-sm-9">
                        <input type="text" name="open_wednesday" value="{{ isset($restaurant->open_wednesday) ? $restaurant->open_wednesday : null }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Thursday</label>
                    <div class="col-sm-9">
                        <input type="text" name="open_thursday" value="{{ isset($restaurant->open_thursday) ? $restaurant->open_thursday : null }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Friday</label>
                    <div class="col-sm-9">
                        <input type="text" name="open_friday" value="{{ isset($restaurant->open_friday) ? $restaurant->open_friday : null }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Saturday</label>
                    <div class="col-sm-9">
                        <input type="text" name="open_saturday" value="{{ isset($restaurant->open_saturday) ? $restaurant->open_saturday : null }}" class="form-control">
                    </div>
                </div>  
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Sunday</label>
                    <div class="col-sm-9">
                        <input type="text" name="open_sunday" value="{{ isset($restaurant->open_sunday) ? $restaurant->open_sunday : null }}" class="form-control">
                    </div>
                </div>  
                <hr>
                <div class="form-group">
                    <div class="col-md-offset-3 col-sm-9 ">
                    	<button type="submit" class="btn btn-primary">{{ isset($restaurant->id) ? 'Edit Restaurant ' : 'Add Restaurant' }}</button>
                         
                    </div>
                </div>
                
                {!! Form::close() !!} 
            </div>
        </div>
   
    
</div>

@endsection

