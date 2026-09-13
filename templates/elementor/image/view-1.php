<?php
//phpcs:disable
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 * @var $layout                     string
 * @var $main_image                 string
 * @var $title1                     string
 * @var $title2                     string
 * @var $title3                     string
 * @var $shape_one                  string
 * @var $shape_two                  string
 * @var $shape_three                string
 * @var $shape_four                 string
 * @var $shape_five                 string
 * @var $shape_six                  string
 * @var $position                   string
 * @var $z_index                    string
 * @var $animation                  string
 * @var $duration                   string
 * @var $scroll_animation           string
 * @var $range_one                  string
 * @var $range_two                  string
 * @var $x_range                    string
 * @var $y_range                    string
 * @var $alignment                  string
 * @var $animations                 string
 * @var $animation_effect           string
 * @var $delay                      string
 * @var $durations                  string
 * @var $image_shape                string
 * @var $image_shape_style          string
 * @var $image_overlay_animation    string
 *
 */

$attr = '';
if ( !empty( $link['url'] ) ) {
	$attr  = 'href=' . $link['url'] . '';
	$attr  = 'href=' . esc_url( $link['url'] );
	$attr .= !empty( $link['is_external'] ) ? ' target=_blank' : '';
	$attr .= !empty( $link['nofollow'] ) ? ' rel=nofollow' : '';
}
$range_one = ( $scroll_animation == 'yes' ) ? $range_one : '';
$range_two = ( $scroll_animation == 'yes' ) ? $range_two : '';

$overlay_animation = ( $image_overlay_animation == 'yes' ) ? 'has-animation' : '';
?>

<div class="rt-image-layout rt-loop-animation-<?php echo esc_attr($loop_animation); ?> rt-image-<?php echo esc_attr( $layout ) ?> <?php if( !empty( $alignment ) ) { ?><?php echo esc_attr( $alignment ) ?><?php } ?>">

	<?php if( $layout == 'layout-1' ) { ?>
        <div class="rt-image <?php echo esc_attr( $overlay_animation );?> <?php echo esc_attr( $animations );?> <?php echo esc_attr( $animation_effect );?>" data-wow-delay="<?php echo esc_attr( $delay );?>ms" data-wow-duration="<?php echo esc_attr( $durations );?>ms">
            <div data-parallax='{"<?php echo esc_attr( $x_range );?>" : <?php echo esc_attr( $range_one );?>, "<?php echo esc_attr( $y_range );?>" : <?php echo esc_attr( $range_two );?>}'>
	            <?php if( $attr ) : ?>
                <a <?php echo esc_attr($attr) ?> aria-label="image">
		            <?php endif ?>
		            <?php echo wp_get_attachment_image( $main_image['id'], 'full' ); ?>
		            <?php if( $attr ) : ?>
                </a>
                <?php endif ?>
            </div>
        </div>

		<?php if( $image_shape == 'yes' ) { ?><div class="<?php echo esc_attr( $image_shape_style ); ?>"></div><?php } ?>
    <?php } ?>


	<?php if( $layout == 'layout-2' ) { ?>
        <div class="rt-image <?php echo esc_attr( $overlay_animation );?> <?php echo esc_attr( $animations );?> <?php echo esc_attr( $animation_effect );?>" data-wow-delay="<?php echo esc_attr( $delay );?>ms" data-wow-duration="<?php echo esc_attr( $durations );?>ms" style="position: <?php echo esc_attr( $position ); ?>; z-index: <?php echo esc_attr( $z_index ); ?>">
            <span class="rt-img <?php echo esc_attr( $animation ); ?>" data-parallax='{"<?php echo esc_attr( $x_range );?>" : <?php echo esc_attr( $range_one );?>, "<?php echo esc_attr( $y_range );?>" : <?php echo esc_attr( $range_two );?>}' style="animation-duration: <?php echo esc_attr( $duration ); ?>s">
                <?php if( $attr ) : ?>
                <a <?php echo esc_attr($attr) ?> aria-label="image">
                    <?php endif ?>
                    <?php echo wp_get_attachment_image( $main_image['id'], 'full' ); ?>
                    <?php if( $attr ) : ?>
                </a>
                <?php endif ?>
            </span>
        </div>
	<?php } ?>

</div>