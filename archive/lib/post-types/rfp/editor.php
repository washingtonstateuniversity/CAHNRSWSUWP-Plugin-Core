<?php namespace WSUWP\CAHNRSWSUWP_Plugin_Core;

?><div class="cc-editor-form">
	<div class="cc-input-wrap">
		<label>Due Date: ( mm/dd/yy )</label>
		<input value="<?php echo esc_html( $date ); ?>" class="datepicker" name="_post_date" style="width: 150px;" type="text">
	</div>
	<div class="cc-input-wrap">
		<label>Link To: ( Redirect )</label>
		<input value="<?php echo esc_html( $redirect ); ?>" name="_redirect_to" style="width: 90%;" type="text">
	</div>
</div>
