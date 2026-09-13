<?php
//phpcs:disable
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 * @var $placeholder                      string
 * @var $category_display                 string
 * @var $btn_display                         string
 * @var $button_text                         string
 * @var $popular_text                     string
 * @var $word_repeat                      string
 */

$terms = get_terms( array('taxonomy' => 'product_cat' ) );
$post_type = get_post_type_archive_link( 'product' );

$category_dropdown = array(  0 => __( 'All Category', 'nayar-core' ) );
foreach ( $terms as $category ) {
	$category_dropdown[$category->term_id] = $category->name;
}

?>

<div class="rt-hero-section-search">
    <div class="rt-search-box-container">
        <form class="rt-search-box-form d-flex justify-content-between align-items-center" role="search" method="get" action="<?php echo esc_url( $post_type ); ?>">
            <div class="search-box-text-field">
                <div class="input-area d-flex align-items-center">
                    <div class="input-group-addon rt-input-wrap flex-grow-1">
                        <input type="text" class="search-box-input" name="s" id="searchInput" placeholder="<?php nayar_html( $placeholder, 'allow_title' );?>" autocomplete="off">
                        <span id="cleanText">x</span>
                    </div>
                </div>
            </div>
			<?php if($category_display == 'yes'){?>
                <div class="category-selector">
                    <select name="categories" id="categories">
						<?php foreach ( $category_dropdown as $key => $value ): ?>
                            <option value="<?php echo esc_attr( get_category_link($key) );?>" ><?php echo esc_html( $value );?></option>
						<?php endforeach; ?>
                    </select>
                </div>
			<?php } ?>
            <div class="search-box-submit">
				<?php if($btn_display == 'yes'){  ?>
                    <button class="search-btn coolBeans btn-dark rt-search-box-btn" type="submit">
                        <i class="icon-rt-search"></i> <?php echo esc_html( $button_text );?>
                    </button>
				<?php } else { ?>
                    <button class="search-btn rt-search-hide-text coolBeans btn-dark rt-search-box-btn" type="submit"><i class="icon-rt-filter-2"></i> </button>
				<?php } ?>
            </div>
            <div id="rt_datafetch" class="rt-data-fetch"></div>
        </form>
    </div>

	<?php if($repeat_display == 'yes'){  ?>
    <div class="rt-search-text d-md-flex">
        <span class="popular-label"><?php echo wp_kses_post( $popular_text ); ?></span>
        <ul class="rt-search-key rt-addon-search">
			<?php foreach ( $word_repeat as $rtword ) { ?>
                <li class="keyword"><a href="#"><?php echo wp_kses_post($rtword['searches_word']); ?></a></li>
			<?php } ?>
        </ul>
    </div>
	<?php } ?>

</div>


