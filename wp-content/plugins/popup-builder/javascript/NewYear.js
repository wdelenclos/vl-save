function SGPBNewYear() {

}

SGPBNewYear.prototype.init = function() {

	var dontSowAgain = jQuery('.sgpb-new-year-dont-show');

	if (!dontSowAgain.length) {
		return false;
	}

	dontSowAgain.bind('click', function() {
		jQuery('.sg-info-panel-wrapper').remove();
		var nonce = jQuery(this).attr('data-ajaxnonce');
		var data = {
			nonce: nonce,
			action: 'sgpbNewYear'
		};

		jQuery.post(ajaxurl, data, function() {

		})
	});
};

jQuery(document).ready(function() {
	var newYearObj = new SGPBNewYear();
	newYearObj.init();
});