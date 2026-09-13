<?php
//phpcs:disable
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 * @var $post_limit                 string
 * @var $post_ordering              string
 * @var $post_orderby               string
 * @var $query_type                 string
 * @var $content_count              string
 * @var $content_type               string
 * @var $layout                     string
 * @var $item_space                 string
 * @var $col_xl                     string
 * @var $col_lg                     string
 * @var $col_md                     string
 * @var $col_sm                     string
 * @var $col_xs                     string
 * @var $social_display             string
 * @var $designation_display        string
 * @var $content_display            string
 * @var $title_tag                  string
 * @var $animation                  string
 * @var $animation_effect           string
 * @var $delay                      string
 * @var $duration                   string
 */

use RT\Nayar\Helpers\Fns;

$args = array(
	'post_type'      	=> 'rt-team',
	'posts_per_page' 	=> $post_limit,
	'order' 			=> $post_ordering,
	'orderby' 			=> $post_orderby,
);

if( !empty( $cat_id ) ){
	if( $query_type == 'category'){
		$args['tax_query'] = [ // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
			[
				'taxonomy' => 'rt-team-category',
				'field' => 'term_id',
				'terms' => $cat_id,
			],
		];
	}
}
if( !empty( $post_id ) ){
	if( $query_type == 'posts'){
		$args['post__in'] = $post_id;
	}
}

$query = new WP_Query( $args );
$col_class = "col-xl-{$col_xl} col-lg-{$col_lg} col-md-{$col_md} col-sm-{$col_sm} col-xs-{$col_xs}";
?>
<div class="rt-team-default rt-team-multi-layout-4 team-grid-<?php echo esc_attr( $layout );?>">
    <div class="row <?php echo esc_attr( $item_space );?>">
		<?php $ade = $delay; $adu = $duration; if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
		$query->the_post();
		$id = get_the_ID();
		$designation   	= get_post_meta( $id, 'rt_team_designation', true );
		$socials        = (array) get_post_meta( $id, 'rt_team_socials', true );
		$socials_fields = Fns::get_team_socials();

		if ( $content_type == 'content' ) {
			$content = apply_filters( 'the_content', get_the_content() );
		}
		else {
			$content = apply_filters( 'the_excerpt', get_the_excerpt() );;
		}
		$content = wp_trim_words( $content, $content_count, '' );
		$content = "$content";

		?>
        <div class="<?php echo esc_attr( $col_class );?> <?php echo esc_attr( $animation );?> <?php echo esc_attr( $animation_effect );?>" data-wow-delay="<?php echo esc_attr( $ade );?>ms" data-wow-duration="<?php echo esc_attr( $adu );?>ms">
            <div class="team-item">
                <div class="team-content-wrap">
                    <div class="team-thumbs">
						<?php nayar_post_thumbnail('full'); ?>
                    </div>
                    <div class="team-content">
                        <div class="team-info">
                            <<?php echo esc_attr( $title_tag ) ?> class="team-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></<?php echo esc_attr( $title_tag ) ?>>
						<?php if ( $designation_display ) { ?>
                            <div class="team-designation"><?php echo esc_html( $designation );?></div>
						<?php } if ( $content_display == 'yes' ) { ?>
                            <p><?php nayar_html( $content , false ); ?></p>
						<?php } ?>
	                    <?php if ( $social_display ) { ?>
                            <ul class="team-social">
			                    <?php foreach ( $socials as $key => $value ):
				                    if(! $value){
					                    continue;
				                    }
				                    ?>
				                    <?php if ( !empty( $value ) ): ?>
                                    <li class="social-item"><a class="social-link" target="_blank" href="<?php echo esc_url( $value );?>" aria-label="social link"><i class="<?php echo esc_attr( $socials_fields[$key]['icon'] );?>" aria-hidden="true"></i></a></li>
			                    <?php endif; ?>
			                    <?php endforeach; ?>
                            </ul>
	                    <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<?php $ade = $ade + 200; $adu = $adu + 0; } ?>
	<?php } ?>
</div>
</div>