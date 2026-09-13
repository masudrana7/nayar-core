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
 * @var $title_tag          string
 * @var $items              string
 * @var $show_readmore_btn  string
 * @var $read_more_btn_visibility string
 * @var $btn_icon_position  string
 * @var $icon_position      string
 * @var $button_icon        string
 * @var $read_more_btn_text string
 * @var $data               string
 * @var $items              array
 * @var $animation          string
 * @var $animation_effect   string
 * @var $delay              string
 * @var $duration           string
 * @var $list_item_layout   string
 */

?>


<div class="rt-contact-info <?php echo esc_attr( $animation );?> <?php echo esc_attr( $animation_effect );?>" data-wow-delay="<?php echo esc_attr( $delay );?>ms" data-wow-duration="<?php echo esc_attr( $duration );?>ms">
    <div class="content-holder">
        <?php if ( $title ) : ?>
            <<?php echo esc_attr( $title_tag ) ?> class="info-title"><?php nayar_html( $title, 'allow_title' );?></<?php echo esc_attr( $title_tag ) ?>>
        <?php endif; ?>
        <ul class="contact-list <?php echo esc_attr( $list_item_layout );?>">
            <?php foreach ( $items as $key => $item):
                $data_type = $item['list_text'];
                if(filter_var($data_type, FILTER_VALIDATE_EMAIL)){
                    $href_value = 'mailto:'. sanitize_email( $data_type );
                } elseif ( preg_match('/^[0-9\-\(\)\/\+\s]*$/', $data_type ) ) {
                    $href_value = 'tel:'.esc_attr($data_type);
                } elseif (filter_var($data_type, FILTER_VALIDATE_URL)) {
                    $href_value = $data_type;
                } else {
                    $href_value = '';
                }
            ?>

            <li class="list <?php if( preg_match('/^[0-9\-\(\)\/\+\s]*$/', $data_type ) ) { ?>phone-no<?php } ?>">
                <?php if ( $item['list_type'] == 'icon_list' ) { ?>
                    <?php if( !empty($item['list_icon']) ) { ?>
                        <?php \Elementor\Icons_Manager::render_icon( $item['list_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        <?php //echo $item['list_text']; ?>
                    <?php } ?>
                <?php } else if ( $item['list_type'] == 'title_list' ) { ?>
                    <span><?php echo esc_html( $item['list_title'] ); ?>:</span>
                <?php } if (!empty( $href_value ) ) { ?>
                    <a href="<?php echo esc_url( $href_value ) ?>"><?php echo esc_html( $item['list_text'] ); ?></a>
                <?php } else { ?>
                    <?php echo esc_html( $item['list_text'] ); ?>
                <?php } ?>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>