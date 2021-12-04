if (!$('#blueimp-gallery').length)
    $('body').append('<div id="blueimp-gallery" class="blueimp-gallery">\n\
                     <div class="slides"></div>\n\
                     <h3 class="title"></h3>\n\
                     <a class="prev">&lsaquo;</a>\n\
                     <a class="next">&rsaquo;</a>\n\
                     <a class="close">&times;</a>\n\
                     <a class="play-pause"></a>\n\
                     <ol class="indicator"></ol>\n\
                     </div>')
 $(document).on('touchstart click', '.images-gallery a.preview:not(.skip)', function (e) {
     e.preventDefault();
     var myLinks = new Array();
     var current = $(this).attr('href');
     var curIndex = 0;

     $('.images-gallery a.preview:not(.skip)').each(function (i) {
         var img_href = $(this).attr('href');
         myLinks[i] = img_href;
         if (current == img_href)
             curIndex = i;
     });

     options = {index: curIndex}

     blueimp.Gallery(myLinks, options);

     return false;
 });