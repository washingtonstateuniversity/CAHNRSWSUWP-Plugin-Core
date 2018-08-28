<div class="core-form">
	<fieldset>
		<div class="core-form-content">
            <div class="core-field core-text-field core-field-full-width">
				<label>URL</label>
				<input type="text" name="_publication[url]" value="<?php echo esc_attr( $url_content ); ?>">
			</div>
            <div class="core-field core-text-field">
				<label>Feature</label>
				<input type=checkbox name="_publication[featured]" value="1" <?php checked('1', $feature_content );?>>
			</div>
            <div class="core-field core-text-field">
				<label>External Resource</label>
				<input type=checkbox name="_publication[external]" value="1" <?php checked('1', $external_resources );?>>
			</div>

        </div>
	</fieldset>