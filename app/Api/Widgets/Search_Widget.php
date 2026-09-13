<?php
//phpcs:disable
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace RT\NayarCore\Api\Widgets;

use \WP_Widget;
use \RT_Widget_Fields;

class Search_Widget extends WP_Widget {

	public function __construct() {
		$id    = NAYAR_CORE_PREFIX . '_search';
		$title = __( 'Nayar: Search', 'nayar-core' );
		$args  = [
			'description' => __( 'Displays Search Field', 'nayar-core' ),
		];
		parent::__construct( $id, $title, $args );
	}

	public function widget( $args, $instance ) {

		echo wp_kses_post( $args['before_widget'] );
		if ( !empty( $instance['title'] ) ) {
			$html = apply_filters( 'widget_title', $instance['title'] );
			$html = $args['before_title'] . $html .$args['after_title'];
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo nayar_html( $html );
		}
		else {
			$html = '';
		}
		?>
        <div class="quaxa-search-form">
			<?php echo get_search_form() ?>
        </div>

		<?php
		echo wp_kses_post( $args['after_widget'] );
	}

	public function update( $new_instance, $old_instance ) {
		$instance                = [];
		$instance['title']       = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';

		return $instance;
	}

	public function form( $instance ) {
		$defaults = [
			'title'       => '',
		];
		$instance = wp_parse_args( (array) $instance, $defaults );

		$fields = [
			'title'       => [
				'label' => esc_html__( 'Title', 'nayar-core' ),
				'type'  => 'text',
			],
		];

		RT_Widget_Fields::display( $fields, $instance, $this );
	}

}