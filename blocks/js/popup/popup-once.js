// Popup per session
jQuery( document ).ready(function() {
	if (!sessionStorage.alreadyClicked) {
		jQuery('.wp-site-blocks .ncpopup_overlay').addClass('open');

		jQuery('.wp-site-blocks .ncpopup_close').click(function() {
			jQuery('.wp-site-blocks .ncpopup_overlay').removeClass('open');
		});
		sessionStorage.alreadyClicked = "true";
	}
});