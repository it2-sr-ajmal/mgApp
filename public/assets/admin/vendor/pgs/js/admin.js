var PGSADMIN = (function() {
    var _self = this, galleryUploaders = [], uploaders = [];
	_self.configs = {
		CKconfig: {
					// Define the toolbar: http://docs.ckeditor.com/ckeditor4/docs/#!/guide/dev_toolbar
					// The full preset from CDN which we used as a base provides more features than we need.
					// Also by default it comes with a 3-line toolbar. Here we put all buttons in a single row.
					toolbar: [
						{ name: 'document', items: [ 'Print' ] },
						{ name: 'clipboard', items: [ 'Undo', 'Redo' ] },
						{ name: 'styles', items: [ 'Format', 'FontSize' ] },
						{ name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat', 'CopyFormatting' ] },
						{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
						{ name: 'align', items: [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
						{ name: 'links', items: [ 'Link', 'Unlink' ] },
						{ name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote' ] },
						/* { name: 'insert', items: [  'Table','Image','Image2','Html5audio','Html5video','EmbedSemantic','UploadFile'  ] }, */
						{ name: 'tools', items: [ 'Maximize','PasteText' ] },
						{ name: 'editing', items: [ 'Scayt'] },
						{ name: 'source', items: [ 'Sourcedialog' ] }
					],
					// Since we define all configuration options here, let's instruct CKEditor to not load config.js which it does by default.
					// One HTTP request less will result in a faster startup time.
					// For more information check http://docs.ckeditor.com/ckeditor4/docs/#!/api/CKEDITOR.config-cfg-customConfig
					
					customConfig: '',
					// Sometimes applications that convert HTML to PDF prefer setting image width through attributes instead of CSS styles.
					// For more information check:
					//  - About Advanced Content Filter: http://docs.ckeditor.com/ckeditor4/docs/#!/guide/dev_advanced_content_filter
					//  - About Disallowed Content: http://docs.ckeditor.com/ckeditor4/docs/#!/guide/dev_disallowed_content
					//  - About Allowed Content: http://docs.ckeditor.com/ckeditor4/docs/#!/guide/dev_allowed_content_rules
					disallowedContent: 'img{width,height,float}',
					extraAllowedContent: 'img[width,height,align]',
					// Enabling extra plugins, available in the full-all preset: http://ckeditor.com/presets-all
					// extraPlugins: 'tableresize,uploadimage,uploadfile',
					extraPlugins: 'tableresize,uploadimage,uploadfile,embedsemantic,pastetext,sourcedialog,html5audio,html5video,filebrowser,image2,image',
					removePlugins: 'sourcearea,image',

					/*********************** File management support ***********************/
					// In order to turn on support for file uploads, CKEditor has to be configured to use some server side
					// solution with file upload/management capabilities, like for example CKFinder.
					// For more information see http://docs.ckeditor.com/ckeditor4/docs/#!/guide/dev_ckfinder_integration
					// Uncomment and correct these lines after you setup your local CKFinder instance.
					filebrowserBrowseUrl: window.baseURL+window.adminPrefix+'file_browser_ckeditor?type=file',
					filebrowserUploadUrl: window.baseURL+window.adminPrefix+'file_upload_ckeditor?type=file',
					filebrowserImageBrowseUrl: window.baseURL+window.adminPrefix+'file_browser_ckeditor?type=image',
					filebrowserImageUploadUrl: window.baseURL+window.adminPrefix+'file_upload_ckeditor?type=image',
					/**/
					
					
					/*********************** File management support ***********************/
					// Make the editing area bigger than default.
					height: 200,
					// An array of stylesheets to style the WYSIWYG area.
					// Note: it is recommended to keep your own styles in a separate file in order to make future updates painless.
					contentsCss: [ window.baseURL+'/assets/editor/source/ckeditor/css/contents.css', window.baseURL+'/assets/editor/css/custom_ckeditor.css' ],
					// This is optional, but will let us define multiple different styles for multiple editors using the same CSS file.
					bodyClass: 'document-editor',
					// Reduce the list of block elements listed in the Format dropdown to the most commonly used.
					format_tags: 'p;h1;h2;h3;pre',
					// Simplify the Image and Link dialog windows. The "Advanced" tab is not needed in most cases.
					removeDialogTabs: 'image:advanced;link:advanced',
					// Define the list of styles which should be available in the Styles dropdown list.
					// If the "class" attribute is used to style an element, make sure to define the style for the class in "mystyles.css"
					// (and on your website so that it rendered in the same way).
					// Note: by default CKEditor looks for styles.js file. Defining stylesSet inline (as below) stops CKEditor from loading
					// that file, which means one HTTP request less (and a faster startup).
					// For more information see http://docs.ckeditor.com/ckeditor4/docs/#!/guide/dev_styles
					image2_alignClasses: [ 'image-align-left', 'image-align-center', 'image-align-right' ],

					stylesSet: [
						/* Inline Styles */
						{ name: 'Marker', element: 'span', attributes: { 'class': 'marker' } },
						{ name: 'Cited Work', element: 'cite' },
						{ name: 'Inline Quotation', element: 'q' },
						/* Object Styles */
						{
							name: 'Special Container',
							element: 'div',
							styles: {
								padding: '5px 10px',
								background: '#eee',
								border: '1px solid #ccc'
							}
						},
						{
							name: 'Compact table',
							element: 'table',
							attributes: {
								cellpadding: '5',
								cellspacing: '0',
								border: '1',
								bordercolor: '#ccc'
							},
							styles: {
								'border-collapse': 'collapse'
							}
						},
						{ name: 'Borderless Table', element: 'table', styles: { 'border-style': 'hidden', 'background-color': '#E6E6FA' } },
						{ name: 'Square Bulleted List', element: 'ul', styles: { 'list-style-type': 'square' } }
					]
				}
		
		
	};
    _self.utils = {
		getRand: function(){
			return (moment().unix()+Math.random()).toString().replace('.','_');
		},
		copyData:function(from,to){
			$('body').on('keyup',from,function(e){
				
				$(to).val($(this).val());
			});
		},
        test: function() {
            console.log('Hello WOrld');
        },
		catchPaste: function (evt, elem, callback) {
		  if (navigator.clipboard && navigator.clipboard.readText) {
			// modern approach with Clipboard API
			navigator.clipboard.readText().then(callback);
		  } else if (evt.originalEvent && evt.originalEvent.clipboardData) {
			// OriginalEvent is a property from jQuery, normalizing the event object
			callback(evt.originalEvent.clipboardData.getData('text'));
		  } else if (evt.clipboardData) {
			// used in some browsers for clipboardData
			callback(evt.clipboardData.getData('text/plain'));
		  } else if (window.clipboardData) {
			// Older clipboardData version for Internet Explorer only
			callback(window.clipboardData.getData('Text'));
		  } else {
			// Last resort fallback, using a timer
			setTimeout(function() {
			  callback(elem.value)
			}, 100);
		  }
		},
		getYoutubeID: function(url){
			var re = /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i;
			var match  = url.match(re);
			if(!match) {
				return false;
			}
			return match[1];
		},
        isArabic: function(str) {
            var arabic = /[\u0600-\u06FF]/;
            return arabic.test(str);
        },
        sendAjax: function(url, type, dataToSend, callback) {
            dataToSend._token = window.Laravel.csrfToken;

            /* if(type != 'GET' || type != 'POST'){
                console.log('The 2nd Arg is send Type - POST or GET');
            } */

            if ($('#commonAjaxLoader').length) {
                $('#commonAjaxLoader').show();
            }
            $.ajax({
                url: url,
                type: type,
                async: true,
                data: dataToSend,
                dataType: 'json',
                statusCode: {
                    302: function() { alert('Forbidden. Access Restricted'); },
                    403: function() { alert('Forbidden. Access Restricted', '403'); },
                    404: function() { alert('Page not found', '404'); },
                    500: function() { alert('Internal Server Error', '500'); }
                }
            }).done(function(responseData) {
                callback(responseData);
                $('#commonAjaxLoader').hide();

            }).fail(function(jqXHR, textStatus) {
                $('#commonAjaxLoader').hide();
                callback(jqXHR);

            });


        },
        showTopMessage: function(message) {
            $('#topMessage').html(message);
            $('#topMessage').removeClass('hidden');

            setTimeout(function() {
                $('#topMessage').html('');
                $('#topMessage').addClass('hidden');
            }, 6000);
        },
        singleAjaxUpload: function(settings, customData) {


            var uploader = new plupload.Uploader({
                runtimes: 'html5,flash,silverlight,html4',
                drop_element: 'uploader-target',
                browse_button: 'uploader-target', // you can pass in id...
                url: settings.url,
                filters: settings.filters,
                multipart_params: {},
                headers: { 'X-CSRF-TOKEN': window.Laravel.csrfToken },
                init: {
                    BeforeUpload: function(up, files) {
                        if (typeof customData == 'object') {
                            uploader.settings.multipart_params = customData;
                        }
                        var status_before = files.status;
                        $('#loader').show();
                        var htm = $('#' + files.id).html();
                        $('#' + files.id).html(htm + ' <i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i><span class="percent"></span>');
                    },
                    FilesAdded: function(up, files) {

                        total = files.length;
                        $(files).each(function(i, v) {
                            $('#selected_files').append('<div id="' + v.id + '">' + v.name + '</div>');
                        })

                        // $('.file-list').html('');
                        count = 1;
                        uploader.start();
                    },

                }

            });

        },
		youtubeVideoThumbUploader: function(elementID, uploadUrl , basePath) {
			
			var _slug = $('#'+elementID).attr('data-slug');
			
            var uploader = new plupload.Uploader({
                runtimes: 'html5,flash,silverlight,html4',
                browse_button: elementID, // you can pass in id...
                url: uploadUrl,
				filters : {
					max_file_size : '10mb',
					mime_types: [
						{title : "Image file", extensions : "jpg"},
						{title : "Image file", extensions : "jpeg"},
						{title : "Image file", extensions : "png"},
						{title : "Image file", extensions : "svg"},
						{title : "Image file", extensions : "gif"},
					]
				},
                multipart_params: {
					'name':'video',
					'slug':_slug+'_ytthumb'
				},
                headers: { 'X-CSRF-TOKEN': window.Laravel.csrfToken },
                init: {
                    BeforeUpload: function(up, files) {
                       
                    },
                    FilesAdded: function(up, files) {
						uploader.start();
					},
					UploadProgress: function(up, file) {
						$('#ytThumb').find('.uploadProgress').css({'width':file.percent+'%'});					
						$('#ytThumb').find('.uploadPercentage').html(file.percent+'%');				
					},
					FileUploaded:function(up,file,response){
				
						var t = response.response;
						
						try{	
							var rt  = $.parseJSON(t);
							
							if(rt.status == true ){
								$('#youtube_thumb').attr('src',basePath+rt.data.fileName);
								$('#customImage').val(rt.data.id);
								$('#ytThumb').find('.uploadFileName').html('');
								$('#ytThumb').find('.original_name').val('');
								$('#ytThumb').find('.uploadProgress').css({'width':'0%'});					
								$('#ytThumb').find('.uploadPercentage').html('');
								
							}else{
								$('#ytThumb').find('.uploadFileName').html('');
								$('#ytThumb').find('.original_name').val('');
								$('#ytThumb').find('.uploadProgress').css({'width':'0%'});					
								$('#ytThumb').find('.uploadPercentage').html('');
								
								if(typeof swal == 'undefined'){ 
									alert(window.appTrans.invalidFile);
								}else{
									swal.fire({
										  title: window.appTrans.error,
										  text: rt.response,
										  type: "warning",
										  confirmButtonText: window.appTrans.ok,
										  confirmButtonColor:'#000',
										  closeOnConfirm: false
										})
								}
								
							}
						}catch(ex){					
							// console.log(ex);
							Swal.fire({
								text: 'Network Error Occured. Please try again.',
								type: 'error',
							});
							$('#ytThumb').find('.uploadFileName').html('');
							$('#ytThumb').find('.filename').val('');
							$('#ytThumb').find('.original').val('');
							$('#ytThumb').find('.uploadProgress').css({'width':'0%'});					
							$('#ytThumb').find('.uploadPercentage').html('');
						}
					},
					UploadComplete:function(up,files){
						//$('#loader').hide();
						// $('.uploadWrapperParent').addClass('uploaded')
						uploader.splice();
					},
					Error: function(up, err) {

						
						if(typeof swal == 'undefined'){ 
							alert(window.appTrans.invalidFile);
						}else{
							swal.fire({
								  title: window.appTrans.error,
								  text: window.appTrans.invalidFile+err.message,
								  type: "warning",
								  confirmButtonText: window.appTrans.ok,
								  confirmButtonColor:'#000',
								  closeOnConfirm: false
							});
						}
						
					}
                }

            });
			
			uploader.init();
			
			
        },
		createFileHolder: function (type, basePath,data, downloadPath){
			var dispElement = ''; 
			switch(type){
				case 'image':
					dispElement = '<img src="'+basePath+data.fileName+'" alt="" class="img-fluid imageCenter">';
				break;
				case 'video':
					
					dispElement = (data.name)?'<img src="'+basePath+data.fileName+'" alt="" class="img-fluid imageCenter">':'<img src="https://img.youtube.com/vi/'+data.video+'/hqdefault.jpg" alt="" class="img-fluid imageCenter">';
					
				break;
				
				default:
					dispElement = 	'<span class="fa-stack fa-lg">'+
										'<i class="fa fa-square fa-stack-2x text-primary"></i>'+
										'<i class="fa fa-file-'+type+' fa-stack-1x fa-inverse"></i>'+
									'</span>';
				break;
			}
			return '<li class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 custCardWrapper">'+
						'<div class="card card-figure has-hoverable">'+
							'<div class="topControls">'+
								'<a class="downloadImage" href="'+downloadPath+data.id+'"> <span><i class="fas fa-download "></i></span></a>'+
								'<div class="text-center ytLang">'+
									'<select name="mediaLang[]" class="cardLang">'+
										'<option value="">In Both</option>'+
										'<option '+((data.lang =="ar")?" selected ":"")+' value="ar">Arabic</option>'+
										'<option  '+((data.lang =="en")?" selected ":"")+' value="en">English</option>'+
									'</select>'+
								'</div>'+
								'<a href="#" class="btn btn-reset text-muted delUploadImage" title="Delete" data-id="'+data.id+'">'+
									'<span class="fas fa-times-circle"></span>'+
								'</a>'+
							'</div>'+
							'<figcaption class="figure-caption">'+
								
								'<div><input data-id="'+data.id+'" type="text" class="form-control mediaInput source"  value="'+((data.source)?data.source:'')+'" placeholder="Source English" name="source[]"></div>'+
								'<div><input data-id="'+data.id+'"  type="text" class="form-control  mediaInput sourceAR"  value="'+((data.sourceAR)?data.sourceAR:'')+'" placeholder="Source Arabic" dir="rtl" name="sourceAR[]"></div>'+
							'</figcaption>'+
							'<figure class="figure">'+
								
								'<div class="figure-attachment adjustImage">'+
									'<input type="hidden" name="postMedia['+data.fieldName+'][]" value="'+data.id+'" />'+
										dispElement+										
								'</div>'+
							'</figure>'+
							'<figcaption class="figure-caption">'+
								
								'<div><input data-id="'+data.id+'" type="text" class="form-control  mediaInput engTitle"  value="'+((data.title)?data.title:'')+'" placeholder="English Title" name="engTitle[]"></div>'+
								'<div><input data-id="'+data.id+'"  type="text" class="form-control  mediaInput  arTitle"  value="'+((data.titleAR)?data.titleAR:'')+'" placeholder="Arabic Title" dir="rtl" name="arTitle[]"></div>'+
							'</figcaption>'+
						'</div>'+
					'</li>';
		},
		createEnglishArticleEditor: function (){
			CKEDITOR.disableAutoInline = true;
			$('.ckeditorEn').each(function(i,v){
				var id = $(this).attr('id') , exist = false;
				
				for(var instanceName in CKEDITOR.instances) {
					// console.log(instanceName)
				  if(instanceName == id){
					  exist = true;
				  }
				}
				
				if(!exist){
					_self.configs.CKconfig.contentsLangDirection = 'ltr';
					_self.configs.CKconfig.contentsLanguage = 'en';
					_self.configs.CKconfig.language = 'en';
					CKEDITOR.replace( this, _self.configs.CKconfig);
				}
			});
			
		},
		createArabicArticleEditor:function (){
			$('.ckeditorAr').each(function(i,v){
				var id = $(this).attr('id') , exist = false;
				
				for(var instanceName in CKEDITOR.instances) {
				  if(instanceName == id){
					  exist = true;
				  }
				}
				
				if(!exist){
					_self.configs.CKconfig.contentsLangDirection = 'rtl';
					_self.configs.CKconfig.contentsLanguage = 'ar';
					_self.configs.CKconfig.language = 'ar';
					CKEDITOR.replace( this, _self.configs.CKconfig);
				}
			});
		},
		createAjaxFileUploader: function (URL, downloadPath, basePath){
			$('.singleuploader').each(function(i,v){
				var _this = $(this);
				var _type = $(this).attr('data-type');
				var _slug = $(this).attr('data-slug');
				var _name = $(this).attr('name');
				
				var _mimeTypesTmp = $(this).attr('data-allowed');
				if(!_type){
					_type = 'default';
				}
				if(!_mimeTypesTmp){
					_mimeTypes = [
						{title : "Pdf Document", extensions : "pdf"},
						{title : "Word Document", extensions : "doc"},
						{title : "Word Document", extensions : "docx"},
						{title : "Word Document", extensions : "odt"},
						{title : "Image file", extensions : "jpg"},
						{title : "Image file", extensions : "jpeg"},
						{title : "Image file", extensions : "png"},
						{title : "Image file", extensions : "svg"},
					];
				}else{
					_mimeTypes = [];
					var _spitArr = _mimeTypesTmp.split(',');
					
					$.each(_spitArr,function(i,v){
						_mimeTypes.push({title : "document",extensions:v })
					})
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
								mime_types: _mimeTypes
							},
							multipart_params : {
								'controlName': _type,
								'slug':_slug,
								'name':_name
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
									try{	
										var rt  = $.parseJSON(t);
										if(rt.status == true ){
											_this.closest('.input_parent').find('input[type="file"]').removeClass('error')
											_this.closest('.input_parent').find('input[type="file"]').next('label').hide()
											_this.closest('.input_parent').find('input[type="file"]').attr('required',false)
											_this.closest('.input_parent').find('.filename').val(rt.data.fileName);
											_this.closest('.input_parent').find('.original_name').val(file.name);
											// var basePath = '{{ asset("storage/app/post/uploads") }}/';
											// var downloadPath = '{{ apa("post_media_download") }}/';
											var fileHTML, fileType;
											fileType=_type;
										   
											if(typeof rt.data.fileType != 'undefined'){
												fileType = rt.data.fileType;
											}else if(typeof rt.fileType != 'undefined'){
												fileType = rt.fileType;
											}
											if(typeof fileType == 'undefined' && typeof rt.data.type != 'undefined'){
												fileType = rt.data.type;
											}
											
											if(jQuery.inArray(rt.data.mimeType, ['image/jpeg','image/png','image/gif']) !== -1){
												fileHTML = '<div class="uploadPreview img_uploaded"><div class="upImgWrapper"><input type="hidden" name="postMedia['+rt.data.fieldName+'][]" value="'+rt.data.id+'" /><span class="delUploadImage" data-id="'+
														 rt.data.id+'"><i class="fa fa-times-circle"></i></span><img src="'+
														 basePath+rt.data.fileName+'" class="uploadPreview"/></div>'+
														 '<div class="clearfix"></div></div>';                                    
											}else{
												fileHTML = '<div class="uploadPreview filePreview img_uploaded"><div class="upImgWrapper"><input type="hidden" name="postMedia['+rt.data.fieldName+'][]" value="'+rt.data.id+'" /><span class="delUploadImage" data-id="'+
														 rt.data.fileName+'"><i class="fa fa-times-circle"></i></span><a target="_blank" href="'+
														 downloadPath+rt.data.id+'">Download</a></div>'+
														 '<div class="clearfix"></div></div>';      
											}
											
											fileHTML += '';
											 
											 _this.parent().parent().find('.uploadPreview').remove();  
											_this.closest('.input_parent').before(fileHTML);
										}else{
											_this.closest('.input_parent').find('.uploadFileName').val('');
											_this.closest('.input_parent').find('.original_name').val('');
											_this.closest('.input_parent').find('.uploadProgress').css({'width':'0%'});					
											_this.closest('.input_parent').find('.uploadPercentage').html('');
											
											if(typeof swal == 'undefined'){ 
												alert(window.appTrans.invalidFile);
											}else{
												swal.fire({
													  title: window.appTrans.error,
													  text: rt.response,
													  type: "warning",
													  confirmButtonText: window.appTrans.ok,
													  confirmButtonColor:'#000',
													  closeOnConfirm: false
													})
											}
											
										}
									}catch(ex){					
								
										Swal.fire({
											text: 'Network Error Occured. Please try again.',
											type: 'error',
										});
										_this.closest('.input_parent').find('.uploadFileName').html('');
										_this.closest('.input_parent').find('.filename').val('');
										_this.closest('.input_parent').find('.original').val('');
										_this.closest('.input_parent').find('.uploadProgress').css({'width':'0%'});					
										_this.closest('.input_parent').find('.uploadPercentage').html('');
									}
								},
								UploadComplete:function(up,files){
									//$('#loader').hide();
									// $('.uploadWrapperParent').addClass('uploaded')
									uploader.splice();
								},
								Error: function(up, err) {

									
									if(typeof swal == 'undefined'){ 
										alert(window.appTrans.invalidFile);
									}else{
										swal.fire({
											  title: window.appTrans.error,
											  text: window.appTrans.invalidFile+err.message,
											  type: "warning",
											  confirmButtonText:window.appTrans.ok,
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
				
				$(document).ready(function(){
	
					function deleteFile($elem, fileId){
						
						if(!fileId) { console.log('Invalid File name'); return false; }
						
						var url = window.postMediaDelURL+fileId;
					   
						PGSADMIN.utils.sendAjax(url,'GET',{},function(response){
							if($.fn.sticky && response.msgClass){
								$.sticky(response.message,{classList:response.msgClass,position:'top-center',speed:'slow'});
							}
							 if(response.status){
								var $uploadHTML = $elem.closest('.fileUploadWrapper').find('.uploadControlWrapper');
								if($uploadHTML.hasClass('uploadControlWrapper')){
									$uploadHTML.find('.uploadPercentage').html('');
									$uploadHTML.find('.uploadFileName').html('');
									$uploadHTML.find('.uploadProgress').css({'width':'0%'});
									$uploadHTML.find('.filename').val('');
									$uploadHTML.find('.original_name').val('');
									$elem.parent().remove();
								}                    
							 }
						});
					}
					
					$('body').on('click','.delUploadImage',function(e){
						e.preventDefault();
						var $elem = $(this);
						if(typeof Swal == 'undefined'){ 
							if(confirm('Are you sure?')){
								deleteFile($elem, $elem.attr('data-id'));
							}
						}else{
							Swal.fire({
								title: window.appTrans.areYouSure,
								text: window.appTrans.cannotRevert,
								type: 'warning',
								showCancelButton: true,
								confirmButtonColor: '#3085d6',
								cancelButtonColor: '#d33',
								confirmButtonText: window.appTrans.yes
								}).then((result) => {
									if (result.value) {
										deleteFile($elem, $elem.attr('data-id'));
									}
								});
						}

						
					});
				});

		},
		createMediaUploader: function (URL, resultDivID, downloadPath, basePath){
			
			$('#youtubeURL').on('keydown',function(e){
			
					// console.log($(this).val());
				var videoID = PGSADMIN.utils.getYoutubeID($(this).val());				
				if(!videoID) {
					$('#youtubeURL').addClass('error');
					$('#youtube_thumb').attr('src',window.baseURL+'assets/admin/images/def-youtube-thumb.png');
					
				}else{
					$('#youtubeURL').removeClass('error');
					$('#youtube_thumb').attr('src',"https://img.youtube.com/vi/"+videoID+"/hqdefault.jpg");
					$('#changeImage').attr('href','#');
					$('#chCoverWrapper').addClass('btn').addClass('btn-primary');
					$('#saveWrapper').addClass('btn').addClass('btn-success');
				}
				
			});
			
			$('#youtubeURL').on('paste',function(e){
				PGSADMIN.utils.catchPaste(e, this, function(url){
					
					var videoID = PGSADMIN.utils.getYoutubeID(url);				
					if(!videoID) {
						// console.log('add class');
						$('#youtubeURL').addClass('error');
						$('#youtube_thumb').attr('src',basePath+'assets/admin/images/def-youtube-thumb.png');
						return false;
					}
					$('#youtubeURL').removeClass('error');
					$('#youtube_thumb').attr('src',"https://img.youtube.com/vi/"+videoID+"/hqdefault.jpg");
					$('#changeImage').attr('href','#');
					$('#chCoverWrapper').addClass('btn').addClass('btn-primary');
					$('#saveWrapper').addClass('btn').addClass('btn-success');
				});
				
			});
			
			$('#saveYoutube').on('click',function(e){
				e.preventDefault();
				var resultDiv = $(this).attr('data-resultDiv');
				var url = $('#youtubeURL').val();
				var videoID = PGSADMIN.utils.getYoutubeID(url);
				if(!videoID){
					$('#youtubeURL').addClass('error');
					return false;
				}
				var dataToSend = {};
				$('.ytInput').each(function(i,v){
					var name = $(this).attr('name');
					var val = $(this).val();
					dataToSend[name] = val;
				});
				//console.log(dataToSend);
				PGSADMIN.utils.sendAjax(window.saveYoutubeURL,'POST',dataToSend,function(responseData){
					// console.log(PGSADMIN.utils.createFileHolder('video',basePath,responseData,downloadPath));
					if(resultDiv && responseData.status){
						console.log(resultDiv);
						$('#'+resultDiv).append(PGSADMIN.utils.createFileHolder('video',basePath,responseData.data,downloadPath));
						$('#youtubeURL').val('');
						$('#customImage').val('');
						
						$('#youtube_thumb').attr('src', '');
					}
				});
				
			});
			
			$('.multiuploader').each(function(i,v){
				var _this = $(this);
				var _type = $(this).attr('data-type');
				var _slug = $(this).attr('data-slug');
				var _name = $(this).attr('name');
				if(!_type){
					_type = 'default';
				}
				
				var uploader = new plupload.Uploader({
							runtimes : 'html5,flash,silverlight,html4',
							browse_button : $(this).attr('id'), // you can pass in id...					
							url : URL,					
							multi_selection : true,
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
								'slug':_slug+'_gallery',
								'name':_name
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
									
									try{	
										var rt  = $.parseJSON(t);
										if(rt.status == true ){
											_this.closest('.input_parent').find('input[type="file"]').removeClass('error')
											_this.closest('.input_parent').find('input[type="file"]').next('label').hide()
											_this.closest('.input_parent').find('input[type="file"]').attr('required',false)
											_this.closest('.input_parent').find('.filename').val(rt.data.fileName);
											_this.closest('.input_parent').find('.original_name').val(file.name);
											
											var fileHTML, fileType;
											fileType=_type;
										   
											if(typeof rt.data.fileType != 'undefined'){
												fileType = rt.data.fileType;
											}else if(typeof rt.fileType != 'undefined'){
												fileType = rt.fileType;
											}
											if(typeof fileType == 'undefined' && typeof rt.data.type != 'undefined'){
												fileType = rt.data.type;
											}
											
											if(jQuery.inArray(rt.data.mimeType, ['image/jpeg','image/png','image/gif','image/svg+xml']) !== -1){
													fileHTML = PGSADMIN.utils.createFileHolder('image',basePath,rt.data,downloadPath);
											}else if(jQuery.inArray(rt.data.mimeType, ['application/pdf']) !== -1){
													fileHTML = PGSADMIN.utils.createFileHolder('pdf',basePath,rt.data,downloadPath);
											}else if(jQuery.inArray(rt.data.mimeType, ['application/vnd.openxmlformats-officedocument.wordprocessingml.document']) !== -1){
													fileHTML = PGSADMIN.utils.createFileHolder('word',basePath,rt.data,downloadPath);
											}else{
													fileHTML = PGSADMIN.utils.createFileHolder('file',basePath,rt.data,downloadPath);
											}
											
											fileHTML += '';
											_this.closest('.fileUploadWrapper').find('.uploadPreview').remove();  
											$(resultDivID).append(fileHTML);
											
											_this.closest('.input_parent').find('.uploadFileName').html('');
											_this.closest('.input_parent').find('.original_name').val('');
											_this.closest('.input_parent').find('.uploadProgress').css({'width':'0%'});					
											_this.closest('.input_parent').find('.uploadPercentage').html('');
											
										}else{
											_this.closest('.input_parent').find('.uploadFileName').html('');
											_this.closest('.input_parent').find('.original_name').val('');
											_this.closest('.input_parent').find('.uploadProgress').css({'width':'0%'});					
											_this.closest('.input_parent').find('.uploadPercentage').html('');
											
											if(typeof swal == 'undefined'){ 
												alert(window.appTrans.invalidFile);
											}else{
												swal.fire({
													  title: window.appTrans.error,
													  text: rt.response,
													  type: "warning",
													  confirmButtonText: window.appTrans.ok,
													  confirmButtonColor:'#000',
													  closeOnConfirm: false
													})
											}
											
										}
									}catch(ex){					
										console.log(ex);
										Swal.fire({
											text: 'Network Error Occured. Please try again.',
											type: 'error',
										});
										_this.closest('.input_parent').find('.uploadFileName').html('');
										_this.closest('.input_parent').find('.filename').val('');
										_this.closest('.input_parent').find('.original').val('');
										_this.closest('.input_parent').find('.uploadProgress').css({'width':'0%'});					
										_this.closest('.input_parent').find('.uploadPercentage').html('');
									}
								},
								UploadComplete:function(up,files){
									//$('#loader').hide();
									// $('.uploadWrapperParent').addClass('uploaded')
									uploader.splice();
								},
								Error: function(up, err) {

									
									if(typeof swal == 'undefined'){ 
										alert(window.appTrans.invalidFile);
									}else{
										swal.fire({
											  title: window.appTrans.error,
											  text: window.appTrans.invalidFile+err.message,
											  type: "warning",
											  confirmButtonText: window.appTrans.ok,
											  confirmButtonColor:'#000',
											  closeOnConfirm: false
										});
									}
									
								}
							}
						});
					
			
						uploader.init();

						galleryUploaders.push(uploader);
					
				});   
				
				$(document).ready(function(){
					function deleteMultiFile($elem, fileId){
		
						if(!fileId) { console.log('Invalid File name'); return false; }
						var url = window.postMediaDelURL+fileId;
					   
						PGSADMIN.utils.sendAjax(url,'GET',{},function(response){
							 if($.fn.sticky && response.msgClass){
								$.sticky(response.message,{classList:response.msgClass,position:'top-center',speed:'slow'});
							 }
							 
							 if(response.status){
								 $elem.closest('.custCardWrapper').remove();           
							 }
						});
					}
					
					$('.myFileLister').on('click','.delUploadImage',function(e){
						e.preventDefault();
						var $elem = $(this);
						if(typeof Swal == 'undefined'){ 
							if(confirm('Are you sure?')){
								deleteMultiFile($elem, $elem.attr('data-id'));
							}
						}else{
							Swal.fire({
								title: window.appTrans.areYouSure,
								text: window.appTrans.cannotRevert,
								type: 'warning',
								showCancelButton: true,
								confirmButtonColor: '#3085d6',
								cancelButtonColor: '#d33',
								confirmButtonText: window.appTrans.yes
								}).then((result) => {
									if (result.value) {
										deleteMultiFile($elem, $elem.attr('data-id'));
									}
								});
						}

						
					});
				});
		}
		
    };
    _self.init = function() {

        $('.dirChange').on('change', function(e) {
            var tt = $(this).val();
            if (PGSADMIN.utils.isArabic(tt)) {
                $(this).attr('dir', 'rtl');
            } else {
                $(this).attr('dir', 'ltr');
            }
        });
        $('.dirChange').on('keyup', function(e) {
            var tt = $(this).val();
            if (PGSADMIN.utils.isArabic(tt)) {
                $(this).attr('dir', 'rtl');
            } else {
                $(this).attr('dir', 'ltr');
            }
        });

        $('body').on('click', '.delRow', function(e) {
            e.preventDefault();
            var elem = this;
            var delURL = $(this).attr('href');
            if (typeof swal == 'undefined') {
                if (confirm('Are you sure?')) {
                    PGSADMIN.utils.sendAjax(delURL, 'get', {}, function(responseData) {
                        $(elem).closest('tr').remove();
                        $.sticky(responseData.message, { classList: responseData.msgClass, position: 'top-center', speed: 'slow' });
                    });
                }
            } else {
                swal({
                    title: "Are you sure?",
                    showCancelButton: true,
                }, function() {
                    PGSADMIN.utils.sendAjax(delURL, 'get', {}, function(responseData) {
                        $(elem).closest('tr').remove();
                        $.sticky(responseData.message, { classList: responseData.msgClass, position: 'top-center', speed: 'slow' });
                    });
                });
            }


        });
		
		$('.table').basictable({
			breakpoint: 768,
		});
		$(".custom-select").select2({});
		
		
    };
    _self.singleUploadResponseHandler = function(responseData, type, targetID) {
        if (type == 'table' && $(targetID).length && responseData.status == true) {
            var delURL = window.baseURL + window.adminPrefix + 'resource_manager/delete_attachment/' + responseData.fileID;
            var hiddenInput = '<input type="hidden" name="resource_attachments[]" value="' + responseData.fileID + '" />';

            var tdHTML = '<tr><td>' + ($(targetID + ' tbody > tr').length + 1) + hiddenInput + '</td><td>' + responseData.fileName + '</td><td>' + responseData.fileSize + '</td><td><a data-id="' + responseData.fileID + '" class="delRow" href="' + delURL + '">Delete</a></td></tr>';

            $('#res_attach > tbody').append(tdHTML)
        }
    };
    return _self;
})();