<?php
//phpcs:disable

namespace RT\NayarCore\Builder;

use Elementor\Plugin;
use RT\NayarCore\Helper\Fns;
use RT\NayarCore\Helper\FnsBuilder;
class Builder {
	public static function get_elementor_content( $type ) {
		echo Plugin::instance()->frontend->get_builder_content_for_display( self::check_builder_visibility( $type ) ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	public static function check_builder_visibility( $type ) {

		//Get builder ids by type = (header || footer)
		$builder_ids = FnsBuilder::get_template_type( $type );

		if ( ! $builder_ids || ! is_array( $builder_ids ) ) {
			return false;
		}

		$current_page = '';

		if ( is_404() ) {
			$current_page = 'is_404';
		} elseif ( is_search() ) {
			$current_page = 'is_search';
		} elseif ( is_archive() ) {
			$current_page = 'is_archive';
			if ( is_category() || is_tag() || is_tax() ) {
				$current_page = 'is_tax';
			} elseif ( is_date() ) {
				$current_page = 'is_date';
			} elseif ( is_author() ) {
				$current_page = 'is_author';
			} elseif ( function_exists( 'is_shop' ) && is_shop() ) {
				$current_page = 'is_shop';
			}
		} elseif ( is_home() ) {
			$current_page = 'is_home';
		} elseif ( is_front_page() ) {
			$current_page = 'is_front_page';
		} elseif ( is_singular() ) {
			$current_page = 'is_singular';
		}

		return self::check_page_condition( $builder_ids, $current_page );

	}

	/**
	 *
	 * @param $builder_ids
	 * @param $current_page
	 *
	 * @return mixed|string
	 */
	public static function check_page_condition( $builder_ids, $current_page ) {

		foreach ( $builder_ids as $builder_id ) {
			$show_on     = get_post_meta( $builder_id, 'show_on', true );
			$choose_post = get_post_meta( $builder_id, 'choose_post', true );

			$show_on = is_array( $show_on ) ? $show_on : [];

			//Check CPT archive || single || taxonomy
			if ( FnsBuilder::condition_by_cpt( $current_page, $show_on ) ) {
				return $builder_id;
			}

			// Check sitewide condition
			if ( FnsBuilder::condition_by_sitewide( $current_page, $show_on, $choose_post ) ) {
				return $builder_id;
			}

			if ( in_array( $current_page, $show_on ) ) {
				return $builder_id;
			}
		}

		return '';
	}

}

