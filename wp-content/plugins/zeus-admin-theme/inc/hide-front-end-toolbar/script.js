jQuery(function($){

	// set initial state of toolbar 
	hide_fe_toolbar_hide(HFETB.hide_fe_toolbar);

	$('#wp-admin-bar-hide').click(function(){
		var hide_toolbar = "false";
		var toolbar_class = 'show-fe-toolbar';

		$('#wpadminbar, html').addClass('transition');

		if(!$('#wpadminbar').hasClass('hide-fe-toolbar')){
			hide_toolbar = "true";
			toolbar_class = 'hide-fe-toolbar';
		}

		hide_fe_toolbar_hide(hide_toolbar);
		
		// fire ajax to update toolbar status, sending css class
		$.post(
			HFETB.ajaxurl,
			{
				// trigger HFETB_state on backend
				action : 'HFETB_state',
		 
				// other parameters can be added along with "action"
				toolbar_class : toolbar_class,

				// nonce value
				ajax_nonce : HFETB.HFETBnonce
			}
		);
	});

	function hide_fe_toolbar_hide(hide){

		if(hide === "true"){
			$('#wpadminbar, html').addClass('hide-fe-toolbar').removeClass('show-fe-toolbar');
		} else {
			$('#wpadminbar, html').addClass('show-fe-toolbar').removeClass('hide-fe-toolbar');
		}
	}

});