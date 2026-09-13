<?php
//phpcs:disable
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 * @var $button_style       string
 * @var $button_icon        string
 * @var $animation          string
 * @var $animation_effect   string
 * @var $delay              string
 * @var $duration           string
 * @var $icon_position      string
 *
 */

$attr = '';
if ( ! empty( $link['url'] ) ) {
	$attr  = 'href="' . esc_url( $link['url'] ) . '"';
	$attr .= ! empty( $link['is_external'] ) ? ' target="_blank"' : '';
	$attr .= ! empty( $link['nofollow'] ) ? ' rel="nofollow"' : '';
}

?>

<div class="rt-button <?php echo esc_attr( $animation );?> <?php echo esc_attr( $animation_effect );?>" data-wow-delay="<?php echo esc_attr( $delay );?>ms" data-wow-duration="<?php echo esc_attr( $duration );?>ms">
	<?php if( !empty( $button_text ) ) { ?>

            <?php if( '2' === $button_style ) { ?>
                <a class="rt-primary-btn btn button-<?php echo esc_attr( $button_style ); ?> <?php if( !empty( $icon_position ) ) { ?><?php echo esc_attr( $icon_position ); ?><?php } ?>" <?php echo wp_kses_post( $attr ); ?> aria-label="button link">
	                <?php echo esc_html( $button_text );?>
	                <?php \Elementor\Icons_Manager::render_icon( $button_icon ); ?>
                </a>
            <?php } else{ ?>
                <a class="rt-button rt-button-<?php echo esc_attr( $button_style ); ?> <?php if( !empty( $icon_position ) ) { ?><?php echo esc_attr( $icon_position ); ?><?php } ?>" <?php echo wp_kses_post( $attr ); ?> aria-label="button link">
                    <span class="rt-primary-btn button-<?php echo esc_attr( $button_style ); ?>">
                        <?php echo esc_html( $button_text );?>
                    </span>
                    <?php if( $button_icon ) { ?>
                        <span class="icon-area">
                            <?php \Elementor\Icons_Manager::render_icon( $button_icon ); ?>
                        </span>
                    <?php } ?>
                </a>
			<?php } ?>
	<?php } ?>
</div>