jQuery(document).ready(function ($) {

    $('.pt-submit').click(function (e) {
        var thumbWidth = Math.abs($('#pt-thumbnail-width').val());
        var thumbHeight = Math.abs($('#pt-thumbnail-height').val());
        if ((thumbWidth == '' || thumbWidth == 0) && (thumbHeight == '' || thumbHeight == 0)) {
            e.preventDefault();
            alert(ptJsObj.msgThumbnailDimensions);
            return false;
        }
    });

    var uploaderFrame;
    $(document).delegate('#defaultThumbnail', 'click', function (e) {
        e.preventDefault();
        //If the uploader object has already been created, reopen the dialog
        if (uploaderFrame) {
            uploaderFrame.open();
            return;
        }
        //Extend the wp.media object
        uploaderFrame = wp.media.frames.file_frame = wp.media({
            title: ptJsObj.uploadFrameTitle,
            button: {
                text: ptJsObj.uploadFrameText
            },
            multiple: false
        });

        //When a file is selected, grab the URL and set it as the text field's value
        uploaderFrame.on('select', function () {
            attachment = uploaderFrame.state().get('selection').first().toJSON();
            if ('image' == attachment.type) {
                $('#pt-thumbnail-default').val(attachment.url);
            } else {
                $('#pt-thumbnail-default').val('');
            }

        });
        //Open the uploader dialog
        uploaderFrame.open();
    });
});