jQuery(document).ready(function($) {
    $(".bb-pst-wp-color-picker").wpColorPicker();

    $("#bb-pst-form-reset-to-defaults").bind("submit", function() {
        var confirm_message = $("#bb-pst-button-reset-to-defaults").data("message");
        if(confirm(confirm_message)) {
            return true;
        }
        return false;
    });   
});