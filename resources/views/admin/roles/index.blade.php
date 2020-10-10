@extends('admin.layouts.master')
@section('content')
@section('bodyClass')
@parent 
hold-transition skin-blue sidebar-mini
@stop
<div class="container-fluid dashboard-content">
	<div class="row">

		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="card">
				<div class="card-header d-flex">
					<h3 class="card-header-title">User Roles</h3>
					<a href="{{ apa('roles/create') }}" class="btn btn-outline-success ml-auto">Create New</a>
				</div>
				
				<div class="card-body border-bottom" style="{{(empty($userMessage)) ? 'display: none' : ''}}">						
					@include('admin.common.user_message')			
				</div>
				<div class="card-body ">
					<h4>{{ $roles->count() }} results found.</h4>
					<div class="table-responsive ">
						<table class="table table-bordered ">
							<thead>
								<tr>
									<th scope="col" width="50px"  class="text-center">#</th>									
									<th scope="col" style="width: 70%;">Role Name</th>															
									<th scope="col" class="text-center">Option</th>									
								</tr>
							</thead>
							<tbody>
								@if (count($roles) > 0)
								<?php $inc = getPaginationSerial($roles); 	?>
								@foreach ($roles as $permission)
									<tr data-entry-id="{{ $permission->id }}">
										<td class="text-center">{{ $inc++ }}</td>
										<td>{{ $permission->name }}</td>
										
										<td class="text-center">
											<a href="{{ apa('roles/edit/'.$permission->id) }}" class="btn btn-outline-success btn-sm">Edit</a>	
											<a data-id="{{ $permission->id }}" href="{{ apa('roles/delete/'.$permission->id) }}" class="deleteRecord btn btn-outline-danger btn-sm">Remove</a>	
										</td>										
									</tr>
									@endforeach
								@else
									<tr>
										<td colspan="3">@lang('global.app_no_entries_in_table')</td>
									</tr>
								@endif
									
							</tbody>
						</table>
					</div>

				</div>
			</div>
		</div>

	</div> 
	
	<?php /*<div class="row">
		<div class="col-sm-12">
			@include('admin.common.user_message')
		</div>
		
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="card">
				<div class="col-sm-12 card-header my-table-header">
					<div class="row align-items-center">
						<div class="col-sm-6"><h5 class="">{{ $roles->count() }} results found.</h5></div>						
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive-md">
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									
									<th scope="col">#</th>
									
									<th scope="col">Role Name</th>
									
									<th scope="col">Option</th>
									
									
								</tr>
							</thead>
							<tbody>
								@if (count($roles) > 0)
								<?php $inc = getPaginationSerial($roles); 	?>
								@foreach ($roles as $permission)
								<tr data-entry-id="{{ $permission->id }}">
									<td>{{ $inc++ }}</td>
									<td>{{ $permission->name }}</td>
									<td>
										<a href="{{ apa('roles/edit/'.$permission->id) }}" class="btn btn-xs btn-info">Edit</a>
										<a data-id="{{ $permission->id }}" href="{{ apa('roles/delete/'.$permission->id) }}" class="deleteRecord btn btn-xs btn-danger">Delete</a>
										
									</td>
									
								</tr>
								@endforeach
								@else
								<tr>
									<td colspan="3">@lang('global.app_no_entries_in_table')</td>
								</tr>
								@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div> */ ?>
</div>
@stop