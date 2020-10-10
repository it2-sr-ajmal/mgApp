@extends('admin.layouts.master')
@section('styles')
@parent
{{ Html::style('assets/admin/vendor/daterangepicker/daterangepicker.css') }}
{{ Html::style('assets/admin/vendor/tagit/css/jquery.tagit.css') }}
{{ Html::style('assets/admin/vendor/tagsinput/bootstrap-tagsinput.css') }}
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
                <h2 class="pageheader-title">About Us</h2>
            </div>
        </div>
    </div> 
    {{ Form::open(array('url' => array(apa('post/'.$postType.'/edit/'.$postDetails->getData('post_id'))),'files'=>true,'id'=>'add-form')) }}
    <input type="hidden" name="post[type]" value="{{$postType}}" />		
    <div class="row">
        <div class="col-sm-12">
            @include('admin.common.user_message')
        </div>
        <!-- ============================================================== -->
        <!-- striped table -->
        <!-- ============================================================== -->
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">

                    <section class="basic_settings">

                        <div class="row"> 	
                            <div class="col-sm-12 form-group">
                                <label>Title</label>
                                <input type="text" name="post[title]" id="post_title" class="form-control" placeholder="" value="{{ $postDetails->getData('post_title') }}"  />
                            </div>	

                        </div>
                        <div class="row"> 	
                            <div class="col-sm-12 form-group">
                                <label>Excerpt</label>
                                <textarea id="description" name="meta[text][excerpt]" type="text"  class="form-control ckeditorEn" >{{ $postDetails->getData('excerpt') }}</textarea>
                            </div>	

                        </div>
                        <div class="row"> 	
                            <div class="col-sm-6 form-group">
                                {!! getSinglePlUploadControl('Upload Banner Image (Max 2 MB) (jpg,jpeg) ','aboutus_banner',['jpg','jpeg'],'image','Select File',null,null,@$postDetails->getData('aboutus_banner'),$postType) !!}
                            </div>
                        </div>
                    </section>	
                    <hr/>
                    <section class="basic_settings">

                        <div class="row"> 	
                            <div class="col-sm-12 form-group">
                                <label>Objective Title</label>
                                <input type="text" name="meta[text][obj_title]" id="obj_title" class="form-control" placeholder="" value="{{ $postDetails->getData('obj_title') }}"  />
                            </div>
                        </div>
                        <div class="row"> 	

                            <div class="col-sm-12 form-group">
                                <label>Objective Description</label>
                                <textarea name="meta[text][obj_description]" class="form-control ckeditorEn" id="obj_description" placeholder="" >{{ $postDetails->getData('obj_description') }}</textarea> 
                            </div>

                        </div>
                       <?php /* <div class="row"> 	
                            <div class="col-sm-6 form-group">
                                {!! getSinglePlUploadControl('Upload Objective Image (Max 2 MB) (jpg,jpeg,svg) ','obj_image',['jpg','jpeg','svg'],'image','Select File',null,null,@$postDetails->getData('obj_image'),$postType) !!}
                            </div>
                        </div>	 */	?>						
                    </section>
                    <hr/>
                    <section class="basic_settings">

                        <div class="row"> 	

                            <div class="col-sm-6 form-group">
                                <label>Vision</label>
                                <textarea name="meta[text][vision]" class="form-control ckeditorEn" id="vision" placeholder="" >{{ $postDetails->getData('vision') }}</textarea> 
                            </div>
                            <div class="col-sm-6 form-group">
                                <label>Mission</label>
                                <textarea name="meta[text][mission]" class="form-control ckeditorEn" id="mission" placeholder="" >{{ $postDetails->getData('mission') }}</textarea> 
                            </div>
                        </div>	
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label>Values</label>
                                <textarea name="meta[text][values]" class="form-control ckeditorEn" id="values" placeholder="" >{{ $postDetails->getData('values') }}</textarea> 
                            </div>
                        </div>
                    </section>
                    <hr/>
                    <section class="basic_settings">

                        <div class="row"> 	
                            <div class="col-sm-12 form-group">
                                <label>Why Farms Gate Title</label>
                                <input type="text" name="meta[text][why_farms_gate_title]" id="why_farms_gate_title" class="form-control" placeholder="" value="{{ $postDetails->getData('why_farms_gate_title') }}"  />
                            </div>	
                        </div>	
                        <div class="row"> 
                            <div class="col-sm-12 form-group">
                                <label>Why Farms Gate Description</label>
                                <textarea name="meta[text][why_farms_gate_description]" class="form-control ckeditorEn" id="why_farms_gate_description" placeholder="" >{{ $postDetails->getData('why_farms_gate_description') }}</textarea> 
                            </div>

                        </div>	
                        <div class="row"> 	
                            <div class="col-sm-6 form-group">
                                {!! getSinglePlUploadControl('Upload Farmsgate Image (Max 2 MB) (jpg,jpeg,png) ','why_farms_gate_image',['jpg','jpeg','png'],'image','Select File',null,null,@$postDetails->getData('why_farms_gate_image'),$postType) !!}
                            </div>
                        </div>								
                    </section>

                </div>
            </div>
        </div>


        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="post_status" class="col-form-label">Display Priority</label>
                                <input type="number" min="1" name="post[priority]" id="post_priority"  class="form-control" placeholder="" value="{{ $postDetails->getData('post_priority')  }}"  />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="post_status" class="col-form-label">Status</label>
                                <select class="form-control" id="post_status" name="post[status]">
                                    <option <?php echo ( $postDetails->getData('post_status') == 1 ) ? 'selected =="selected"' : ""; ?> value="1">Publish</option>
                                    <option <?php echo ( $postDetails->getData('post_status') == 2 ) ? 'selected =="selected"' : ''; ?> value="2">Unpublish</option>
                                </select>
                            </div>
                        </div>	 
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="button-control-wrapper">
                                <div class="form-group">
                                    <input class="btn btn-outline-primary" type="submit" name="updatebtnsubmit" value="Save"  />
                                    <a href="{{ route('post_index',$postType) }}" class="btn btn-outline-danger">Close</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}
</div>
@stop

@section('scripts') 
@parent
<?php /* <script src="{{  asset('assets/admin/vendor/tagit/js/tag-it.min.js') }}" type="text/javascript"></script> */ ?>
<script src="{{  asset('assets/admin/vendor/tagsinput/bootstrap-tagsinput.min.js') }}" type="text/javascript"></script>
<script src="{{  asset('assets/editor/full/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
<script>

$(document).ready(function () {
    PGSADMIN.utils.createEnglishArticleEditor();
    PGSADMIN.utils.createArabicArticleEditor();
    PGSADMIN.utils.createMediaUploader("{{ route('post_media_create',['slug'=>$postType]) }}", "#galleryWrapper", "{{ apa('post_media_download') }}/", "{{ asset('storage/post') }}/");
    PGSADMIN.utils.createAjaxFileUploader("{{ route('post_media_create',['slug'=>$postType]) }}", "{{ apa('post_media_download') }}/", "{{ asset('storage//post/') }}/");

    PGSADMIN.utils.youtubeVideoThumbUploader('changeImage', "{{ route('post_media_create',['slug'=>$postType]) }}", "{{ asset('storage/post/') }}/", "#galleryWrapper");

    $('#post_tags').tagsinput({
        confirmKeys: [13, 188]
    });

    $('body').on('keydown', '.bootstrap-tagsinput input', function (e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 9 || keyCode === 13) {
            e.preventDefault();
            $("#post_tags").tagsinput('add', $(this).val());
            $(this).val('');
            return false;
        }
    });

});
</script>
@stop