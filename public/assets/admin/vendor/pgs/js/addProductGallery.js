function createProductGallery(url, selector, uploadCallbackFunc, mimes='image', errorContainer='#upload_gal_err', csrfToken){
    var gallery_list = [],uploadCount =0;
    
    mimeTypesArr = [];
    
    switch(mimes){
        case 'image':
             mimeTypesArr =  [
                                {title : "Image file", extensions : "jpg"},
                                {title : "Image file", extensions : "jpeg"},
                                {title : "Image file", extensions : "png"},
                             ];
        break;
        case 'doc':
            mimeTypesArr =  [
                                {title : "Document file", extensions : "pdf"},
                                {title : "Document file", extensions : "doc"},
                                {title : "Document file", extensions : "docx"},
                             ];
        break;
        case 'all':
            mimeTypesArr =  [
                                {title : "Image file", extensions : "jpg"},
                                {title : "Image file", extensions : "jpeg"},
                                {title : "Image file", extensions : "png"},
                                {title : "Document file", extensions : "pdf"},
                                {title : "Document file", extensions : "doc"},
                                {title : "Document file", extensions : "docx"},
                             ];
        
        break
    }
    
    
    $(selector).plupload({
        buttons:{browse:true,start:false,stop:false},
		// General settings
		runtimes : 'html5,flash,silverlight,html4',
		url : url,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        max_file_count: 20,
        filters : {
            max_file_size : '10mb',
            mime_types: mimeTypesArr
        },
        multipart_params : {
            "type" : mimes
        },
        init: {
            
            PostInit: function(){},
            FilesAdded: function(up, files) {
                  $(selector).addClass('plupload_not_empty');
				  $(errorContainer).html('');
                  up.start();
            },
            UploadProgress: function(up, file) {
            
            },
            FileUploaded:function(up,file,response){
                var jsonResponse;
                try{
                    jsonResponse = JSON.parse(response.response);
                    uploadCallbackFunc(up,file,jsonResponse,true);
                }catch(e){
                    /* setTimeout(function() {
                        $(errorContainer).append('<div class="alert-danger">'+file.name+' cannot be uploaded.Please upload file with recommended size and type</div>');
                    }, 500);
                    setTimeout(function() {
                        $(errorContainer).html('');
                    }, 5000); */
                    console.log(e);
                    uploadCallbackFunc(up,file,e,true);
                    return false;
                }
                
                // uploadCallbackFunc(up,file,jsonResponse,status);
            },
            UploadComplete:function(up,files){
                
            },
            Error: function(up, err) {
                console.log(err);
                uploadCallbackFunc(up,null,err,false);
                
				// document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
            }
        },
        sortable: true,
        dragdrop: true,
        /* views: {
            list: true,
            thumbs: true, // Show thumbs
            active: 'thumbs'
        } */
            
        
        
    });
}