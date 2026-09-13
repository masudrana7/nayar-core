<?php
//phpcs:disable
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 * @var $logos                      string
 * @var $swiper_data                string
 * @var $logo_color_mode            string
 * @var $display_arrow              string
 * @var $display_pagination         string
 * @var $arrow_hover_visibility     string
 * @var $animation                  string
 * @var $animation_effect           string
 * @var $delay                      string
 * @var $duration                   string
 */

?>
<div class="rt-logo-brand">
    <div class="rt-swiper-slider <?php echo esc_attr( $arrow_hover_visibility ) ?>" data-xld ="<?php echo esc_attr( $swiper_data );?>">
        <div class="swiper-wrapper">
            <?php $ade = $delay; $adu = $duration;
            foreach ( $logos as $logo ):
	            $attr = '';
	            if ( !empty( $logo['url']['url'] ) ) {
		            $attr  = 'href=' . esc_url( $logo['url']['url'] );
		            $attr .= !empty( $logo['url']['is_external'] ) ? ' target=_blank' : '';
		            $attr .= !empty( $logo['url']['nofollow'] ) ? ' rel=nofollow' : '';
	            }

                ?>
                <?php if ( empty( $logo['image']['id'] ) ) continue; ?>
                <div class="swiper-slide">
                    <div class="logo-box <?php echo esc_attr( $logo_color_mode );?> <?php echo esc_attr( $animation );?> <?php echo esc_attr( $animation_effect );?>" data-wow-delay="<?php echo esc_attr( $ade );?>ms" data-wow-duration="<?php echo esc_attr( $adu );?>ms">
                        <?php if( $attr ) : ?>
                        <a <?php echo esc_attr($attr) ?> aria-label="brand logo">
	                    <?php endif ?>
	                        <?php echo wp_get_attachment_image( $logo['image']['id'], 'full' ); ?>
                        <?php if( $attr ) : ?>
                        </a>
                        <?php endif ?>
                    </div>
                </div>
            <?php $ade = $ade + 200; $adu = $adu + 0; endforeach; ?>
        </div>
	    <?php if ( $display_arrow == 'yes' ) { ?>
            <div class="swiper-navigation">
                <div class="swiper-button swiper-button-prev"><i class="icon-rt-left-arrow"></i></div>
                <div class="swiper-button swiper-button-next"><i class="icon-rt-right-arrow"></i></div>
            </div>
	    <?php } ?>
	    <?php if ( $display_pagination == 'yes' ) { ?>
            <div class="swiper-pagination"></div>
	    <?php } ?>
    </div>
</div>