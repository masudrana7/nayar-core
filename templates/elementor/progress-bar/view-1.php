<?php
//phpcs:disable
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 * @var $title              string
 * @var $percent            string
 * @var $title_tag          string
 * @var $display_percentage string
 * @var $animation          string
 * @var $animation_effect   string
 * @var $delay              string
 * @var $duration           string
 */

$progress_percentage = is_numeric( $percent['size'] ) ? $percent['size'] : '0';

if ( 100 < $progress_percentage ) {
    $progress_percentage = 100;
}

?>
<div class="rt-progress-bar progress-appear">
    <div class="single-skill-wrapper <?php echo esc_attr( $animation );?> <?php echo esc_attr( $animation_effect );?>" data-wow-delay="<?php echo esc_attr( $delay );?>ms" data-wow-duration="<?php echo esc_attr( $duration );?>ms">
        <div class="single-skill <?php if( $display_percentage == 'yes'  ) { ?>is-percentage<?php } ?>">
            <div class="title-bar">
                <<?php echo esc_attr( $title_tag ) ?> class="title"><?php nayar_html( $title, 'allow_title' );?></<?php echo esc_attr( $title_tag ) ?>>
            </div>
            <div class="skill-bar">
                <div class="skill-per" data-per="<?php nayar_html( $progress_percentage, false );?>"></div>
            </div>
        </div>
    </div>
</div>