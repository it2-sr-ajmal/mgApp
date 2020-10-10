<script>
function get_Image_gallery(imageID){

$('#old_gallery').html('');	
    $('#loader').show();
$.ajax({
        url:'<?php echo URL::to(Config::get('app.admin_prefix').'/multiple-upload/get_old_files'); ?>?slug='+imageID,
        type:'get',
        async:false,
        data:{categoryID:$('#categoryID option:selected').val()},
        dataType:'json',
        statusCode: {
            302:function(){ alert('Forbidden. Access Restricted'); 	$('#loader').hide();},
            403:function(){ alert('Forbidden. Access Restricted','403'); 	$('#loader').hide();},
            404:function(){ alert('Page not found','404'); 	$('#loader').hide();},
            500:function(){ alert('Internal Server Error','500'); 	$('#loader').hide();}
        }
    }).done(function(responseData){
            if(responseData.status==true){
                
                var images = responseData.gallery;
                // console.log(images.length)
                if(images.length==0){
                    $('#no-image').html('No Images found!');
                }
                
                for(var kk=0,ll=images.length;kk<ll;kk++){
                    var domOld='';
                    domOld+='<div class="col-sm-3">'
                        domOld+='<div class="imageHolder">'
                            domOld+='<img width="100px" src="<?php echo asset('storage/app/public/uploads/'.$module.'/multi_image_gallery')?>/'+images[kk].gallery_image_name+'"/>'
                            domOld+='<a class="downImg" href="<?php echo asset('storage/app/public/uploads/'.$module.'/multi_image_gallery')?>/'+images[kk].gallery_image_name+'"><i class="fa fa-download"></i></a>'
                            domOld+='&nbsp;&nbsp;<a href="#" class="fa fa-remove delGalImg" data-id="'+images[kk].gallery_id+'"></a>'
                            /*domOld+='<div class="col-sm-12">'
                                domOld+='<div class="col-sm-6">'
                                    domOld+='<input name="priority_'+kk+'" type="text" value="'+images[kk]+.gallery_priority'" class="form-control priority_field" >'
                                domOld+='</div>'
                                domOld+='<div class="col-sm-6">'
                                    domOld+='<input type="button" name="btn" class="btn updatePriority" data-priority="" value="save">'
                                domOld+='</div>'
                            domOld+='</div>' */
                        domOld+='</div>'
                    domOld+='</div>'
                        $('#old_gallery').append(domOld);
                }
            }	
            $('#loader').hide();				
    }).error(function(jqXHR,textStatus){
            t = false;
                $('#loader').hide();
    });
}

function delete_gallery_image(id,elem){
$.ajax({
        url:'<?php echo URL::to(Config::get('app.admin_prefix').'/multiple-upload/delete/'); ?>/'+id,
        type:'get',
        async:false,
        data:{},
        dataType:'json',
        statusCode: {
            302:function(){ alert('Forbidden. Access Restricted'); },
            403:function(){ alert('Forbidden. Access Restricted','403'); },
            404:function(){ alert('Page not found','404'); },
            500:function(){ alert('Internal Server Error','500'); }
        }
    }).done(function(responseData){
            if(responseData.status==true){
                var el=  elem.closest('.imageHolder');
                el.parent().remove();
            }				
    }).error(function(jqXHR,textStatus){
            t = false;
    });
}

$(document).ready(function(){
    
get_Image_gallery('{{ $slug }}');

		$('#old_gallery').on('click','.updatePriority',function(e){
				e.preventDefault();

		})

		$('#old_gallery').on('click','.delGalImg',function(e){
					e.preventDefault();
					if(confirm('Are you sure you want to delete?')==true){
							delete_gallery_image($(this).attr('data-id'),$(this));
					}
				});

		var uploader = new plupload.Uploader({
			runtimes : 'html5,flash,silverlight,html4',
			browse_button : 'browse', // you can pass in id...
			//container: document.getElementById('container'), // ... or DOM Element itself
			url : '{{ URL::to(Config::get("app.admin_prefix")."/multiple-upload") }}',
			flash_swf_url : '<?php echo asset('assets/admin/js/fu/Moxie.swf')?>',
			silverlight_xap_url :  '<?php echo asset('assets/admin/js/fu/Moxie.xap')?>',
			
			filters : {
				max_file_size : '10mb',
				mime_types: [
					{title : "Image files", extensions : "jpg,gif,png"},
				]
			},
			multipart_params : {
					"slug" : '{{ $slug }}',
					"module" : '{{ $module }}',
					<?php if($multi_gallery_resize ) {?>
						"width" : "{{$multi_gallery_resize[0]['width']}}",
						"height" : "{{$multi_gallery_resize[0]['height']}}",
						"folder" : "{{$multi_gallery_resize[0]['folder']}}",
					<?php } ?>
				},
			headers: { 'X-CSRF-TOKEN': window.Laravel.csrfToken },
			init: {
				PostInit: function() {
					// document.getElementById('filelist').innerHTML = '';

					document.getElementById('startupload').onclick = function() {
						uploader.start();
						return false;
					};
					
					
				},
				BeforeUpload:function (up,files){
						var status_before = files.status;
						$('#loader').show();
					uploader.settings.url = '{{ asset(Config::get("app.admin_prefix")."/multiple-upload") }}';	

				},										
				FilesAdded: function(up, files) {

				},

				UploadProgress: function(up, file) {
					console.log(file);
				},
				FileUploaded:function(up,file,response){

					console.log(response.response)
					var t = response.response;
					if(t){
						console.log(t);
						var rt  = $.parseJSON(t);
						console.log(rt);
						rt = rt.uploadDetails;
						if(rt.status == true ){
								$('#no-image').hide();
								// $('#old_gallery').append('<div class="col-sm-3"><div class="imageHolder"><h3>'+rt.category_name+'</h3><img src="<?php echo asset('storage/app/public/uploads/'.$module.'/multi_image_gallery' )?>/'+rt.fileName+'"/><a class="downImg" href="<?php echo asset('admin/image-gallery/download/')?>'+rt.fileName+'"><i class="fa fa-download"></i></a> <span class="delGalImg" data-id="'+rt.id+'"></span></div></div>');
								$('#old_gallery').prepend('<div class="col-sm-3"><div class="imageHolder"><img width="100px" src="<?php echo asset('storage/app/public/uploads/'.$module.'/multi_image_gallery' ) ?>/'+rt.fileName+'"/><a class="downImg" href="<?php echo URL::to(Config::get('app.admin_prefix').'cms/multiple-upload/download/')?>'+rt.fileName+'"><i class="fa fa-download"></i></a> <a href="#" class="fa fa-remove delGalImg" data-id="'+rt.id+'"></a></div></div>');
						}
					}
				},
				UploadComplete:function(up,files){
					$('#loader').hide();
				},
				Error: function(up, err) {
					console.log("\nError #" + err.code + ": " + err.message);
				}
			}
		});

		uploader.init();
    })

</script>