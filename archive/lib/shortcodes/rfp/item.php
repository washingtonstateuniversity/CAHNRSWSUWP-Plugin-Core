<?php namespace WSUWP\CAHNRSWSUWP_Plugin_Core;

?><div class="rfp-item">
	<h3><?php echo esc_html( $title ); ?></h3>
	<div class="cc-item-date">Due: <?php echo esc_html( $date ); ?></div>
	<div class="cc-item-excerpt"><?php echo wp_kses_post( $excerpt ); ?></div>
	<?php if ( ! empty( $link_src ) ) : ?><div class="cc-item-link"><a href="<?php echo esc_url( $link_src ); ?>"><?php echo esc_html( $title ); ?></a></div><?php endif; ?>
</div>
