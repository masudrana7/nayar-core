<?php
//phpcs:disable

namespace RT\NayarCore\Controllers;
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
use RT\NayarCore\Traits\SingletonTraits;
use RT\Nayar\Options\Opt;
use \RT_Posts;

class PostTypeController {
	use SingletonTraits;

	public $post_type;

	public function __construct() {
		$this->post_type = RT_Posts::getInstance();
		add_action('init', [$this, 'register_post_type'], 5);
	}

	/**
	 * Register post_type and taxonomy
	 *
	 * @return void
	 */
	public function register_post_type() {
		$this->register_custom_post_type();
		$this->register_custom_taxonomy();
	}

	/**
	 * Register custom post type
	 * @return void
	 */
	private function register_custom_post_type() {
		$custom_posts = [
			[
				'id'            => 'rt-team',
				'slug'          => get_theme_mod('rt_team_slug'),
				'singular'      => 'Doctor',
				'plural'        => 'Doctors',
				'menu_icon'     => 'dashicons-admin-customizer',
				'menu_position' => 20,
				'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt', 'author', 'comments' ],
				'taxonomies'	=> ['post_tag'],
				'description'   => __( 'Doctors Custom Post Type', 'nayar-core' ),
				'hierarchical'  => true
			],
			[
				'id'            => 'rt-project',
				'slug'          => get_theme_mod('rt_project_slug'),
				'singular'      => 'Project',
				'plural'        => 'Project',
				'menu_icon'     => 'dashicons-admin-customizer',
				'menu_position' => 22,
				'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt', 'author', 'comments' ],
				'taxonomies'	=> [],
				'description'   => __( 'Project Custom Post Type', 'nayar-core' ),
			]
		];

		$this->post_type->add_post_types( $custom_posts );
	}

	/**
	 * Register custom taxonomy
	 * @return void
	 */
	private function register_custom_taxonomy() {
		$custom_posts = [
			[
				'id'        => 'rt-team-category',
				'post_type' => [ 'rt-team' ],
				'slug'      => get_theme_mod('rt_team_cat_slug'),
				'singular'  => __( 'Doctor Category', 'nayar-core' ),
				'plural'    => __( 'Doctor Categories', 'nayar-core' ),
			],
			[
				'id'        => 'rt-project-category',
				'post_type' => [ 'rt-project' ],
				'slug'      => get_theme_mod('rt_project_cat_slug'),
				'singular'  => __( 'Project Category', 'nayar-core' ),
				'plural'    => __( 'Project Categories', 'nayar-core' ),
			]
		];

		$this->post_type->add_taxonomies( $custom_posts );
	}
}

