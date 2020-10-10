@extends('admin.layouts.master')@section('metatags')	<meta name="description" content="{{{@$websiteSettings->site_meta_description}}}" />	<meta name="keywords" content="{{{@$websiteSettings->site_meta_keyword}}}" />	<meta name="author" content="{{{@$websiteSettings->site_meta_title}}}" />@stop@section('seoPageTitle') <title>{{{ $pageTitle }}}</title>@stop@section('styles')@parent	<style>        html,body {            height: 100%;        }        body {            display: -ms-flexbox;            display: flex;            -ms-flex-align: center;            align-items: center;            padding-top: 40px;            padding-bottom: 40px;        }    </style>@stop@section('content')@section('bodyClass')@parent  hold-transition login-page@stop <div class="splash-container">    <div class="card ">        <div class="card-header text-center"><a class="login-logo" href="{{ URL::to('/') }}"><img class="logo-img" src="{{ asset('assets/frontend/images/logo-invert.png') }}" alt="logo"></a><span class="splash-description">Please enter your user information.</span></div>        <div class="card-body">            <?php  if(!empty($userMessage)){ ?>                <div class="form-group user-message">                    <div class=""><?php  echo $userMessage; ?></div>                </div>            <?php } ?>                         {!! Form::open(['autocomplete'=>'new']) !!}                <div class="form-group">                    <input type="email" name="email_" class="form-control form-control-lg" placeholder="Email" autocomplete="new" required>                </div>                <div class="form-group">                    <input type="password" name="password_" class="form-control" placeholder="Password" autocomplete="new" required>                </div>                <button type="submit" class="btn btn-primary btn-lg btn-block">Sign in</button>                <input type="hidden" name="user_email" value="" />                <input type="hidden" name="password" value="" />                 {!! Form::close() !!}        </div>    </div> </div>@stop@section('scripts')@parent <script>	$(function(){		$('form').on('submit', function() {			$('[name="user_email"]').val($('[name="email_"]').val());			$('[name="email_"]').val('');			$('[name="password"]').val($('[name="password_"]').val());			$('[name="password_"]').val('');		  });			});</script>@stop