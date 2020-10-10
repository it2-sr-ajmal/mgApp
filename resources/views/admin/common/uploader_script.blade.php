<script>
<?php /* ====================== JUST COPY PASTE THE DOM STRUCTURE FROM .input_parent ====================== */ ?>
var uploaders = []
var count =1,total;
	$(document).ready(function(){
		$('.uploader').each(function(i,v){
		var _this = $(this);
		var _type = $(this).attr('data-type');
		var _width = $(this).attr('data-width');
		var _height = $(this).attr('data-height');
		if(!_type){
			_type = user
		}
		var uploader = new plupload.Uploader({
					runtimes : 'html5,flash,silverlight,html4',
					//drop_element : 'startup_attachment',
					browse_button : $(this).attr('id'), // you can pass in id...
					//container: document.getElementById('container'), // ... or DOM Element itself
					url : '{{ URL::to(Config::get('app.admin_prefix')."/file/upload") }}',
					//chunk_size: '100kb',
					//flash_swf_url : '<?php echo asset('assets/admin/js/fu/Moxie.swf')?>',
					//silverlight_xap_url :  '<?php echo asset('assets/admin/js/fu/Moxie.xap')?>',
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
							{title : "Image file", extensions : "PNG"},
							{title : "Image file", extensions : "JPG"},
							{title : "Image file", extensions : "JPEG"},
							{title : "Image file", extensions : "bmp"},
							{title : "Image file", extensions : "BMP"},
							{title : "Image file", extensions : "gif"},
							{title : "Image file", extensions : "GIF"},
						]
					},
					multipart_params : {
							'controlName': _type,
							'width' : _width,
							'height' : _height
					},
					headers: { 'X-CSRF-TOKEN': window.Laravel.csrfToken },
					init: {
						PostInit: function() {
							
						},
						
						BeforeUpload:function (up,files){
							var status_before = files.status;
							//$('.uploadFileName').html('')
							_this.closest('.input_parent').find('.uploadProgress').css({'width':'0%'});					
							_this.closest('.input_parent').find('.uploadPercentage').html('');				
							//$(this).next('.choose').find('#loader').show();
							uploader.settings.url = '{{ URL::to(Config::get('app.admin_prefix')."/file/upload") }}';		
						
						},										
						FilesAdded: function(up, files) {
							console.log(files[0].name);
							_this.closest('.input_parent').find('.uploadFileName').html(files[0].name)
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
								console.log(rt.uploadDetails);
								_this.closest('.input_parent').find('input[type="file"]').removeClass('error')
								_this.closest('.input_parent').find('input[type="file"]').next('label').hide()
								_this.closest('.input_parent').find('input[type="file"]').attr('required',false)
								_this.closest('.input_parent').find('.filename').val(rt.uploadDetails.fileName);
								_this.closest('.input_parent').find('.original_name').val(file.name);
			
							}else{
								_this.closest('.input_parent').find('.filename').val('');
								_this.closest('.input_parent').find('.original_name').val('');
							}
						},
						UploadComplete:function(up,files){
							//$('#loader').hide();
							// $('.uploadWrapperParent').addClass('uploaded')
						},
						Error: function(up, err) {
							// alert('Error');
							console.log(up)
							console.log(err)
						}
					}
				});
			
	
				uploader.init();

				uploaders.push(uploader);
			
		})
	})
</script>