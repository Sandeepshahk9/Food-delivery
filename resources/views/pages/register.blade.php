@extends("app")

@section('head_title', 'Register' .' | '.getcong('site_name') )

@section('head_url', Request::url())

@section("content")
 
<div class="white_for_login">
  <div class="container margin_60">
   
   <div class="row">

    <div class="col-md-3">

    </div>  
    <div class="col-md-6">
        <div class="box_style_2" id="order_process">
          <h2 class="inner">Register</h2>
          {!! Form::open(array('url' => 'register','class'=>'','id'=>'myProfile','role'=>'form')) !!} 

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
           <div class="alert alert-success fade in">              
             {{ Session::get('flash_message') }}
           </div>
        @endif
		
		 @if(Session::has('error_message'))
		<div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong> {{ Session::get('error_message') }}</strong> 
		  </div>
		@endif
          <div class="form-group">
            <label>First name</label>
            <input type="text" class="form-control" required id="first_name" name="first_name" value="" placeholder="First name">
          </div>
          <div class="form-group">
            <label>Last name</label>
            <input type="text" class="form-control" required id="last_name" value="" name="last_name" placeholder="Last name">
          </div>          
          <div class="form-group">
            <label>Email</label>
            <input type="email" id="email" name="email" required value="" class="form-control" placeholder="Your email">
          </div> 
		 <div class="form-group">
            <label>Phone</label>
            <input type="text" id="phone" name="phone" required value="" class="form-control" placeholder="Your Phone">
          </div>            
          <div class="row">
            <div class="col-md-6 col-sm-6">
              <div class="form-group">
                <label>Password</label>
                <input type="password" id="password" required name="password" value="" class="form-control" placeholder="Password">
              </div>
            </div>
            <div class="col-md-6 col-sm-6">
              <div class="form-group">
                <label>Confirm password</label>
                <input type="password" id="password_confirmation" required name="password_confirmation" value="" class="form-control" placeholder="Confirm password">
              </div>
            </div>
          </div>
		  
		 <!-- 	  
           <div class="form-group">
            <label>User Type</label>
             <select class="form-control" name="usertype" id="usertype">
                  <option value="User">User</option>
                  <option value="Owner">Owner</option>                  
                </select>

          </div>  -->
		<div class="form-group">
            <label>Address</label>
            <textarea rows="5" cols="10" name="address" id="address" class="form-control" required ></textarea>
          </div>
		  <div class="form-group">
            <label>City</label>
            <input type="text" id="city" name="city" value="" class="form-control" required placeholder="City">
          </div> 
		  <div class="form-group">
            <label>Pincode</label>
            <input type="text" id="postal_code" name="postal_code" value="" class="form-control" required placeholder="Pincode">
          </div> 
		   <div class="form-group">
            <label><input type="checkbox" id="postal_code" name="postal_code" checked required value="yes"/> <a href="https://1sol.in/about" target="_blank">Accept Terms & Conditions</a></label>
			<input type="text" id="otp" name="otp" value="" style="display:none" class="form-control" required placeholder="Enter OTP here....">
          </div>
          <hr>
			<input type="hidden" id="text_val" value="1"/>
			<input type="hidden" id="match_otp" value="<?=md5(Session::get('otp'));?>"/>
            <button type="submit" id="submit" class="btn btn-submit">Register</button>
      {!! Form::close() !!} 
        </div>
        <!-- End box_style_1 --> 
      </div>
      <!-- End col-md-6 -->

 
   </div>
   
  </div>
 </div> 
 <script>
  $( "#submit" ).click(function() {
	  
	  var first_name = $('#first_name').val();
	  var last_name = $('#last_name').val();
	  var email = $('#email').val();
	  var phone = $('#phone').val();
	  var password = $('#password').val();
	  var password_confirmation = $('#password_confirmation').val();
	  
	  var address = $('#address').val();
	  var city = $('#city').val();
	  var postal_code = $('#postal_code').val();
	  var text_val = $('#text_val').val();
	  
	  if(first_name!="" && last_name!="" && email!="" && phone!="" && password!="" && password_confirmation!="" &&  
	  address!="" && city!="" && postal_code!=""){
		 if($('#text_val').val() ==1){
			$('#text_val').val(2);
			$('#otp').show();
			  $.ajax({
			   type: "GET",
				url: 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey=AE6RsjVm7U6T6KMuuGDnag&senderid=ONESOL&channel=2&DCS=0&flashsms=0&number=91'+phone+'&text=your OTP is <?=Session::get('otp')?>&route=clickhere',			  
				success: function( res ) {				   
				}
			});
			
			
		 }
		 else if($('#text_val').val() ==2){
			 
			 if(CryptoJS.MD5($('#otp').val())==$('#match_otp').val()){
				 $('#myProfile').submit();
			 }
			 else{
				 swal("Error!", "OTP does not matched!", "error");
				 return false;
			 }
		 }
	  }
	  
	});
 </script>

@endsection
