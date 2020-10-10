<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
	<meta charset="utf-8"><meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta name="robots" content="index, follow">
	<meta name="baseurl" content="<?php echo URL::to('/') ?>" />
	<meta name="device" content="<?php echo (Agent::isMobile() === true) ? 'true' : 'false'; ?>" />
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<link rel="apple-touch-icon" href="apple-touch-icon.png">
	@section('metatags')
	<meta name="title" content="{{ @$websiteSettings->site_meta_title }}" />
	<meta name="description" content="{{ @$websiteSettings->site_meta_description }}" />
	<meta name="keywords" content="{{ @$websiteSettings->site_meta_keyword }}" />
	@show
	@section('seoPageTitle')
	<title>{{ ($pageTitle) ? ucwords(str_replace('_',' ',$pageTitle)) : $websiteSettings->sitename}}</title>
	@show
	<link rel="shortcut icon" href="{{ asset('assets/frontend/dist/images/favicon.png') }}">
	<!-- Scripts -->
	<script>
		window.Laravel = {!! json_encode([
			'csrfToken' => csrf_token(),
		]) !!};
		window.baseURL = "{{ URL::to('/') }}/";
		window.adminPrefix = "{{ Config::get('app.admin_prefix') }}/";
		window.appTrans = {
				invalidFile : " {{ Lang::get('messages.invalid_file') }} ",
				error : "{{Lang::get('messages.error')}}",
				ok : "{{Lang::get('messages.ok')}}",
				areYouSure : "{{Lang::get('messages.are_you_sure')}}",
				cannotRevert : "{{Lang::get('messages.cannot_revert')}}",
				yes : "{{Lang::get('messages.yes')}}",
		};
		window.siteKey = '{{ @$websiteSettings->googleCaptchaSiteKey}}';
        window.apiToken = "{{session('ApiToken')}}";
        window.googleKey = "{{config('app.googleKey')}}";
		@if(\Auth::user())
			window.postMediaDelURL = "{{ apa('post_media/delete') }}/";
                        window.basePath = '{{ asset("storage/app/post/uploads") }}/';
			window.downloadPath = '{{ apa("post_media_download") }}/';
		@endif
	</script>
	@section('styles')
	@include('admin.layouts.cssfiles')
	<style>

		input[type="file"] {
			//opacity: 1 !important;
		}

		.logoWrapper {
			background: #fff;
			text-align: center;
			padding: 17px;
		}
		@if(!empty($hideGalleryText))
		#galleryWrapper .titleTextDiv{
			display:none;
		}
		.YoutubeUploadWrapper .titleTextDiv{
			display:none;
		}
		@endif
		@if(!empty($hideGallerySource))
		#galleryWrapper .sourceTextDiv{
			display:none;
		}
		.YoutubeUploadWrapper .sourceTextDiv{
			display:none;
		}
		@endif
		@if(!empty($hideGalleryLang))
		#galleryWrapper .langTextDiv{
			display:none;
		}
		@endif
	</style>
	@show
</head>
<body >
	@if(Auth::user() && Auth::user()->is_admin == 1)
	<div class="dashboard-main-wrapper">
		@endif
		@include('admin.common.header')

		@if(Auth::user() && Auth::user()->is_admin == 1)
		@include('admin.common.leftmenu')
		@endif

		@if(Auth::user() && Auth::user()->is_admin == 1)
		<div class="dashboard-wrapper">
			@endif
			@yield('content')

			@if(Auth::user() && Auth::user()->is_admin == 1)
			@include('admin.layouts.footer')
			@endif
			@if(Auth::user() && Auth::user()->is_admin == 1)
		</div>
		@endif
		@if(Auth::user() && Auth::user()->is_admin == 1)
	</div>
	@endif
	@section('scripts')
		@include('admin.layouts.jsfiles')
	@show
</body>
</html>