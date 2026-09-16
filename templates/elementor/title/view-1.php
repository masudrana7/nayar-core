<?php
//phpcs:disable
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0*
 * @var $top_sub_title                  string
 * @var $sub_title_style                string
 * @var $top_title_icon                 string
 * @var $icon_position                  string
 * @var $title                          string
 * @var $animation_headline_display     string
 * @var $headline_title                 string
 * @var $main_title_tag                 string
 * @var $description                    string
 * @var $feature_lists                  string
 * @var $show_feature_list              string
 * @var $list_column                    string
 * @var $title_image_aline              string
 * @var $title_line_shape               string
 * @var $alignment                      string
 * @var $shadow_title                   string
 * @var $shadow_title_display           string
 * @var $title_gradient_animation       string
 * @var $title_gradient_change_display  string
 * @var $animation                      string
 * @var $animation_effect               string
 * @var $delay                          string
 * @var $duration                       string
 * @var $list_layout                    string
 *
 */
use Elementor\Icons_Manager;

$animation_headline = ( $animation_headline_display == 'yes' ) ? 'rt-animated-headline' : '';

?>
<div class="section-title-wrapper <?php echo esc_attr( $animation_headline );?>">
	<div class="title-inner-wrapper ah-headline">
        <?php if( $shadow_title_display == 'yes' ) { ?><div class="shadow-title-wrap"><span class="shadow-title"><?php echo esc_html( $shadow_title ); ?></span></div><?php } ?>
		<!--Top Sub Title-->
		<?php if ( $top_sub_title ): ?>
			<div class="top-sub-title-wrap <?php echo esc_attr( $animation );?> <?php echo esc_attr( $animation_effect );?>" data-wow-delay="200ms" data-wow-duration="1200ms">
                <span class="top-sub-title <?php echo esc_attr( $sub_title_style );?>">
                    <?php
                    $sub_icon_type  = ! empty( $top_title_icon_type ) ? $top_title_icon_type : 'icon';
                    $sub_image_html = '';
                    if ( 'image' === $sub_icon_type && ! empty( $top_title_image['url'] ) ) {
                        $sub_image_html = ! empty( $top_title_image['id'] )
                            ? wp_get_attachment_image( $top_title_image['id'], 'full', false, [ 'class' => 'sub-title-image' ] )
                            : '<img class="sub-title-image" src="' . esc_url( $top_title_image['url'] ) . '" alt="">';
                    }
                    $sub_icon = ( 'icon' === $sub_icon_type ) ? $top_title_icon : '';

                    if ( 'left' == $icon_position || 'both' == $icon_position ) {
                        if ( $sub_image_html ) {
                            echo '<span class="sub-title-image-wrap" style="margin-right:5px;display:inline-flex;vertical-align:middle">' . $sub_image_html . '</span>';
                        } elseif ( $sub_icon ) {
                            echo '<i style="margin-right:5px" class="' . esc_attr( $sub_icon ) . '" aria-hidden="true"></i>';
                        }
                    }
                    echo esc_html( $top_sub_title );
                    if ( 'right' == $icon_position || 'both' == $icon_position ) {
                        // Right side defaults to the left icon/image (mirrored icon).
                        $right_image_html = $sub_image_html;
                        $right_icon       = $sub_icon;
                        $right_icon_style = 'margin-left:5px;transform:scaleX(-1)';

                        // Use the separate right icon/image when set.
                        $right_type = ! empty( $top_title_right_icon_type ) ? $top_title_right_icon_type : 'icon';
                        if ( 'image' === $right_type && ! empty( $top_title_right_image['url'] ) ) {
                            $right_image_html = ! empty( $top_title_right_image['id'] )
                                ? wp_get_attachment_image( $top_title_right_image['id'], 'full', false, [ 'class' => 'sub-title-image-right' ] )
                                : '<img class="sub-title-image-right" src="' . esc_url( $top_title_right_image['url'] ) . '" alt="">';
                            $right_icon       = '';
                        } elseif ( 'icon' === $right_type && ! empty( $top_title_right_icon ) ) {
                            $right_image_html = '';
                            $right_icon       = $top_title_right_icon;
                            $right_icon_style = 'margin-left:5px';
                        }

                        if ( $right_image_html ) {
                            echo '<span class="sub-title-image-wrap" style="margin-left:5px;display:inline-flex;vertical-align:middle">' . $right_image_html . '</span>';
                        } elseif ( $right_icon ) {
                            echo '<i style="' . esc_attr( $right_icon_style ) . '" class="' . esc_attr( $right_icon ) . '" aria-hidden="true"></i>';
                        }
                    }
                    ?>
                </span>
			</div>
		<?php endif; ?>

		<!--Main Title-->
		<?php if ( $title ): ?>
        <div class="<?php echo esc_attr( $animation );?> <?php echo esc_attr( $animation_effect );?>" data-wow-delay="400ms" data-wow-duration="1200ms">
            <<?php echo esc_attr( $main_title_tag ) ?> class="main-title <?php echo esc_attr( $title_gradient_animation );?> <?php if( $title_gradient_change_display ) { ?><?php echo esc_attr( $title_gradient_change_display );?><?php } ?> <?php if( $title_line_shape ) { ?><?php echo esc_attr( $title_line_shape );?><?php } ?> <?php echo esc_attr( $title_image_aline );?> <?php if( !empty($alignment) ) { ?><?php echo esc_attr( $alignment );?><?php } ?>"><?php nayar_html( $title, 'allow_title' );?>
                <?php if( !empty( $animation_headline ) ) { ?>
                    <div class="ah-words-wrapper">
                        <?php nayar_html( $headline_title, 'allow_title' );?>
                    </div>
                <?php }?>
            </<?php echo esc_attr( $main_title_tag ) ?>>
        </div>
        <?php endif; ?>

        <!--Description-->
        <?php if ( $description ): ?>
            <div class="description <?php echo esc_attr( $animation );?> <?php echo esc_attr( $animation_effect );?>" data-wow-delay="600ms" data-wow-duration="1200ms"><?php nayar_html( $description, 'allow_title' );?></div>
        <?php endif; ?>

	    <?php if ( $feature_lists && $show_feature_list ) { ?>
        <ul class="feature-list <?php echo esc_attr( $list_layout );?> <?php echo esc_attr( $list_column );?>">
	        <?php $ade = $delay; $adu = $duration; foreach ( $feature_lists as $feature): ?>
                <li class="<?php echo esc_attr( $animation );?> <?php echo esc_attr( $animation_effect );?>" data-wow-delay="<?php echo esc_attr( $ade );?>ms" data-wow-duration="<?php echo esc_attr( $adu );?>ms"><?php $list_icon_type = ! empty( $feature['list_icon_type'] ) ? $feature['list_icon_type'] : 'icon'; if ( 'image' === $list_icon_type && ! empty( $feature['list_image']['url'] ) ) { ?><span class="icon icon-image"><?php if ( ! empty( $feature['list_image']['id'] ) ) { echo wp_get_attachment_image( $feature['list_image']['id'], 'full' ); } else { ?><img src="<?php echo esc_url( $feature['list_image']['url'] ); ?>" alt="<?php echo esc_attr( $feature['list_text'] ); ?>"><?php } ?></span><?php } elseif ( 'icon' === $list_icon_type && ! empty( $feature['list_icon']['value'] ) ) { ?><span class="icon"><?php Icons_Manager::render_icon( $feature['list_icon'] ); ?></span><?php } ?><?php echo esc_html( $feature['list_text'] ); ?></li>
            <?php $ade = $ade + 200; $adu = $adu + 0; endforeach; ?>
        </ul>
	    <?php } ?>
    </div>
</div>