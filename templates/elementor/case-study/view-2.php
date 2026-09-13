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
 * @var $list_items             string
 * @var $animation              string
 * @var $animation_effect       string
 * @var $delay                  string
 * @var $duration               string
 * @var $title_tag              string
 * @var $count_display          string
 * @var $info_display           string
 * @var $read_more_display      string
 * @var $sticky_display         string
 * @var $project_thumbnail_size string
 */

use Elementor\Icons_Manager;

$thumb_size = '';
if( $project_thumbnail_size ) {
	$thumb_size = $project_thumbnail_size;
} else {
	$thumb_size = 'full';
}
?>

<div class="rt-case-study case-study-<?php echo esc_attr( $layout );?>">
    <div class="case-item">
	    <?php $ade = $delay; $adu = $duration;
        foreach( $list_items as $item ) {
            $attr = '';
            if ( !empty( $item['url']['url'] ) ) {
	            $attr  = 'href="' . esc_url( $item['url']['url'] ) . '"';
                $attr .= !empty( $item['url']['is_external'] ) ? ' target="_blank"' : '';
                $attr .= !empty( $item['url']['nofollow'] ) ? ' rel="nofollow"' : '';
                $attr .= ' aria-label="info link"';
            }
            ?>
            <div class="list-item <?php if( $sticky_display == 'yes' ) { ?>sidebar-sticky<?php } ?> <?php echo esc_attr( $animation );?> <?php echo esc_attr( $animation_effect );?>" data-wow-delay="<?php echo esc_attr( $ade );?>ms" data-wow-duration="<?php echo esc_attr( $adu );?>ms">
                <div class="row">
                    <div class="col-xl-8">
                    <?php if( !empty( $item['image']['id'] ) ) { ?>
                        <div class="service-img">
                            <?php echo wp_get_attachment_image( $item['image']['id'], $thumb_size ); ?>
	                        <?php if( ( $count_display == 'yes') && $item['count_title'] ) { ?><div class="rt-number"><?php echo wp_kses_post( nayar_html( $item['count_title'], 'allow_title' ) );?></div><?php } ?>
                        </div>
                    <?php } ?>
                    </div>
                    <div class="col-xl-4">
                        <div class="content-wrap">
                            <div class="content-info">
                                <?php if( $item['title'] ) { ?><<?php echo esc_attr( $title_tag ); ?> class="rt-title"><a class="link" <?php echo wp_kses_post( $attr ); ?>><?php echo wp_kses_post( nayar_html( $item['title'], 'allow_title' ) );?></a></<?php echo esc_attr( $title_tag ); ?>><?php } ?>
                                <?php if( $item['content'] ) { ?><div class="rt-content"><?php echo wp_kses_post( nayar_html( $item['content'], 'allow_title' ) );?></div><?php } ?>
	                            <?php if( $info_display == 'yes' ) { ?>
                                <ul class="case-info">
	                                <?php if( $item['clients'] ) { ?><li><label><?php esc_html_e('Clients: ', 'nayar-core') ?></label><?php echo wp_kses_post( nayar_html( $item['clients'], 'allow_title' ) );?></li><?php } ?>
	                                <?php if( $item['date'] ) { ?><li><label><?php esc_html_e('Date: ', 'nayar-core') ?></label><?php echo wp_kses_post( nayar_html( $item['date'], 'allow_title' ) );?></li><?php } ?>
	                                <?php if( $item['category'] ) { ?><li><label><?php esc_html_e('Category: ', 'nayar-core') ?></label><?php echo wp_kses_post( nayar_html( $item['category'], 'allow_title' ) );?></li><?php } ?>
	                                <?php if( $item['team'] ) { ?><li><label><?php esc_html_e('Team: ', 'nayar-core') ?></label><?php echo wp_kses_post( nayar_html( $item['team'], 'allow_title' ) );?></li><?php } ?>
                                </ul>
	                            <?php } ?>
	                            <?php if( $read_more_display == 'yes' ) { ?>
                                    <div class="rt-button"><a class="btn button-2" <?php echo wp_kses_post( $attr ); ?>><?php echo wp_kses_post( nayar_html( $item['button_text'], 'allow_title' ) );?><?php Icons_Manager::render_icon( $item['list_icon'] ); ?></a></div>
	                            <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php $ade = $ade + 200; $adu = $adu + 0; } ?>
    </div>
</div>