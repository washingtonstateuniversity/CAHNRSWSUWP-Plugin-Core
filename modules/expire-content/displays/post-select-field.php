<?php namespace WSUWP\CAHNRSWSUWP_Plugin_Core;

?><div class="misc-pub-section">
	<label>Expire After:</label>
	<select name="_expire_in">
	<?php foreach ( $expire_options as $value => $label ) : ?>
		<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $value, $current_expire ); ?> ><?php echo esc_html( $label ); ?></option>
	<?php endforeach; ?>
	</select>
</div>
