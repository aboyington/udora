﻿angular.module('ng-mediasoft.uploader', [])
.directive('photouploader', ['$http', 'gamifyHTTP', function ($http, gamifyHTTP) {
//.directive('photouploader', function ($http) {
    return {
        restrict: 'EA',
        replace: true,
        scope: {
            handlerpath: '@',
            pickfilecaption: '@',
            maxfilesize: '@',
            chunksize: '@',
            plupload_root: '@',
            headers: '@',
            extensiontitle: '@',
            extensions: '@',
            maxallowedfiles: '@',
            photoname: '@',
            updatehandler: '@',
            photowidth: '@',
            photoheight: '@',
            photocss: '@',
            photopath: '@',
            photoname: '@',
            defaultphoto: '@',
            removehandler: '@',
            photoid: '@'
        },
       // templateUrl: "/gamify-assets/app/templates/directive/singlephoto.html",
        templateUrl: "/production/gamify-assets/app/templates/directive/singlephoto.html",
        link: function (scope, element, attrs) {
            scope.isAction = false;
            scope.path = scope.photopath + scope.photoname;
            scope.tempphoto = "";
            $(function () {
                var photouploader = new plupload.Uploader({
                    runtimes: 'html5,flash,silverlight',
                    browse_button: 'pickfiles',
                    container: 'plupload_container',
                    max_file_size: scope.max_file_size,
                    unique_names: true,
                    //chunk_size: scope.chunk_size,
                    url: scope.handlerpath,
                    flash_swf_url: scope.plupload_root + "/js/plupload.flash.swf",
                    silverlight_xap_url: scope.plupload_root + "/js/plupload.silverlight.xap",
                    headers: scope.headers,
                    filters: [
                        { title: scope.extensiontitle, extensions: scope.extensions }
                    ]
                });

                photouploader.bind('Init', function (up, params) { });
                $('#plupload_container').on({
                    click: function (e) {
                        photouploader.start();
                        e.preventDefault();
                        return false;
                    }
                }, '#pickfiles');
                photouploader.init();
                photouploader.bind('FilesAdded', function (up, files) {
                    if (scope.photoname != "") {
                        scope.tempphoto = scope.photoname;
                    }
                    console.log("temp photo is " + scope.tempphoto)
                    var count = 0;
                    $.each(files, function (i, file) {
                        count++;
                    });
                    if (count > 1) {
                        $.each(files, function (i, file) {
                            photouploader.removeFile(file);
                        });
                        alert("Please select only one photo!")
                        return false;
                    } else {
                        photouploader.start();
                    }
                    up.refresh();
                });
                photouploader.bind('UploadProgress', function (up, file) {
                    $('#' + file.id + " b").html(file.percent + "%");
                });
                photouploader.bind('Error', function (up, err) {
                    $('#modalmsg').append("<div>Error: " + err.code +
                        ", Message: " + err.message +
                        (err.file ? ", File: " + err.file.name : "") +
                        "</div>"
                    );
                    up.refresh(); // Reposition Flash/Silverlight
                });
                photouploader.bind('FileUploaded', function (up, file, info) {
                    var rpcResponse = JSON.parse(info.response);
                    var result;
                    if (typeof (rpcResponse) != 'undefined' && rpcResponse.result == 'OK') {
                        // uploaded successfully
                        if (rpcResponse.filetype == '.jpg' || rpcResponse.filetype == '.jpeg' || rpcResponse.filetype == '.png' || rpcResponse.filetype == '.gif') {
                            scope.photoname = rpcResponse.fname;
                            var _url = scope.photopath + "" + rpcResponse.fname;
                            scope.path = _url;
                            if (scope.updatehandler != "") {
                                updateRecord();
                            }
                        } else { /* normal */ }
                    } else {
                        var code;
                        var message;
                        if (typeof (rpcResponse.error) != 'undefined') {
                            code = rpcResponse.error.code;
                            message = rpcResponse.error.message;
                            if (message == undefined || message == "") {
                                message = rpcResponse.error.data;
                            }
                        } else {
                            code = 0;
                            message = "Error uploading the file to the server";
                        }
                        photouploader.trigger("Error", {
                            code: code,
                            message: message,
                            file: File
                        });
                    }
                });
            });

            var removeSuccess = function (data, status) {
                console.log(data)
            };
            var actionError = function (data, status, headers, config) {
                $scope.message = "Error occured";
            }

            var actionSuccess = function (data, status) {
                console.log(data)
                if (scope.tempphoto != "" && typeof scope.removehandler != "undefined") {
                    console.log(scope.tempphoto + " to be removed " + scope.removehandler)
                    // remove temp photo
                    gamifyHTTP.actionProcess(scope.removehandler, [{
                        icon: scope.tempphoto
                    }])
                    .success(removeSuccess)
                    .error(actionError);
                }
            };
     
            function updateRecord() {
                if (typeof scope.updatehandler != "undefined") {
                    gamifyHTTP.actionProcess(scope.updatehandler, [{
                        id: scope.photoid,
                        icon: scope.photoname
                    }])
                    .success(actionSuccess)
                    .error(actionError);
                }
            }
            scope.$on('$destroy', function () {

            });
        }
    };
}]);