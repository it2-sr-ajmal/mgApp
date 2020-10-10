<script>
var uploaders = []
var count =1,total;

function createAjaxFileUploader(URL){
    $('.uploader').each(function(i,v){
		var _this = $(this);
		var _type = $(this).attr('data-type');
		var _slug = $(this).attr('data-slug');
		if(!_type){
			_type = 'default';
		}
        
		var uploader = new plupload.Uploader({
					runtimes : 'html5,flash,silverlight,html4',
					browse_button : $(this).attr('id'), // you can pass in id...					
					url : URL,					
					multi_selection : false,
					/* resize: {
						width: 100,
						height: 100
					  }, */
					filters : {
						max_file_size : '10mb',
						mime_types: [
							{title : "Pdf Document", extensions : "pdf"},
							{title : "Word Document", extensions : "doc"},
							{title : "Word Document", extensions : "docx"},
							{title : "Word Document", extensions : "odt"},
							{title : "Image file", extensions : "jpg"},
							{title : "Image file", extensions : "jpeg"},
							{title : "Image file", extensions : "png"},
							{title : "Image file", extensions : "svg"},
							{title : "Image file", extensions : "gif"},
						]
					},
					multipart_params : {
                        'controlName': _type,
                        'slug':_slug
					},
					headers: { 'X-CSRF-TOKEN': window.Laravel.csrfToken },
					init: {
						PostInit: function() {
							
						},
						
						BeforeUpload:function (up,files){
							var status_before = files.status;
							_this.closest('.input_parent').find('.uploadProgress').css({'width':'0%'});					
							_this.closest('.input_parent').find('.uploadPercentage').html('');				
							
							uploader.settings.url = URL;		
						
						},										
						FilesAdded: function(up, files) {

							_this.closest('.input_parent').find('.uploadFileName').html(files[0].name)
							_this.closest('.input_parent').find('input[type="file"]').attr('required',true)
							/* _this.closest('.input_parent').find('.choose').find('.uploadWrapperParent').removeClass('uploaded')
							_this.closest('.input_parent').find('.choose').find('.uploadWrapperParent').addClass('uploading') */
							uploader.start();
						},

						UploadProgress: function(up, file) {
							_this.closest('.input_parent').find('.uploadProgress').css({'width':file.percent+'%'});					
							_this.closest('.input_parent').find('.uploadPercentage').html(file.percent+'%');				
						},
						FileUploaded:function(up,file,response){
					
							var t = response.response;
						
							var rt  = $.parseJSON(t);
							if(rt.status == true ){
								_this.closest('.input_parent').find('input[type="file"]').removeClass('error')
								_this.closest('.input_parent').find('input[type="file"]').next('label').hide()
								_this.closest('.input_parent').find('input[type="file"]').attr('required',false)
								_this.closest('.input_parent').find('.filename').val(rt.uploadDetails.fileName);
								_this.closest('.input_parent').find('.original_name').val(file.name);
                                var basePath = '{{ asset("storage/app/public/post/") }}/';
                                var downloadPath = '{{ URL::to(Config::get('app.admin_prefix').'/general_filedownload/') }}/';
                                var fileHTML, fileType;
								fileType=_type;
                               
                                if(typeof rt.uploadDetails.fileType != 'undefined'){
                                    fileType = rt.uploadDetails.fileType;
                                }else if(typeof rt.fileType != 'undefined'){
                                    fileType = rt.fileType;
                                }
                                if(typeof fileType == 'undefined' && typeof rt.uploadDetails.type != 'undefined'){
                                    fileType = rt.uploadDetails.type;
                                }
                                
                                if(fileType == 'image'){
                                    fileHTML = '<div class="uploadPreview"><div class="upImgWrapper"><span class="delUploadImage" data-name="'+
                                             rt.uploadDetails.fileName+'"><i class="fa fa-times-circle"></i></span><img src="'+
                                             basePath+rt.uploadDetails.fileName+'" class="uploadPreview"/></div>'+
                                             '<div class="clearfix"></div></div>';                                    
                                }else{
                                    fileHTML = '<div class="uploadPreview filePreview"><div class="upImgWrapper"><span class="delUploadImage" data-name="'+
                                             rt.uploadDetails.fileName+'"><i class="fa fa-times-circle"></i></span><a target="_blank" href="'+
                                             downloadPath+rt.uploadDetails.fileName+'">Download</a></div>'+
                                             '<div class="clearfix"></div></div>';      
                                }
                                _this.closest('.fileUploadWrapper').find('.uploadPreview').remove();  
                                _this.closest('.input_parent').before(fileHTML);
							}else{
								_this.closest('.input_parent').find('.uploadFileName').val('');
								_this.closest('.input_parent').find('.original_name').val('');
								_this.closest('.input_parent').find('.uploadProgress').css({'width':'0%'});					
								_this.closest('.input_parent').find('.uploadPercentage').html('');
                                
								if(typeof swal == 'undefined'){ 
                                    alert(" {{ Lang::get('messages.invalid_file') }} ");
                                }else{
                                    swal({
                                          title: "{{Lang::get('messages.error')}}",
                                          text: rt.response,
                                          type: "warning",
                                          confirmButtonText: "{{Lang::get('messages.ok')}}",
                                          confirmButtonColor:'#000',
                                          closeOnConfirm: false
                                        })
                                }
								
							}
						},
						UploadComplete:function(up,files){
							//$('#loader').hide();
							// $('.uploadWrapperParent').addClass('uploaded')
							uploader.splice();
						},
						Error: function(up, err) {

							
							if(typeof swal == 'undefined'){ 
                                alert(" {{ Lang::get('messages.invalid_file') }} ");
                            }else{
                                swal({
									  title: "{{Lang::get('messages.error')}}",
									  text: "{!! Lang::get('messages.invalid_file') !!} : "+err.message,
									  type: "warning",
									  confirmButtonText: "{{Lang::get('messages.ok')}}",
									  confirmButtonColor:'#000',
									  closeOnConfirm: false
								});
                            }
							
						}
					}
				});
			
	
				uploader.init();

				uploaders.push(uploader);
			
		});   
}

$(document).ready(function(){
	
    function deleteFile($elem, fileName){
		
        if(!fileName) { console.log('Invalid File name'); return false; }
        var url = "{{ URL::to(Config::get('app.admin_prefix').'/general_filedelete' ) }}/"+fileName;
       
        PGSADMIN.utils.sendAjax(url,'GET',{},function(response){
		 
             $.sticky(response.message,{classList:response.msgClass,position:'top-center',speed:'slow'});
			 
             if(response.status){
			 
                var $uploadHTML = $elem.closest('.uploadPreview').next();
                if($uploadHTML.hasClass('uploadControlWrapper')){
                    $uploadHTML.find('.uploadPercentage').html('');
                    $uploadHTML.find('.uploadFileName').html('');
                    $uploadHTML.find('.uploadProgress').css({'width':'0%'});
                    $uploadHTML.find('.filename').val('');
                    $uploadHTML.find('.original_name').val('');
                    $elem.parent().parent().remove();
                }                    
             }
        });
    }
    
    $('form').on('click','.delUploadImage',function(e){
        e.preventDefault();
        var $elem = $(this);
        if(typeof Swal == 'undefined'){ 
            if(confirm('Are you sure?')){
                deleteFile($elem, $elem.attr('data-name'));
            }
        }else{
			Swal.fire({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes !'
				}).then((result) => {
					if (result.value) {
						deleteFile($elem, $elem.attr('data-name'));
					}
				});
        }

        
    });
});


</script>