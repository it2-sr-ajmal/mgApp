
<div class="row">
	<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">

		<div class="card">
			<div class="card-header">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="section-block">
						<h3 class="section-title">Upload Youtube Video</h3>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
						<label>Language</label>
						<select class="form-control ytInput" id="videoLang" name="videoLang">
							<option value="">In Both</option>
							<option value="ar">Arabic</option>
							<option value="en">English</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
						<label>Video Title</label>
						<input type="text" class="form-control ytInput" name="videoTitle" placeholder="English title here" id="videoTitle" /> 
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
						<label>Video Title [Arabic]</label>
						<input type="text" dir="rtl" class="form-control ytInput" name="videoTitleAr"  placeholder="English title here"  id="videoTitleAr" /> 
					</div>
				</div>
				<div class="row">
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
						<label>Video Source</label>
						<input type="text" class="form-control ytInput" name="videoSource"  placeholder="English video source here"  id="videoSource" /> 
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
						<label>Video Source [Arabic]</label>
						<input type="text" dir="rtl" class="form-control ytInput" name="videoSourceAr"  placeholder="Arabic video source here"  id="videoSourceAr" /> 
					</div>
				</div>
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						<div class="ythumbWrapper">
							<img src="{{ asset('assets/admin/images/def-youtube-thumb.png') }}" id="youtube_thumb" class="youtube_thumb"/>
						</div>
						<input type="text" class="form-control ytInput" name="youtubeURL"  placeholder="Youtube URL here"  id="youtubeURL" /> 
						<input type="hidden" class="form-control ytInput" name="customImage"  id="customImage" /> 
					</div>
				</div>
			</div>
			<div class="card-footer  p-0 text-center d-flex justify-content-center">
				<div class="card-footer-item card-footer-item-bordered" id="chCoverWrapper">
					<?php /*<input id="changeImage" type="file" class="form-control" data-slug="yt_thumb" data-allowed="jpg,jpeg" data-type="image" title="" id="gallery_file" name="gallery_file" style="position: relative; z-index: 1;"> */ ?>

					<div id="ytThumb" class = "uploadControlWrapper">
						<a id="changeImage" class="card-link" >Change Cover Image</a>
						<div class = "uploadPercentage"></div>
						<div class = "uploadProgressWrapper">
							<div class = "uploadProgress" ></div>
						</div>
					</div>

				</div>
				<div class=" card-footer-item-bordered col-6" id="saveWrapper">

					<a id="saveYoutube" data-resultDiv="{{ (!empty($galleryLister))?$galleryLister:'galleryWrapper' }}" href="#" class="card-link col-12 card-footer-item">Save</a>
				</div>
			</div>
		</div>

	</div>
</div>


<div class="row">
	<ul id="{{ (!empty($galleryLister))?$galleryLister:'galleryWrapper' }}" class="myFileLister">
		@if(!empty($postDetails))
			@if(isset($postDetails->media))				
				@foreach($postDetails->media as $media)
				{!! showMediaItem($media) !!}
				@endforeach
			@endif
		@endif
	</ul>
</div>
@section('scripts') 
@parent
	@include('admin.common.common_gallery_scripts')
@stop