<?php
//phpcs:disable
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 * @var $number             string
 * @var $unit               string
 * @var $title              string
 * @var $layout             string
 * @var $counter_shape      string
 * @var $icon_type          string
 * @var $counter_icon       string
 * @var $speed              string
 * @var $steps              string
 * @var $shape_display      string
 * @var $gradient_display   string
 * @var $animation          string
 * @var $animation_effect   string
 * @var $delay              string
 * @var $duration           string
 * @var $scroll_animation   string
 * @var $range_one          string
 * @var $range_two          string
 * @var $x_range            string
 * @var $y_range            string
 *
 */
use Elementor\Icons_Manager;
$range_one = ( $scroll_animation == 'yes' ) ? $range_one : '';
$range_two = ( $scroll_animation == 'yes' ) ? $range_two : '';

$shape_class = ( $title_shape_display == 'yes' ) ? 'yes' : 'no';


?>

<div class="rt-counter-layout rt-counter-<?php echo esc_attr( $layout ." title_shape_". $shape_class ) ?>" data-parallax='{"<?php echo esc_attr( $x_range );?>" : <?php echo esc_attr( $range_one );?>, "<?php echo esc_attr( $y_range );?>" : <?php echo esc_attr( $range_two );?>}'>
	<div class="rt-counter-box <?php echo esc_attr( $animation );?> <?php echo esc_attr( $animation_effect );?>" data-wow-delay="<?php echo esc_attr( $delay );?>ms" data-wow-duration="<?php echo esc_attr( $duration );?>ms">
		<?php if( $layout !== 'layout-4' && 'icon' == $icon_type ) { ?>
            <div class="bg-shape">
                <?php if('icon' == $icon_type) {
	                Icons_Manager::render_icon( $counter_icon );
                } ?>
            </div>
		<?php } ?>

        <div class="counter-wrap">
		<?php if( $layout == 'layout-2' ) { ?>
            <p class="counter-label"><?php nayar_html( $title, 'allow_title' );?></p>
		<?php } ?>

        <div class="counter-number <?php echo esc_attr( $gradient_display ) ?>">
            <span class="counter" data-num="<?php echo esc_html( $number ); ?>" data-rtspeed="<?php echo esc_attr( $speed );?>" data-rtsteps="<?php echo esc_attr( $steps );?>"><?php echo esc_html( $number ); ?></span>
            <?php if( $unit ) { ?><span class="counter-unit"><?php echo esc_html( $unit ); ?></span><?php } ?>
        </div>
		<?php if( $layout !== 'layout-2') { ?>
            <p class="counter-label"><?php nayar_html( $title, 'allow_title' );?></p>
		<?php } ?>
        </div>

		<?php if( $layout == 'layout-1' && $shape_display == 'yes' ) { ?>
            <span class="counter-blr-shape <?php echo esc_attr( $counter_shape ); ?>"></span>
        <?php } ?>
    </div>
</div>