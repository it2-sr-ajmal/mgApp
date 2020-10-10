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
                <h2 class="pageheader-title">Edit {{ $user->name }}
					<a class="float-sm-right" href="{{ apa('admin_users') }}"><button class="btn btn-outline-dark btn-flat">Back</button></a>
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

                {{ Form::open(array('url' => apa('admin_users/update/'.$user->id) ,'files'=>true,'id'=>'form')) }}
		
                    <div class="card-body">
                        <div class="col-sm-12">
                            @include('admin.common.user_message')
                            <div class="clearfix"></div>
                            
                                 <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="name" class="col-form-label">Full Name[English]<em>*</em></label>
                                            <input id="name" name="name" type="text" value="{{ $user->user_full_name }}" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="phone" class="col-form-label">Phone<em>*</em></label>
                                            <input id="phone" name="user_phone_number" type="text" value="{{ $user->user_phone_number }}" class="form-control editorAr" required>
                                        </div>
                                    </div>
									<!-- <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="email" class="col-form-label">Email<em>*</em></label>
                                            <input disabled id="email" name="email" value="{{  $user->user_email }}" type="email" class="form-control" required>
                                        </div>
                                    </div> -->
                                 </div>
								 
								<!-- 
								 <div class="row">
                                    
									 <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="password" class="col-form-label">Password</label>
                                            <input id="password" name="password" type="password" value="" class="form-control editor">
                                        </div>
                                    </div> 
									
									
                                     
                                 </div>-->
                                 
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="status" class="col-form-label">Status</label>
                                            <select {{ $user->is_system_account == 1 ? 'disabled' : '' }} class="form-control" id="status" name="status">
                                                <option {{ ( $user->status == 1 ) ? 'selected =="selected"':"" }} value="1">Enable Account</option>
                                                <option {{ ( $user->status ==2) ? 'selected =="selected"':'' }} value="2">Disable Account</option>
                                            </select>
                                        </div>
                                    </div>
                                 </div>
								<hr/>
								<div class="row">   
									<div class="col-sm-12">
										<div class="form-group">
										<h3>Assign Role(s)</h3>

										<div class="roles_box">
											@foreach ($roles as $role)
											<label class="custom-control custom-checkbox custom-control-inline">
												<input type="checkbox" class="custom-control-input" data-id="{{ $role->name }}" name="roles[]" value="{{ $role->id}}"  {{ (in_array($role->id, $userRoleIDs))?' checked="checked" ':'' }} required><span class="custom-control-label">{{ Form::label($role->name, ucfirst($role->name)) }}</span>
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
												@foreach ($roles as $role)
													<tr>
														<td style="text-align:center">
															<input type="checkbox" data-id="{{ $role->name }}" name="roles[]" value="{{ $role->id}}"  {{ (in_array($role->id, $userRoleIDs))?' checked="checked" ':'' }} required/>
														</td>
														<td>{{ Form::label($role->name, ucfirst($role->name)) }}</td>
													</tr>
												@endforeach
											</tbody>
										</table> */ ?>
										</div>
									</div>     
								</div>
								
								<?php 
									/*$allottedHubsIds = [];
									if(!empty($user->UserAllottedHubs) && $user->UserAllottedHubs->count() > 0 ){
										foreach($user->UserAllottedHubs as $userHub) {
											$allottedHubsIds[] = $userHub->uah_hub_id;
										}
									}*/
								?>
								 <!-- <div class="row" id="hub-div"  style="{{ (!$user->hasRole('Manage Hubs')) ? 'display:none;' : '' }}" >
								   <div class="col-sm-12">
										<select name="allotted_hubs[]" id="allotted_hubs" class="form-control" placeholder="" multiple="multiple">
										
											@if(!empty($hubList))
												@foreach($hubList as $hub)
												 <option  {{(in_array($hub->hub_id, $allottedHubsIds)) ? 'selected':'' }} value="{{ $hub->hub_id }}">{{ $hub->hub_title }}</option>
												@endforeach
											@endif
										</select>
								  </div>
								</div>
								
								<div class="row">
									<div class="col-sm-12">
									<hr/>
									</div>
								</div> -->
								 
								 <!-- <div class="row">
									<div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="current_admin_pass" class="col-form-label">Current Admin Password<em>*</em></label>
                                            <input id="current_admin_pass" name="current_admin_pass" type="password" value="" class="form-control" required>
                                        </div>
                                    </div>
								</div> -->
                        </div>
                    </div>
					
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="button-control-wrapper">
                                <div class="form-group">
                                    <input class="btn btn-outline-primary" type="submit" name="updatebtnsubmit" value="Save"  />
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
	$('#allotted_hubs').multiSelect({
		selectableHeader: "<div class='custom-header'>Select from Hub List</div>",
		selectionHeader: "<div class='custom-header'>Selected Hub(s)</div>",
	});
    $('#form').validate();
	$('input[data-id="Manage Hubs"]').on('change', function(){
		$('#hub-div').hide('slow');
		$('#hub-div').find('select').attr('required',false);
		if($(this).is(':checked')){
			$('#hub-div').show('slow');
			$('#hub-div').find('select').attr('required',true);
		}
	})
 });
</script>

@stop