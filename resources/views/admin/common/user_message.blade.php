
@if(!empty($userMessage))
	
    <div class="message-wrapper">
        {!! $userMessage !!}
    </div>
@endif
@if(!empty($errors) && $errors->count() > 0)
	<ul class="alert alert-danger">
	@foreach($errors->all() as $key => $error)
		<li style="list-style:none;"> {{ $error }}</li>
	@endforeach
	</ul>
@endif
<div class="clearfix"></div>