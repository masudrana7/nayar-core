<?php
//phpcs:disable
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 * @var $layout             string
 *@var  $image_shape        string
 * @var $animation          string
 * @var $info_icon          string
 *
 *
 */

?>
<div class="moving-shape-wrap">
    <div class="about-round-box">
        <div class="moving-shape-box">
	        <?php \Elementor\Icons_Manager::render_icon( $info_icon, [ 'aria-hidden' => 'true' ] ) ; ?>
            <div class="about-shape">
                <div class="shape <?php echo $animation? 'spin' : ''; ?>">
                    <?php echo wp_get_attachment_image( $image_shape['id'], 'full' ); ?>
                </div>
            </div>
        </div>
    </div>
</div>