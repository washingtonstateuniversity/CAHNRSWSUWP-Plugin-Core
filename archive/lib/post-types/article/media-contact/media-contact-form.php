<?php namespace WSUWP\CAHNRSWSUWP_Plugin_Core;

?><h2>Media Contacts</h2>
<?php
// @codingStandardsIgnoreStart // Already escaped
echo $form_items_html; 
// @codingStandardsIgnoreEnd
?>
<button class="add-media">Add Additional Contact</button>
<script>
	jQuery('body').on(
		'click',
		'button.add-media',
		function ( event ){
			event.preventDefault();

			jQuery('.hidden-media').first().show().removeClass('hidden-media');

			if ( jQuery('.hidden-media').length < 1 ) {

				jQuery('button.add-media').hide();

			} // End if
		}
	);
</script>
