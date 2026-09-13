<?php
//phpcs:disable
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 * @var $display_arrow              string
 * @var $display_pagination         string
 * @var $rating_display             string
 * @var $designation_display        string
 * @var $thumb_display              string
 * @var $layout                     string
 * @var $col_xl                     string
 * @var $col_lg                     string
 * @var $col_md                     string
 * @var $col_sm                     string
 * @var $col_xs                     string
 * @var $items                      string
 * @var $quote_icon                 string
 * @var $quote_display              string
 * @var $item_space                 string
 * @var $title_tag                  string
 * @var $alignment                  string
 * @var $animation                  string
 * @var $animation_effect           string
 * @var $delay                      string
 * @var $duration                   string
 */
use Elementor\Icons_Manager;
$col_class = "col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-xs-{$col_xs}";
?>
<div class="rt-testimonial-slider rt-testimonial-<?php echo esc_attr( $layout ) ?>">
    <div class="row <?php echo esc_attr( $item_space );?>">
        <?php $ade = $delay; $adu = $duration;
        foreach ( $items as $item ): ?>
            <div class="<?php echo esc_attr( $col_class );?> <?php echo esc_attr( $animation );?> <?php echo esc_attr( $animation_effect );?>" data-wow-delay="<?php echo esc_attr( $ade );?>ms" data-wow-duration="<?php echo esc_attr( $adu );?>ms">
                <div class="slider-item <?php if( !empty( $alignment ) ) { ?><?php echo esc_attr( $alignment ) ?><?php } ?>">
                    <div class="testimonial-content">
			            <?php if ( $rating_display ) { ?>
                            <ul class="item-rating">
					            <?php for ( $i=0; $i <=4 ; $i++ ) {
						            if ( $i < $item['rating'] ) {
							            $full = 'active';
						            } else {
							            $full = 'deactive';
						            }
						            echo '<li class="has-rating"><i class="icon-rt-star ' . esc_attr( $full ) . '"></i></li>';
					            } ?>
                            </ul>
			            <?php } ?>
                        <div class="rt-content">
                            <p><?php echo esc_html( $item['content'] ); ?></p>
                        </div>

                        <div class="item-author-info">
		                    <?php if ( $item['image']['id'] && $thumb_display ) {
			                    echo "<div class='testimonial-img'>";
			                    echo wp_get_attachment_image( $item['image']['id'], 'full' );
			                    echo "</div>";
		                    } ?>
                            <div>
                                <<?php echo esc_attr( $title_tag ) ?> class="rt-title"><?php echo esc_html( $item['name'] ); ?></<?php echo esc_attr( $title_tag ) ?>>
                                <?php if ( $item['designation'] && $designation_display ) { ?>
                                    <div class="rt-subtitle"><?php echo esc_html( $item['designation'] ); ?></div>
                                <?php } ?>
                            </div>
                        </div>

		            <?php if ( $quote_display ) { ?><span class="quote"><?php Icons_Manager::render_icon( $quote_icon ); ?></span><?php } ?>
                </div>
            </div>
            </div>
        <?php $ade = $ade + 200; $adu = $adu + 0; endforeach; ?>
    </div>
</div>