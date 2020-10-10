<div class="row">
	<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
		<div class="card">
			<div class="card-header">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="section-block">
						<h3 class="section-title">Upload Images</h3>
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						<section class="basic_settings" id="postMediaWrapper">
							<div class="row"> 
								<div class="col-sm-12  fl fl-wrap fileUploadWrapper form-group">
									{!! getMultiPlUploadControl('Upload Gallery Image(s) (1200x800) (Max 2 MB)  (jpg,jpeg) ','gallery',['jpg','jpeg'],'image','Select File',null,null,@Input::old('meta')['text']['gallery'],@$postType,1487,923) !!}
								</div>
							</div>								
						</section>
					</div>
				</div>
			</div>
			<div class="card-footer  p-0 text-center d-flex justify-content-center">
				<p>Files will be automatically uploaded. Can select multiple files</p>
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