<?php
//phpcs:disable
/**
 * Elmentor Header Footer Builder Controller
 *
 * @package nayar-core
 */

namespace RT\NayarCore\Controllers;
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
use RT\NayarCore\Helper\Fns;
use RT\NayarCore\Traits\SingletonTraits;
use RT\NayarCore\Builder\Builder;

class ElmentorBuilderController {
	use SingletonTraits;

	public $nonce_action = 'rt_metabox_nonce';
	public $nonce_field = 'rt_metabox_nonce_secret';

	public static $post_type = 'elementor-nayar';

	/**
	 * register default hooks and actions for WordPress
	 * @return
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'header_footer_posttype' ] );
		//add_action( "save_post_{self::$post_type}", [ $this, 'save_el_nayar' ] );
		add_filter( 'single_template', [ $this, 'load_canvas_template' ] );
		add_action( 'wp', [ $this, 'header_footer_builder_init' ] );
		//Overwrite header and footer template
		add_action( 'wp_head', [ $this, 'wp_head' ] );
	}

	function header_footer_builder_init() {

		if ( Builder::check_builder_visibility( 'header' ) ) {
			add_action( 'get_header', [ $this, 'override_header' ] );
			add_action( 'rt_hf_header_markup', [ $this, 'hfe_render_header' ] );
		}
		if ( Builder::check_builder_visibility( 'footer' ) ) {
			add_action( 'get_footer', [ $this, 'override_footer' ] );
			add_action( 'rt_hf_footer_markup', [ $this, 'hfe_render_footer' ] );
		}
	}

	function wp_head() {
		echo "<style>body{opacity:0;transition: opacity 0.1s 0.1s}body{opacity:1}</style>";
	}


	/**
	 * Register Post type for Elementor Header & Footer Builder templates
	 */
	public function header_footer_posttype() {
		$labels = [
			'name'               => __( 'Header & Footer Builder', 'nayar-core' ),
			'singular_name'      => __( 'Header & Footer Builder', 'nayar-core' ),
			'menu_name'          => __( 'Header & Footer Builder', 'nayar-core' ),
			'name_admin_bar'     => __( 'Header & Footer Builder', 'nayar-core' ),
			'add_new'            => __( 'Add New', 'nayar-core' ),
			'add_new_item'       => __( 'Add New Header or Footer', 'nayar-core' ),
			'new_item'           => __( 'New Template', 'nayar-core' ),
			'edit_item'          => __( 'Edit Template', 'nayar-core' ),
			'view_item'          => __( 'View Template', 'nayar-core' ),
			'all_items'          => __( 'All Templates', 'nayar-core' ),
			'search_items'       => __( 'Search Templates', 'nayar-core' ),
			'parent_item_colon'  => __( 'Parent Templates:', 'nayar-core' ),
			'not_found'          => __( 'No Templates found.', 'nayar-core' ),
			'not_found_in_trash' => __( 'No Templates found in Trash.', 'nayar-core' ),
		];

		$args = [
			'labels'              => $labels,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'exclude_from_search' => true,
			'capability_type'     => 'post',
			'hierarchical'        => false,
			'menu_icon'           => 'dashicons-open-folder',
			'supports'            => [ 'title', 'thumbnail', 'elementor' ],
		];

		register_post_type( self::$post_type, $args );

	}

	public function save_el_nayar( $post_id ) {
		if ( empty( $_POST[ $this->nonce_field ] ) || ! check_admin_referer( $this->nonce_action, $this->nonce_field ) ) {
			return $post_id;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return $post_id;
		}

		if ( ! isset( $_POST['rt_el_builder_meta']['template_type'] ) ) {
			return $post_id;
		}

		$template_type_request = $_POST['rt_el_builder_meta']['template_type'];

		if ( 'default' === $template_type_request ) {
			self::unset_hf_default( 'header', $post_id );
			self::unset_hf_default( 'footer', $post_id );
		}

		if ( 'header' === $template_type_request ) {
			self::save_hf_builder_ids( 'header', $post_id );
		}

		if ( 'footer' === $template_type_request ) {
			self::save_hf_builder_ids( 'footer', $post_id );
		}
	}

	function save_hf_builder_ids( $type, $post_id ) {
		//Swap header-footer builder key by $type
		$header_key = $type == 'header' ? 'rt_hf_header' : 'rt_hf_footer';
		$foote_keys = $type == 'header' ? 'rt_hf_footer' : 'rt_hf_header';

		//get header-footer ids. It can change by depend on the $type
		$footer_ids = get_option( $foote_keys );
		$header_ids = get_option( $header_key );

		//Check is the valued exist in (header or footer) by depend on the $type template
		if ( is_array( $footer_ids ) ) {
			if ( in_array( $post_id, $footer_ids ) ) {
				$remove_item = array_diff( $footer_ids, [ $post_id ] );
				update_option( $foote_keys, array_unique( $remove_item ) );
			}
		} else {
			if ( $footer_ids == $post_id ) {
				delete_option( $foote_keys );
			}
		}

		//Save post id in options
		$save_pid = [ $post_id ];

		if ( ! $header_ids ) {
			update_option( $header_key, $save_pid );
		} else {
			if ( is_array( $header_ids ) && ! in_array( $post_id, $header_ids ) ) {
				$save_pid = array_merge( $header_ids, $save_pid );
				update_option( $header_key, array_unique( $save_pid ) );
			}

		}

	}

	public function unset_hf_default( $type, $post_id ) {
		$_key   = $type == 'header' ? 'rt_hf_header' : 'rt_hf_footer';
		$hf_ids = get_option( $_key );
		//Check is the valued exist in footer template
		if ( ! empty( $hf_ids ) ) {
			if ( in_array( $post_id, $hf_ids ) ) {
				$remove_item = array_diff( $hf_ids, [ $post_id ] );
				update_option( $_key, array_unique( $remove_item ) );
			}
		} else {
			if ( $hf_ids == $post_id ) {
				delete_option( $_key );
			}
		}
	}

	function load_canvas_template( $single_template ) {
		global $post;

		if ( self::$post_type == $post->post_type ) {
			$elementor_2_0_canvas = ELEMENTOR_PATH . '/modules/page-templates/templates/canvas.php';

			if ( file_exists( $elementor_2_0_canvas ) ) {
				return $elementor_2_0_canvas;
			} else {
				return ELEMENTOR_PATH . '/includes/page-templates/canvas.php';
			}
		}

		return $single_template;
	}

	public function override_header() {
		require NAYAR_CORE_BASE_DIR . 'templates/builder/header.php';
		$templates   = [];
		$templates[] = 'header.php';
		// Avoid running wp_head hooks again.
		remove_all_actions( 'wp_head' );
		ob_start();
		locate_template( $templates, true );
		ob_get_clean();
	}

	public function override_footer() {
		require NAYAR_CORE_BASE_DIR . 'templates/builder/footer.php';
		$templates   = [];
		$templates[] = 'footer.php';
		// Avoid running wp_footer hooks again.
		remove_all_actions( 'wp_footer' );
		ob_start();
		locate_template( $templates, true );
		ob_get_clean();
	}

	function hfe_render_header() {
		if ( false == apply_filters( 'nayar_header_builder_enable', true ) ) {
			return;
		}

		?>

        <!-- preloader -->
		<?php if ( nayar_option( 'rt_preloader' ) ) {
			if( !empty( nayar_option( 'rt_preloader_logo' ) ) ) { ?>
                <div id="preloader"><?php echo wp_get_attachment_image( nayar_option( 'rt_preloader_logo' ), 'full', true );?></div>
			<?php } else { ?>
                <div id="preloader" class="loader">
                    <div class="cssload-loader">
                        <div class="cssload-inner cssload-one"></div>
                        <div class="cssload-inner cssload-two"></div>
                        <div class="cssload-inner cssload-three"></div>
                    </div>
                </div>
			<?php }
		}
		?>
        <header id="masthead" class="site-header headroom nayar-header-builder" role="banner">
			<?php Builder::get_elementor_content( 'header' ); ?>
        </header>

		<?php get_template_part( 'views/header/offcanvas', 'drawer' ); ?>

        <div id="header-search" class="header-search">
            <div class="header-search-wrap">
                <button type="button" aria-label="close button" class="close">×</button>
                <form method="get" class="header-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <input type="search" value="<?php echo get_search_query(); ?>" name="s" placeholder="<?php esc_attr_e( 'Type your search........', 'nayar-core' ); ?>">
                    <button type="submit" aria-label="submit button" class="search-btn"><i class="icon-rt-search"></i></button>
                </form>
            </div>
        </div>

		<?php

	}

	function hfe_render_footer() {

		if ( false == apply_filters( 'nayar_footer_builder_enable', true ) ) {
			return;
		}
		?>
        <footer class="site-footer nayar-footer-builder" role="contentinfo">
			<?php Builder::get_elementor_content( 'footer' ); ?>
        </footer>
		<?php nayar_scroll_top(); ?>
		<?php

	}
}
