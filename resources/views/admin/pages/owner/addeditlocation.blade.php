@extends("admin.admin_app")



@section("content")



<div id="main">

	<div class="page-header">

		<h2> Add Location</h2>

		

		<a href="{{ URL::to('admin/location') }}" class="btn btn-default-light btn-xs"><i class="md md-backspace"></i> Back</a>

	  

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

                {!! Form::open(array('url' => array('admin/location/addlocation'),'class'=>'form-horizontal padding-15','name'=>'menu_form','id'=>'menu_form','role'=>'form','enctype' => 'multipart/form-data')) !!} 

                

                



                <div class="form-group">

                    <label for="" class="col-sm-3 control-label">Name</label>

                      <div class="col-sm-9">

                        <input type="text" name="name"  class="form-control">

                    </div>

                </div>

                <div class="form-group">

                    <label for="" class="col-sm-3 control-label">Latitude</label>

                      <div class="col-sm-9">

                        <input type="text" name="lat" class="form-control">

                    </div>

                </div>

                  <div class="form-group">

                    <label for="" class="col-sm-3 control-label">Lognitude</label>

                      <div class="col-sm-9">

                        <input type="text" name="log" class="form-control">

                    </div>

                </div>

                <hr>

                <div class="form-group">

                    <div class="col-md-offset-3 col-sm-9 ">

                    	<button type="submit" class="btn btn-primary">Add Location</button>

                         

                    </div>

                </div>

                

                {!! Form::close() !!} 

            </div>

        </div>

   

    

</div>



@endsection