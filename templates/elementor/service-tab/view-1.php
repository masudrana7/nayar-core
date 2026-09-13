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
 * @var $link                       string
 * @var $title                      string
 * @var $title_tag                  string
 * @var $sub_title                  string
 * @var $service_image              string
 * @var $thumb_display              string
 * @var $items                      string
 * @var $button_text                string
 * @var $button_display             string
 * @var $project_thumbnail_size     string
 */

$thumb_size = '';
if( $project_thumbnail_size ) {
	$thumb_size = $project_thumbnail_size;
} else {
	$thumb_size = 'nayar-size1';
}
use Elementor\Icons_Manager;

?>

<div class="service-tab">
    <div class="list-feature">
        <ul>
            <?php
            $i = 0;
            foreach ( $items as $item ) : ?>
            <li>
	            <?php  if('icon' == $item['icon_type'] || 'image' == $item['icon_type']) : ?>
                    <span class="icon-holder">
                        <?php
                        if('icon' == $item['icon_type']) {
                            Icons_Manager::render_icon( $item['bgicon'] );
                        } elseif ('icon_image' == $item['icon_type']) {
                            echo wp_get_attachment_image( $item['icon_image']['id'], 'full' );
                        }
                    ?>
                </span>
	            <?php endif; ?>
                <a href="#" class="list-item" data-list-hover="<?php echo esc_attr($i); ?>">
                    <<?php echo esc_attr( $title_tag ); ?> class="list-title"><?php nayar_html( $item['title'], 'allow_title' ); ?></<?php echo esc_attr( $title_tag ); ?>>
                    <span class="list-sub-title"><?php nayar_html( $item['sub_title'], 'allow_title' ); ?></span>
                </a>
            </li>
            <?php $i++; endforeach; ?>
        </ul>
    </div>
    <div class="image-items">
        <?php
        $i = 0;
        foreach ( $items as $item ) :
            $attr = '';
            if ( !empty( $item['url']['url'] ) ) {
                $attr  = 'href="' . $item['url']['url'] . '"';
                $attr .= !empty( $item['url']['is_external'] ) ? ' target="_blank"' : '';
                $attr .= !empty( $item['url']['nofollow'] ) ? ' rel="nofollow"' : '';
                $attr .= ' aria-label="info link"';
            }
            ?>
            <div class="image-item active" data-list-img="<?php echo esc_attr( $i ); ?>" style="overflow: hidden;">
                <?php if( !empty( $item['image']['id'] ) ) { ?>
	                <?php echo wp_get_attachment_image( $item['image']['id'], $thumb_size ); ?>
	            <?php } if( $button_display == 'yes' ) { ?>
                    <div class="rt-button"><a class="btn button-3" <?php echo wp_kses_post( $attr ); ?>><i class="icon-rt-calendar"></i><?php echo esc_html( $item['button_text'] ); ?><i class="icon-rt-right-arrow"></i></a></div>
                <?php } ?>
            </div>
        <?php  $i++; endforeach; ?>
    </div>
</div>