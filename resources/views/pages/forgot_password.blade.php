@extends("app")

@section('head_title', 'Login' .' | '.getcong('site_name') )

@section('head_url', Request::url())

@section("content")
 
  <div class="white_for_login">
    <div class="container margin_60">
      <div class="row">
        <div class="col-md-3"> </div>
        <div class="col-md-6">
          <div id="order_process" class="box_style_2">
            <h2 class="inner">Forgot Password</h2>
			 @if(Session::has('error_msg'))
		      <div class="alert alert-danger alert-dismissable">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
				<strong>Danger!</strong> {{ Session::get('error_msg') }}
			  </div>
             @endif
			 @if(Session::has('success_msg'))
			 <div class="alert alert-success alert-dismissable">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
				<strong>Success!</strong> {{ Session::get('success_msg') }}
			  </div>
			 @endif 
              {!! Form::open(array('url' => 'forgot_password','class'=>'','id'=>'login','role'=>'form')) !!} 
              <div class="message">
                         
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
              <div class="form-group">
                <label>Email</label>
                <input type="email" placeholder="Your email" class="form-control" required value="" name="email" id="email">
              </div>
              <button class="btn btn-submit" type="submit">SEND</button>
			  <div class="not_login">New User <a href="register">Register Here</a></div>
            {!! Form::close() !!} 
          </div>
		  
        </div>

        <div class="col-md-3"> </div>
      </div>
    </div>
  </div>

@endsection
