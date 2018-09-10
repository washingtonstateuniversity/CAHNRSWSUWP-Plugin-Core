<fieldset class="core-post-feed-filters">
	<?php foreach ( $filters_array as $filter ) : ?>
	<div class="core-post-feed-filter <?php echo esc_attr( $filter['taxonomy'] ); ?>-filter">
		<label><?php echo esc_html( $filter['label'] ); ?></label>
		<div class="select-filter">
			<select name="taxonomies[<?php echo esc_attr( $filter['taxonomy'] ); ?>]" onchange="this.form.submit()">
				<option value="">Select</option>
				<?php foreach ( $filter['term_options'] as $slug => $name ) : ?>
				<option value="<?php echo esc_attr( $slug ); ?>" <?php selected( $slug, $filter['current_value'] ); ?>><?php echo esc_html( $name ); ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<?php endforeach; ?>
</fieldset>
