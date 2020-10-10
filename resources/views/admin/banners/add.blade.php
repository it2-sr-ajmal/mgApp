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
                <h2 class="pageheader-title">Add Banner
                    <?php /* <a class="float-sm-right" href="{{ apa('') }}"><button class="btn btn-outline-dark btn-flat">Back To List</button></a></h2> */ ?>
            </div>
        </div>
    </div>  
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="col-sm-12 card-header form-header">
                    <div class="row align-items-center">
                        <h5>Fields marked (<em>*</em>) Are mandatory</h5> 
                    </div>
                </div>

                {{ Form::open(array('url' => route('post_create',$postType),'files'=>true,'id'=>'post-form')) }}
                <input type="hidden" name="post[type]" value="{{$postType}}" />		
                <div class="card-body">
                    <div class="col-sm-12">
                        @include('admin.common.user_message')
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="title" class="col-form-label">Title<em>*</em></label>
                                    <input id="title" name="post[title]" type="text" value="{{ request()->old('post[title"]') }}" class="form-control" required>
                                    
                                    <input name="post[title_arabic]" type="hidden" value="unused">        
                                </div>
                            </div>
                            
                        </div>
                        <?php /* */ ?> 




                          <div class="row">
                          <div class="col-sm-6  fl fl-wrap fileUploadWrapper form-group">
                          {!! getSinglePlUploadControl('Upload Main Image  (Max 2 MB)  (jpg,jpeg) ','banner_image',['jpg','jpeg'],'image','Select File',null,null,@request()->old('meta["text"]["banner_image"]'),$postType,1700,910) !!}
                          </div>
						  <div class="col-sm-6  fl fl-wrap fileUploadWrapper form-group">
                             {!! getSinglePlUploadControl('Upload Main Image  (Max 2 MB)  (jpg,jpeg) ','banner_image_mob',['jpg','jpeg'],'image','Select File',null,null,@request()->old('meta["text"]["banner_image_mob"]'),$postType,1487,923) !!}
                          </div>

                        

                          </div> 
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="post_priority" class="col-form-label">Priority</label>
                                    <input id="post_priority"  name="post[priority]" value="{{ request()->old('post["priority"]') }}" type="number" class="form-control hostBtnInputs" >
                                </div>
                            </div> 
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="post_status" class="col-form-label">Status</label>
                                    <select class="form-control" id="post_status" name="post[status]">
                                        <option <?php echo ( @request()->old('post["status"]') == 1 ) ? 'selected =="selected"' : ""; ?> value="1">Enable</option>
                                        <option <?php echo ( @request()->old('post["status"]') == 2 ) ? 'selected =="selected"' : ''; ?> value="2">Disable</option>
                                    </select>
                                </div>
                            </div>	 
                        </div>
                    </div>
                </div>
                <div id="galleryWrapper" class="myFileLister"></div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="button-control-wrapper">
                            <div class="form-group">
                                <input class="btn btn-outline-primary" type="submit" name="btnsubmit" value="Save"  />
                                <a href="{{ route('post_index',$postType) }}" class="btn btn-outline-danger">Close</a>
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
    $(document).ready(function () {
        PGSADMIN.utils.createAjaxFileUploader("{{ route('post_media_create',['slug'=>'banners'])}}","{{ apa('post_media_download') }}/", "{{ asset('storage/post') }}/");
        //createAjaxMultiFileUploader("{{ route('post_media_create',['slug'=>'banners'])}}","#galleryWrapper");
        $('#post-form').validate();
    });
</script>

@stop