var PGSADMIN = (function() {
    var _self = this;
    _self.utils = {
        test: function() {
            console.log('Hello WOrld');
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

            }).error(function(jqXHR, textStatus) {
                $('#commonAjaxLoader').hide();
                callback(jqXHR);

            });


        },
        showTopMessage: function(message) {
            $('#topMessage').html(msg);
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