<?php
//phpcs:disable
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 * @var $layout                 string
 * @var $link                   string
 * @var $is_featured            string
 * @var $featured_text          string
 * @var $title                  string
 * @var $price                  string
 * @var $period                 string
 * @var $subtitle               string
 * @var $list                   string
 * @var $btn_text               string
 * @var $icon_type              string
 * @var $bgicon                 string
 * @var $image                  string
 * @var $button_icon            string
 * @var $title_tag              string
 * @var $animation              string
 * @var $animation_effect       string
 * @var $delay                  string
 * @var $duration               string
 */

use Elementor\Icons_Manager;
$attr = '';
if ( !empty( $link['url'] ) ) {
	$attr  = 'href="' . esc_url( $link['url'] ) . '"';
	$attr .= !empty( $link['is_external'] ) ? ' target="_blank"' : '';
	$attr .= !empty( $link['nofollow'] ) ? ' rel="nofollow"' : '';
}
?>

<div class="rt-pricing-box-wrapper rt-pricing-<?php echo esc_attr($layout) ?> <?php echo esc_attr($is_featured) ?> <?php echo esc_attr( $animation );?> <?php echo esc_attr( $animation_effect );?>" data-wow-delay="<?php echo esc_attr( $delay );?>ms" data-wow-duration="<?php echo esc_attr( $duration );?>ms">

    <?php if($is_featured == 'is-featured') : ?>
        <div class="is-featured">
            <span><?php echo esc_html($featured_text) ?></span>
        </div>
    <?php endif; ?>
    <header>
        <div class="plan-name-wrap">
            <<?php echo esc_attr( $title_tag ) ?> class="plan-name"><?php echo esc_html($title) ?></<?php echo esc_attr( $title_tag ) ?>>
        </div>

	    <?php if( $subtitle ) { ?>
            <div class="subtitle">
			    <?php echo esc_html($subtitle); ?>
            </div>
	    <?php } ?>

        <div class="price-wrap">
            <span class="price"><?php echo esc_html($price) ?></span>
            <span class="period"><?php echo esc_html($period) ?></span>
        </div>
    </header>

    <hr/>

    <div class="feature-lists">
        <ul>
        <?php
            foreach($list as $item) {
                ?>
                    <li class="elementor-repeater-item-<?php echo esc_attr($item['_id']) ?>">
	                    <?php Icons_Manager::render_icon( $item['list_icon'] ); ?>
                        <span class="list-item"><?php echo esc_html($item['faature_title']) ?></span>
                    </li>
                <?php
            }
        ?>
        </ul>
    </div>

    <div class="rt-button">
        <a class="btn button-3" <?php echo wp_kses_post( $attr ); ?>>
	        <?php echo esc_html( $btn_text );?><?php if( $button_icon ) { ?><?php Icons_Manager::render_icon( $button_icon ); ?><?php } ?>
        </a>
    </div>

    <?php  if('icon' == $icon_type || 'image' == $icon_type) : ?>
        <div class="icon-holder">
            <?php
                if('icon' == $icon_type) {
	                Icons_Manager::render_icon( $bgicon );
                } elseif ('image' == $icon_type) {
                    echo wp_get_attachment_image( $image['id'], 'full' );
                }
            ?>
        </div>
    <?php endif; ?>
</div>
