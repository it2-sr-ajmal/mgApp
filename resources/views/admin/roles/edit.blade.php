@extends('admin.layouts.master')
@section('styles')
@parent
<style>

</style>
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
                <h2 class="pageheader-title">Edit {{ $role->name }}
					<a class="float-sm-right" href="{{ apa('permissions') }}"><button class="btn btn-outline-dark btn-flat">Back</button></a></h2>
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
                
				{!! Form::open(array('url' => apa('roles/edit/'.$role->id) , 'id'=>'post-form')) !!}
                    <div class="card-body">
                        <div class="col-sm-12">
                            @include('admin.common.user_message')
                            <div class="clearfix"></div>
                            
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="banner_title" class="col-form-label">Role Name<em>*</em></label>
                                            <input id="banner_title" name="name" type="text" value="{{  $role->name }}" class="form-control" required>
                                        </div>
                                    </div>
 
                                </div>
                                <hr/>
								 
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
                                            <h3>Permissions</h3>
    										<div class="roles_box">
                                                @foreach ($permissions as $permission)
                                                <label class="custom-control custom-checkbox custom-control-inline">
                                                    <input type="checkbox" class="custom-control-input" name="permission[]" value="{{ $permission }}"  {{ (in_array($permission, $rolePermissions))?' checked="checked" ' : '' }}><span class="custom-control-label">{{ Form::label($permission, ucfirst($permission)) }}</span>
                                                </label>
                                                @endforeach
                                            </div>
										   <?php  /* <table class="table table-striped">
												   <thead>
													<tr>
														<th style="width: 10px;text-align:center">Select</th>
														<th>Permission Name</th>
													</tr> 
													
													</thead>
													<tbody>
													@foreach ($permissions as $permission)
														<tr>
															<td style="text-align:center"><input type="checkbox" name="permission[]" value="{{ $permission }}"  {{ (in_array($permission, $rolePermissions))?' checked="checked" ' : '' }} /></td>
															<td>{{ Form::label($permission, ucfirst($permission)) }}</td>
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
                                    <input class="btn btn-outline-primary" type="submit" name="" value="Save"  />
                                    <a href="{{ apa('roles') }}" class="btn btn-outline-danger">Close</a>
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
     $('#post-form').validate();

 });
</script>

@stop