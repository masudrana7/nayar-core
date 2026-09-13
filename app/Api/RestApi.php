<?php
//phpcs:disable
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace RT\NayarCore\Api;
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
use RT\NayarCore\Helper\Fns;
use RT\NayarCore\Traits\SingletonTraits;

class RestApi {
	use SingletonTraits;

	/**
	 * Register rest route
	 */
	public function __construct() {
		add_action( 'rest_api_init', [ $this, 'init_rest_routes' ], 99 );
	}

	/**
	 * Init rest route
	 *
	 * @return void
	 */
	public function init_rest_routes() {
		register_rest_route( 'rt/v1', '/all-posts', [
			'methods'  => 'GET',
			'callback' => [ $this, 'get_all_posts_type' ],
			'permission_callback' => function () {
				return true;
			}
		] );
	}

	function get_all_posts_type( $request ) {

		$posts_data = [];
		$paged      = $request->get_param( 'page' );
		$search     = $request->get_param( 'search' );
		$paged      = $paged ?? 1;
		$post_type  = Fns::get_post_types();
		$posts = get_posts( [
				'paged'          => $paged,
				'post__not_in'   => get_option( 'sticky_posts' ), // phpcs:ignore WordPressVIPMinimum.Performance.WPQueryParams.PostNotIn_post__not_in
				'posts_per_page' => 30,
				"s"              => $search,
				'post_type'      => array_keys( $post_type )
			]
		);

		foreach ( $posts as $post ) {
			$id = $post->ID;

			$posts_data[] = (object) [
				'id'   => $id,
				'slug' => $post->post_name,
				'type' => $post->post_type,
				'text' => $post->post_title,
			];
		}

		return $posts_data;
	}

}