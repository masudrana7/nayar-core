<?php
//phpcs:disable
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 * @var $logos                  string
 * @var $item_space             string
 * @var $logo_color_mode        string
 * @var $col_xl                 string
 * @var $col_lg                 string
 * @var $col_md                 string
 * @var $col_sm                 string
 * @var $col_xs                 string
 * @var $animation                  string
 * @var $animation_effect           string
 * @var $delay                      string
 * @var $duration                   string
 */

$col_class = "col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-xs-{$col_xs}";
?>
<div class="rt-logo-brand">
    <div class="row <?php echo esc_attr( $item_space );?>">
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
            <div class="<?php echo esc_attr( $col_class );?>">
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
</div>