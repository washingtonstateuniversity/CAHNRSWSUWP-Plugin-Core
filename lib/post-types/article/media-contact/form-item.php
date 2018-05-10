<?php namespace WSUWP\CAHNRSWSUWP_Plugin_Core;

?><div class="ignite-post-editor <?php if ( 'none' === $display ) : ?> hidden-media<?php endif; ?>"style="display:<?php echo esc_html( $display ); ?>">
	<div  class="ignite-field-set">
		<div class="ignite-field">
			<label for="firstname">First Name:</label>
			<input type="text" id="firstname" name="_firstname_<?php echo esc_html( $i ); ?>" value="<?php echo esc_html( $firstname ); ?>" />
		</div>
		<div class="ignite-field">
			<label for="lastname">Last Name:</label>
			<input type="text" id="lastname" name="_lastname_<?php echo esc_html( $i ); ?>" value="<?php echo esc_html( $lastname ); ?>" />
		</div>
		<div class="ignite-field">
			<label for="title">Title:</label>
			<input type="text" id="title" name="_title_<?php echo esc_html( $i ); ?>" value="<?php echo esc_html( $title ); ?>" />
		</div>
		<div class="ignite-field">
			<label for="email">Email Address:</label>
			<input type="text" id="email" name="_email_<?php echo esc_html( $i ); ?>" value="<?php echo esc_html( $email ); ?>" />
		</div>
		<div class="ignite-field">
			<label for="phone">Phone Number:</label>
			<input type="text" id="phone" name="_phone_<?php echo esc_html( $i ); ?>" value="<?php echo esc_html( $phone ); ?>" />
		</div>
	</div>
</div>
