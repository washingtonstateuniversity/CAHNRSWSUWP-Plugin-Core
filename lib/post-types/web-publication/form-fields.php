<?php namespace WSUWP\CAHNRSWSUWP_Plugin_Core;

?><div class="ignite-post-editor">
	<div  class="ignite-field-set">
		<?php for ( $i = 0; $i < 6; $i++ ) : ?>
		<div class="cc-core-contact-set <?php if ( $i > 0 && empty( $authors[ $i ]['name'] ) ) : ?><?php echo 'cc-hidden'; ?><?php endif; ?>" style="<?php if ( $i > 0 && empty( $authors[ $i ]['name'] ) ) : ?><?php echo 'display: none'; ?><?php endif; ?>">
			<div class="ignite-field" style="width: 30%">
				<label for="name">Name:</label>
				<input type="text" id="name" name="_fs_authors[<?php echo esc_attr( $i ); ?>][name]" value="<?php if ( ! empty( $authors[ $i ]['name'] ) ) : ?><?php echo esc_attr( $authors[ $i ]['name'] ); ?><?php endif; ?>" />
			</div>
			<div class="ignite-field" style="width: 30%">
				<label for="email">Email:</label>
				<input type="text" id="email" name="_fs_authors[<?php echo esc_attr( $i ); ?>][email]" value="<?php if ( ! empty( $authors[ $i ]['email'] ) ) : ?><?php echo esc_attr( $authors[ $i ]['email'] ); ?><?php endif; ?>" />
			</div>
			<div class="ignite-field" style="width: 30%">
				<label for="title">Title:</label>
				<input type="text" id="title" name="_fs_authors[<?php echo esc_attr( $i ); ?>][title]" value="<?php if ( ! empty( $authors[ $i ]['title'] ) ) : ?><?php echo esc_attr( $authors[ $i ]['title'] ); ?><?php endif; ?>" />
			</div>
		</div>
		<?php endfor; ?>
		<p>
			<a href="#" class="cc-show-contact">+ Add Author</a>
		</p>
	</div>
	<div  class="ignite-field-set">
		<div class="ignite-field">
			<label for="fs_number">Fact Sheet #:</label>
			<input type="text" id="fs_number" name="_fs_number" value="<?php echo esc_attr( $fs_number ); ?>" />
		</div>
	</div>
</div>
<script>
	jQuery( '.ignite-post-editor' ).on( 
		'click',
		'.cc-show-contact',
		function( event ) {
			event.preventDefault();
			var n = jQuery( this ).closest( '.ignite-field-set' ).find( '.cc-core-contact-set.cc-hidden' ).first();
			if ( n.length > 0 ) {
				n.show().removeClass('cc-hidden');
			} else {
				jQuery( this ).hide();
			} // End if
		}
	);
</script>
