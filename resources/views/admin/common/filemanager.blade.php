<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GovEx::Browsing Files</title>
    
    {{ HTML::style('assets/admin/dist/css/file-upload-window-style.css') }}
    <script>
        // Helper function to get parameters from the query string.
        function getUrlParam( paramName ) {
            var reParam = new RegExp( '(?:[\?&]|&)' + paramName + '=([^&]+)', 'i' );
            var match = window.location.search.match( reParam );

            return ( match && match.length > 1 ) ? match[1] : null;
        }
        // Simulate user action of selecting a file to be returned to CKEditor.
        function returnFileUrl(fileUrl) {

            var funcNum = getUrlParam( 'CKEditorFuncNum' );
           // var fileUrl = '../assets/test/arts.jpg';
            window.opener.CKEDITOR.tools.callFunction( funcNum, fileUrl );
            window.close();
        }
    </script>
</head>
<body>
    <div class="frame-wrapper">
        <div class="file-manager-row">
            <div class="left-panel">
                <ul class="list-menu">
                    <li><a href="#">Sub Menu 1</a></li>
                    <li><a href="#">Sub Menu 1</a></li>
                    <li><a href="#">Sub Menu 1</a></li>
                    <li><a href="#">Sub Menu 1</a></li>
                    <li><a href="#">Sub Menu 1</a></li>
                </ul>
               
            </div>
            <div class="right-panel">
                <div class="blocks-gallery">
                    <?php foreach($filemanagerFiles as $myFile){ ?>
                    <div class="block">
                        <div class="inner" onclick="returnFileUrl('{{ asset('storage/app/public/content/'.$myFile->mm_filename) }}')">
                            <?php if(in_array($myFile->mm_extension,['jpg','jpeg','gif','png','svg','bmp'])){ ?>
                                <img src="{{ asset('storage/app/public/content/'.$myFile->mm_filename) }}" />
                            <?php }else if(in_array($myFile->mm_extension,['pdf'])){ ?>
                                <img src="{{ asset('assets/admin/images/pdf.png') }}" />    
                            <?php }else if(in_array($myFile->mm_extension,['mp3,mp4'])){ ?>
                                <img src="{{ asset('assets/admin/images/audio.png') }}" />   
                            <?php } ?>
                            <div class="details">
                                <span class="title">{{ $myFile->mm_original_filename }}</span>
                                <span class="sub-title">{{ date('d F,Y h:i A',strtotime($myFile->mm_created_at)) }}</span>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php /*
                    <div class="block">
                        <div class="inner ">
                            <div class="folder">
                                <span class="folder-name">Videos</span>
                            </div>

                        </div>
                    </div>
                    */ ?>
                    
                </div>
                <div class="editorPagination"> {{ $filemanagerFiles->appends(Input::except('page'))->links() }}</div>
            </div>
        </div>
    </div>
    <?php /*
    <ul class="imageWrapper">
        <?php foreach($filemanagerFiles as $myFile){ ?>
             <li onclick="returnFileUrl('{{ asset('assets/test/'.$myFile['basename']) }}')">
                <img src="{{ asset('assets/test/'.$myFile['basename']) }}" />
            </li>
        <?php } ?>
    </ul>
    */?>
</body>
</html>