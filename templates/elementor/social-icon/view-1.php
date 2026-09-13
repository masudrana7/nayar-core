<?php
//phpcs:disable
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 * @var $label                      array
 * @var $title_tag                  array
 * @var $description                array
 * @var $social_icon                array
 * @var $animation                  string
 * @var $animation_effect           string
 * @var $delay                      string
 * @var $duration                   string
 */


?>
<div class="rt-social-icon">
	<?php if ( $label ): ?>
        <label><?php nayar_html( $label, 'allow_title' );?></label>
	<?php endif; ?>
    <div class="rt-social-item">
		<?php $ade = $delay; $adu = $duration;
        foreach ( $social_icon as $social_icons ):
			$attr = '';
			if ( !empty( $social_icons['link']['url'] ) ) {
				$attr  = 'href="' . $social_icons['link']['url'] . '"';
				$attr .= !empty( $social_icons['link']['is_external'] ) ? ' target="_blank"' : '';
				$attr .= !empty( $social_icons['link']['nofollow'] ) ? ' rel="nofollow"' : '';
			}

			$style = '';
			if (!empty($social_icons['icon_color'])) {
				$style .= 'color:' . esc_attr($social_icons['icon_color']) . '; ';
			}
			if (!empty($social_icons['icon_bg_color'])) {
				$style .= 'background-color:' . esc_attr($social_icons['icon_bg_color']) . ';';
			}

			?>
            <a class="<?php echo esc_attr( $animation );?> <?php echo esc_attr( $animation_effect );?>" data-wow-delay="<?php echo esc_attr( $ade );?>ms" data-wow-duration="<?php echo esc_attr( $adu );?>ms" <?php echo wp_kses_post( $attr ); ?> aria-label="Social Icon" style="<?php echo esc_attr( $style ); ?>">
                <?php \Elementor\Icons_Manager::render_icon( $social_icons['social_icon'] ) ; ?>
            </a>
		<?php $ade = $ade + 200; $adu = $adu + 0; endforeach; ?>
    </div>
</div>