@extends('admin.layouts.master')
@section('styles')
@parent

{{ asset('assets/admin/vendor/multi-select/css/multi-select.css') }}

@stop
@section('content')
  @section('bodyClass')
    @parent
    hold-transition skin-blue sidebar-mini
  @stop 
 <div class="container-fluid dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">Change Password</h2>
            </div>
        </div>
    </div>  
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="col-sm-12 card-header form-header">
                    <div class="row align-items-center">
                        <h5>Fields marked (<em>*</em> ) are mandatory</h5> 
                    </div>
                </div>

                {{ Form::open(array('url' => apa('change_password') ,'files'=>true,'id'=>'change_password')) }}
					
                    <div class="card-body">
                        <div class="col-sm-12">
                            @include('admin.common.user_message')
                            <div class="clearfix"></div>
                                <div class="row">
                                    
									<div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="current_password" class="col-form-label">Enter you current password <em>*</em></label>
                                            <input dir="ltr" type="password" name="current_password" id="current_password" class="form-control" value="" required="required"/>
                                        </div>
                                    </div>
								</div>
                                
                                 <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="name" class="col-form-label">New Password<em>*</em></label>
                                            <input dir="ltr" type="password" name="password" id="password" class="form-control" value="" required="required"/>
                                        </div>
                                    </div>
                                 </div>
								 
								 
								<div class="row">
                                    
									<div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="password" class="col-form-label">Confirm Password<em>*</em></label>
                                            <input dir="ltr" type="password" name="password_confirmation" id="password_confirmation" class="form-control" value="" required="required"/>
                                        </div>
                                    </div>
								</div> 
								
                        </div>
                    </div>
					
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="button-control-wrapper">
                                <div class="form-group">
                                    <input class="btn btn-primary" type="submit" name="updatebtnsubmit" value="Save"  />
                                    <a href="{{ apa('dashboard') }}" class="btn btn-danger">Close</a>
                                </div>
                            </div>
                        </div>
                    </div>
					
					
                {{ Form::close() }}
            </div>
        </div>
    </div>
 </div>  
@stop

@section('scripts')
@parent
<script>
	
 $(document).ready(function(){
	$('#change_password').validate({
		'rules':{
			'password' : {'required':true},
			'password_confirmation' : { equalTo: "#password"}
		},
		'messages':{
			'password' : {'required':'{{ lang("field_required") }}'},
			'password_confirmation' : {'required':'{{ lang("field_required") }}','equalTo':'{{ lang("password_mismatch") }}'}		
		},
		submitHandler: function(form) {
			return true;
		}
	});	
 });
</script>

@stop