@extends('admin.layouts.master')
@section('styles')
@parent

{{ Html::style('assets/admin/vendor/multi-select/css/multi-select.css') }}

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
                <h2 class="pageheader-title">Add Admin User
					<a class="float-sm-right" href="{{ apa('users') }}"><button class="btn btn-outline-dark btn-flat">Back</button></a>
				</h2>
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

                {{ Form::open(array('url' => apa('admin_users/create/') ,'files'=>true,'id'=>'form')) }}
		
                    <div class="card-body">
                        <div class="col-sm-12">
                            @include('admin.common.user_message')
                            <div class="clearfix"></div>
                            
                                 <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="user_full_name" class="col-form-label">Full Name<em>*</em></label>
                                            <input id="user_full_name" name="user_full_name" type="text" value="{{ old('user_full_name') }}" class="form-control" required>
                                        </div>
                                    </div>
									<div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="user_email" class="col-form-label">Email<em>*</em></label>
                                            <input id="user_email" name="user_email" value="{{ old('user_email') }}" type="email" class="form-control" required>
                                        </div>
                                    </div>
                                 </div>
								 
								 <div class="row">
                                    
									<div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="password" class="col-form-label">Password <em>*</em></label>
                                            <input id="password" name="password" type="password" value="" class="form-control" required>
                                        </div>
                                    </div>
									
									<div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="phone" class="col-form-label">Phone<em>*</em></label>
                                            <input id="phone" name="user_phone_number" type="text" value="{{ old('user_phone_number') }}" class="form-control" required>
                                        </div>
                                    </div>
                                     
                                 </div>
                                 
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="user_status" class="col-form-label">Status</label>
                                            <select class="form-control" id="user_status" name="user_status">
                                                <option {{ ( old('user_status') == 1 ) ? ' selected =="selected" ' : '' }} value="1">Enable Account</option>
                                                <option {{ ( old('user_status')  ==2) ? ' selected =="selected" ' : '' }} value="2">Disable Account</option>
                                            </select>
                                        </div>
                                    </div>
                                 </div>
								<div class="row">
									<div class="col-sm-12">
									<hr/>
									</div>
								</div> 
								<div class="row">   
									<div class="col-sm-12">
										<div class="form-group">
										<h3>Assign Role(s)</h3>

                                        <div class="roles_box">
                                            <?php $userRoleIDs = (!empty(old('roles'))) ? old('roles') : []   ?>
                                            @foreach ($roles as $role)
                                            <label class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" data-id="{{ $role->name }}" name="roles[]" value="{{ $role->id}}"  {{ (in_array($role->id, $userRoleIDs))?' checked="checked" ':'' }} ><span class="custom-control-label">{{ Form::label($role->name, ucfirst($role->name)) }}</span>
                                            </label>
                                            @endforeach
                                        </div>

										<?php /*<table width="100%" class="table table-striped">
												<thead>
												<tr>
													<th style="width: 200px;text-align:center">Select</th>
													<th>Role name</th>
												</tr> 
												
												</thead>
												<tbody>
												<?php $userRoleIDs = (!empty(old('roles'))) ? old('roles') : []   ?>
												@foreach ($roles as $role)
													<tr>
														<td style="text-align:center">
															<input type="checkbox" data-id="{{ $role->name }}" name="roles[]" value="{{ $role->id}}"  {{ (in_array($role->id, $userRoleIDs))?' checked="checked" ':'' }} />
														</td>
														<td>{{ Form::label($role->name, ucfirst($role->name)) }}</td>
													</tr>
												@endforeach
											</tbody>
										</table> */ ?>
										</div>
									</div>     
								</div>
								
								
                        </div>
                    </div>
					
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="button-control-wrapper">
                                <div class="form-group">
                                    <input class="btn btn-outline-primary" type="submit" name="createbtnsubmit" value="Save"  />
                                    <a href="{{ apa('users') }}" class="btn btn-outline-danger">Close</a>
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
<script type="text/javascript" src="{{ asset('assets/admin/vendor/multi-select/js/jquery.multi-select.js') }}"></script>
<script>
	
 $(document).ready(function(){
	
    $('#form').validate();
	
 });
</script>

@stop