<?php
//phpcs:disable
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 * @var $before_image                 string
 * @var $after_image                  string
 *
 */

?>
<div class="beer-slider" id="slider">
    <?php echo wp_get_attachment_image( $before_image['id'], 'full' ); ?>
    <div class="beer-reveal"><?php echo wp_get_attachment_image( $after_image['id'], 'full' ); ?></div>
</div>