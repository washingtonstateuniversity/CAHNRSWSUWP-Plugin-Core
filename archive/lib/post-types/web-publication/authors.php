<?php namespace WSUWP\CAHNRSWSUWP_Plugin_Core;

?><div class="web-publication-authors"><p>By: <?php foreach ( $authors as $author ) : ?><?php if ( ! empty( $author['name'] ) ) : ?><strong><?php echo esc_html( $author['name'] ); ?></strong><?php if ( ! empty( $author['title'] ) ) : ?>, <?php echo esc_html( $author['title'] ); ?><?php endif; ?>, <?php endif; ?><?php endforeach; ?></p></div>
