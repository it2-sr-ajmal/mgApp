@extends('admin.layouts.master')
@section('metatags')
<meta name="description" content="{{{@$websiteSettings->site_meta_description}}}" />
<meta name="keywords" content="{{{@$websiteSettings->site_meta_keyword}}}" />
<meta name="author" content="{{{@$websiteSettings->site_meta_title}}}" />

@stop
@section('seoPageTitle')
<title>{{{ $pageTitle }}}</title>
@stop
@section('styles')
@parent
<style>
	#view-selector-container {
		display: none;
	}

	.anchorWhite {
		color: #fff !important;
	}

	.anchorWhite:hover {
		color: #00000057 !important;
	}
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
				<h2 class="pageheader-title">{{ $pageTitle }} </h2>
			</div>
			@if(!empty($userMessage))
			<div class="alert alert-info" role="alert">{!! $userMessage!!} </div>
			@endif
		</div>
	</div>
	<!-- <div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="card">
				<h5 class="card-header">User Statistics</h5>
				<div class="card-body">
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
						<div class="card">
							<h5 class="card-header">Registrations By Year</h5>
							<div class="card-body">
								content here
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div> -->
	<div class="row">
		<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
			<div class="card border-3 border-top border-top-primary">
				<div class="card-body">
				    <a href="{{apa('farm-manager')}}">
						<div class="d-inline-block">
						<h5 class="text-muted">Total Farms</h5>
						<h2 class="mb-0"> {{$farms_count}}</h2>
						</div>
						<div class="float-right icon-circle-medium  icon-box-lg  bg-secondary-light mt-1">
						<i class="fa fa-handshake fa-fw fa-sm text-secondary"></i>
						</div>
					</a>
				</div>
			</div>
		</div>
		<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
			<div class="card border-3 border-top border-top-primary">
				<div class="card-body">
				    <a href="{{apa('farm-manager?status=1')}}">
						<div class="d-inline-block">
						<h5 class="text-muted">Approved Farms </h5>
						<h2 class="mb-0"> {{ @$approved_farm_count}}</h2>
						</div>
						<div class="float-right icon-circle-medium  icon-box-lg  bg-secondary-light mt-1">
						<i class="fa fa-shopping-bag fa-fw fa-sm text-secondary"></i>
						</div>
					</a>
				</div>
			</div>			
		</div>
		<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
			<div class="card border-3 border-top border-top-primary">
				<div class="card-body">
				    <a href="{{apa('farm-manager?status=2&listing-completed=1')}}">
						<div class="d-inline-block">
						<h5 class="text-muted">Farms waiting Approval</h5>
						<h2 class="mb-0"> {{ @$pending_for_approval_count}}</h2>
						</div>
						<div class="float-right icon-circle-medium  icon-box-lg  bg-secondary-light mt-1">
						<i class="fa fa-home fa-fw fa-sm text-secondary"></i>
						</div>
					</a>
				</div>
			</div>			
		</div>
		
		<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
			<div class="card border-3 border-top border-top-primary">
				<div class="card-body">
				   <a href="{{apa('users')}}">
						<div class="d-inline-block">
						<h5 class="text-muted">Users</h5>
						<h2 class="mb-0"> {{ @$users_count}}</h2>
						</div>
						<div class="float-right icon-circle-medium  icon-box-lg  bg-primary-light mt-1">
						<i class="fa fa-user fa-fw fa-sm text-primary"></i>
						</div>
					</a>
				</div>
			</div>
		</div>
		<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
			<div class="card border-3 border-top border-top-primary">
				<div class="card-body">
				   <a href="{{apa('order-list')}}">
						<div class="d-inline-block">
						<h5 class="text-muted">Total Orders</h5>
						<h2 class="mb-0"> {{ @$order_count}}</h2>
						</div>
						<div class="float-right icon-circle-medium  icon-box-lg  bg-primary-light mt-1">
						<i class="fa fa-user fa-fw fa-sm text-primary"></i>
						</div>
					</a>
				</div>
			</div>
		</div>
		<?php /* <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
			<div class="card border-3 border-top border-top-primary">
				<div class="card-body">
				   <a href="{{apa('notify-request')}}">
						<div class="d-inline-block">
						<h5 class="text-muted">New Notify Request(s)</h5>
						<h2 class="mb-0"> {{ @$notify_count}}</h2>
						</div>
						<div class="float-right icon-circle-medium  icon-box-lg  bg-primary-light mt-1">
                            <p style="color:#000">since last login</p>
						</div>
					</a>
				</div>
			</div>
		</div> */ ?>
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
			<div class="card border-3 border-top border-top-primary">
				<div class="card-body">
				   <a href="{{apa('contact-request')}}">
						<div class="d-inline-block">
						<h5 class="text-muted">New Contact Request(s)</h5>
						<h2 class="mb-0"> {{ @$contact_count}}</h2>
						</div>
						<div class="float-right icon-circle-medium  icon-box-lg  bg-primary-light mt-1">
                            <p style="color:#000">since last login</p>
						</div>
					</a>
				</div>
			</div>
		</div>
        
	</div>
	@if(Auth::user() && Auth::user()->hasAnyPermission(['Manage Notifications']))
	<div class="row">
			<div class="col-12 col-xl-12 mb-12">
				<div class="card crystal-border-light crystal-shadow">
					<div class="card-header d-flex">
						<h4 class="card-header-title">Recent Activities</h4>
						<div class="toolbar ml-auto">
							<a href="{{apa('user-notification')}}" class=" btn btn-outline-primary btn-sm ">View All</a>
						</div>
					</div>
					<div class="card-body">
						<!-- <h6 class="heading-title pl-3 position-relative">Recent Activities  <a href="" class="btn btn-outline-secondary pull-right"></a></h6> -->
						@foreach($userNotifications as $notification)
						<div class="media d-sm-flex d-block text-center text-sm-left mb-4">
							<div class="d-sm-flex mr-sm-2 mb-3 mb-sm-0"><img class="user-avatar-md rounded-circle" src="{{ get_profile_image($notification->fromuserDetails->user_avatar) }}"></div>
							<div class="media-body crystal-line-height-1">
								<h6 class="mb-0 font-weight-normal"><strong>{{$notification->fromuserDetails->user_full_name}} : </strong>{!!$notification->un_description!!}</h6>
								<small>{{$notification->getTimedate()}}</small>
							</div>
						</div>
						@endforeach
						
					</div>
					
				</div>
				
			</div>
      </div>
	  @endif
</div>

@stop

@section('scripts')
@parent

@stop