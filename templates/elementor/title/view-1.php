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
                    if ( $top_title_icon && ( 'left' == $icon_position || 'both' == $icon_position ) ) {
	                    echo '<i style="margin-right:5px" class="' . esc_attr( $top_title_icon ) . '" aria-hidden="true"></i>';
                    }
                    echo esc_html( $top_sub_title );
                    if ( $top_title_icon && ( 'right' == $icon_position || 'both' == $icon_position ) ) {
	                    echo '<i style="margin-left:5px;transform:scaleX(-1)" class="' . esc_attr( $top_title_icon ) . '" aria-hidden="true"></i>';
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
                <li class="<?php echo esc_attr( $animation );?> <?php echo esc_attr( $animation_effect );?>" data-wow-delay="<?php echo esc_attr( $ade );?>ms" data-wow-duration="<?php echo esc_attr( $adu );?>ms"><?php if( $feature['list_icon'] ) { ?><span class="icon"><?php Icons_Manager::render_icon( $feature['list_icon'] ); ?></span><?php } ?><?php echo esc_html( $feature['list_text'] ); ?></li>
            <?php $ade = $ade + 200; $adu = $adu + 0; endforeach; ?>
        </ul>
	    <?php } ?>
    </div>
</div>