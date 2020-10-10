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
@stop

@section('content')
	@section('bodyClass')
	@parent
		hold-transition skin-blue sidebar-mini
	@stop
	<div class="dashboard-wrapper">
        <!-- Main content -->
        <section class="container-fluid dashboard-content">
			<?php 
				if(!empty($userMessage)){
				echo $userMessage;
				} 
			?>
            <div class="pageNotFound">
                <h1>OOPsss... The requested resource was not found.</h1>
            </div>
	   </section>
    </div><!-- ./wrapper -->
@stop

@section('scripts')
@parent
@stop