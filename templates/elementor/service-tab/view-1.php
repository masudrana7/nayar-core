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
 * @var $show_section_title       string
 * @var $st_top_sub_title         string
 * @var $st_title                 string
 * @var $st_description           string
 * @var $st_sub_title_style       string
 * @var $st_main_title_tag        string
 * @var $st_title_image_aline     string
 * @var $st_icon_position         string
 */

$thumb_size = '';
if( $project_thumbnail_size ) {
	$thumb_size = $project_thumbnail_size;
} else {
	$thumb_size = 'nayar-size1';
}
use Elementor\Icons_Manager;

?>

<?php
/* Section Title — same markup/classes as RT Section Title > Layout 01 */
$show_section_title = ! empty( $show_section_title ) ? $show_section_title : '';
$st_top_sub_title   = isset( $st_top_sub_title ) ? $st_top_sub_title : '';
$st_title           = isset( $st_title ) ? $st_title : '';
$st_description     = isset( $st_description ) ? $st_description : '';
?>

<div class="service-tab">
    <div class="list-feature">

        <?php
        if ( 'yes' === $show_section_title && ( $st_top_sub_title || $st_title || $st_description ) ) :
        $st_sub_title_style               = isset( $st_sub_title_style ) ? $st_sub_title_style : 'default';
        $st_main_title_tag                = ! empty( $st_main_title_tag ) ? $st_main_title_tag : 'h2';
        $st_title_image_aline             = isset( $st_title_image_aline ) ? $st_title_image_aline : '';
        $st_title_gradient_animation      = isset( $st_title_gradient_animation ) ? $st_title_gradient_animation : '';
        $st_title_gradient_change_display = isset( $st_title_gradient_change_display ) ? $st_title_gradient_change_display : '';
        $st_icon_position                 = isset( $st_icon_position ) ? $st_icon_position : 'left';
        ?>
        <div class="section-title-wrapper">
            <div class="title-inner-wrapper">
                <!--Top Sub Title-->
                <?php if ( $st_top_sub_title ) : ?>
                    <div class="top-sub-title-wrap">
					    <span class="top-sub-title <?php echo esc_attr( $st_sub_title_style ); ?>">
						<?php
                        $st_icon_type  = ! empty( $st_top_title_icon_type ) ? $st_top_title_icon_type : 'icon';
                        $st_image_html = '';
                        if ( 'image' === $st_icon_type && ! empty( $st_top_title_image['url'] ) ) {
                            $st_image_html = ! empty( $st_top_title_image['id'] )
                                ? wp_get_attachment_image( $st_top_title_image['id'], 'full', false, [ 'class' => 'sub-title-image' ] )
                                : '<img class="sub-title-image" src="' . esc_url( $st_top_title_image['url'] ) . '" alt="">';
                        }
                        $st_icon = ( 'icon' === $st_icon_type && ! empty( $st_top_title_icon ) ) ? $st_top_title_icon : '';

                        if ( 'left' === $st_icon_position || 'both' === $st_icon_position ) {
                            if ( $st_image_html ) {
                                echo '<span class="sub-title-image-wrap" style="margin-right:5px;display:inline-flex;vertical-align:middle">' . $st_image_html . '</span>';
                            } elseif ( $st_icon ) {
                                echo '<i style="margin-right:5px" class="' . esc_attr( $st_icon ) . '" aria-hidden="true"></i>';
                            }
                        }
                        echo esc_html( $st_top_sub_title );
                        if ( 'right' === $st_icon_position || 'both' === $st_icon_position ) {
                            // Right side defaults to the left icon/image (mirrored icon).
                            $st_right_image_html = $st_image_html;
                            $st_right_icon       = $st_icon;
                            $st_right_icon_style = 'margin-left:5px;transform:scaleX(-1)';

                            // Use the separate right icon/image when set.
                            $st_right_type = ! empty( $st_top_title_right_icon_type ) ? $st_top_title_right_icon_type : 'icon';
                            if ( 'image' === $st_right_type && ! empty( $st_top_title_right_image['url'] ) ) {
                                $st_right_image_html = ! empty( $st_top_title_right_image['id'] )
                                    ? wp_get_attachment_image( $st_top_title_right_image['id'], 'full', false, [ 'class' => 'sub-title-image-right' ] )
                                    : '<img class="sub-title-image-right" src="' . esc_url( $st_top_title_right_image['url'] ) . '" alt="">';
                                $st_right_icon       = '';
                            } elseif ( 'icon' === $st_right_type && ! empty( $st_top_title_right_icon ) ) {
                                $st_right_image_html = '';
                                $st_right_icon       = $st_top_title_right_icon;
                                $st_right_icon_style = 'margin-left:5px';
                            }

                            if ( $st_right_image_html ) {
                                echo '<span class="sub-title-image-wrap" style="margin-left:5px;display:inline-flex;vertical-align:middle">' . $st_right_image_html . '</span>';
                            } elseif ( $st_right_icon ) {
                                echo '<i style="' . esc_attr( $st_right_icon_style ) . '" class="' . esc_attr( $st_right_icon ) . '" aria-hidden="true"></i>';
                            }
                        }
                        ?>
					</span>
                    </div>
                <?php endif; ?>

                <!--Main Title-->
                <?php if ( $st_title ) : ?>
                    <<?php echo esc_attr( $st_main_title_tag ); ?> class="main-title <?php echo esc_attr( $st_title_gradient_animation ); ?> <?php echo esc_attr( $st_title_gradient_change_display ); ?> <?php echo esc_attr( $st_title_image_aline ); ?>"><?php nayar_html( $st_title, 'allow_title' ); ?></<?php echo esc_attr( $st_main_title_tag ); ?>>
                <?php endif; ?>

                <!--Description-->
                <?php if ( $st_description ) : ?>
                    <div class="description"><?php nayar_html( $st_description, 'allow_title' ); ?></div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
        <ul>
            <?php
            $i = 0;
            foreach ( $items as $item ) : ?>
            <li>
                <a href="#" class="list-item" data-list-hover="<?php echo esc_attr($i); ?>">
                    <<?php echo esc_attr( $title_tag ); ?> class="list-title"><?php nayar_html( $item['title'], 'allow_title' ); ?></<?php echo esc_attr( $title_tag ); ?>>
                    <span class="list-sub-title"><?php nayar_html( $item['sub_title'], 'allow_title' ); ?></span>
                </a>
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
