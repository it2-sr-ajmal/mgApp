<script>
var customUploaders = []
var count =1,total;

function createResourceAjaxFileUploader(URL, callbackFnc){
    $('.custom_uploader').each(function(i,v){
		var _this = $(this);
		var _type = $(this).attr('data-type');
		var _slug = $(this).attr('data-slug');
		var _submitURL = $(this).attr('data-url');
		var _resourceID = $(this).attr('data-id');
		_resourceID = (typeof _resourceID == 'undefined' || !_resourceID)?0:_resourceID;
		
		if(!_type){
			_type = 'default';
		}
        
		var uploader = new plupload.Uploader({
					runtimes : 'html5,flash,silverlight,html4',
					browse_button : $(this).attr('id'), // you can pass in id...					
					url : URL,					
					multi_selection : false,
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
						]
					},
					multipart_params : {
                        '_token': window.Laravel.csrfToken,
                        'controlName': _type,
						'slug':_slug,
						'id':_resourceID
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
							//_this.closest('.input_parent').find('input[type="file"]').attr('required',true)
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
									
							callbackFnc(rt);	
							_this.closest('.input_parent').find('.uploadFileName').html('');
							_this.closest('.input_parent').find('.original_name').val('');
							_this.closest('.input_parent').find('.uploadProgress').css({'width':'0%'});					
							_this.closest('.input_parent').find('.uploadPercentage').html('');									
							if(rt.status == false ){
								
                                
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

				customUploaders.push(uploader);
			
		});   
}

$(document).ready(function(){
    function deleteFile($elem, fileName){
        if(!fileName) { console.log('Invalid File name'); return false; }
        var url = "{{ URL::to(Config::get('app.admin_prefix').'/resource_manager/delete_file/' ) }}/"+fileName;
       
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
        if(typeof swal == 'undefined'){ 
            if(confirm('Are you sure?')){
                deleteFile($elem, $elem.attr('data-name'));
            }
        }else{
            swal({
                title :"Are you sure?",
                showCancelButton: true,
            },function(){
                deleteFile($elem, $elem.attr('data-name'));
            });
        }

        
    });
});


</script>