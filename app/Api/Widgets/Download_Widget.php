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

class Download_Widget extends WP_Widget {

	public function __construct() {
		$id    = NAYAR_CORE_PREFIX . '_download';
		$title = __( 'Nayar: Download', 'nayar-core' );
		$args  = [
			'description' => esc_html__( 'Displays Download Info', 'nayar-core' )
		];
		parent::__construct( $id, $title, $args );
	}


	public function form( $instance ) {
		$defaults = [
			'title'             => '',
			'down_title'        => '',
			'doc_title'         => '',
			'down_url'          => '',
			'doc_url'           => '',
		];

		$instance = wp_parse_args( (array) $instance, $defaults );

		$fields = [
			'title'   => [
				'label' => esc_html__( 'Title', 'nayar-core' ),
				'type'  => 'text',
			],
			'down_title'       => [
				'label'   => esc_html__( 'Download Title', 'nayar-core' ),
				'type'    => 'text',
			],
			'down_url'    => [
				'label'    => esc_html__( 'Download URL', 'nayar-core' ),
				'type'     => 'url',
			],
			'doc_title'       => [
				'label'   => esc_html__( 'Document Title', 'nayar-core' ),
				'type'    => 'text',
			],
			'doc_url'    => [
				'label'    => esc_html__( 'Document URL', 'nayar-core' ),
				'type'     => 'url',
			],
		];

		RT_Widget_Fields::display( $fields, $instance, $this );
	}

	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title']       = ( ! empty( $new_instance['title'] ) ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
		$instance['down_title']   = ( ! empty( $new_instance['down_title'] ) ) ? sanitize_text_field( $new_instance['down_title'] ) : '';
		$instance['doc_title']   = ( ! empty( $new_instance['doc_title'] ) ) ? sanitize_text_field( $new_instance['doc_title'] ) : '';
		$instance['down_url']   = ( ! empty( $new_instance['down_url'] ) ) ? sanitize_text_field( $new_instance['down_url'] ) : '';
		$instance['doc_url']   = ( ! empty( $new_instance['doc_url'] ) ) ? sanitize_text_field( $new_instance['doc_url'] ) : '';

		return $instance;
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


		<div class="download-widget">
			<div class="rt-download">
				<?php if ( ! empty( $instance['down_url'] || $instance['down_title']) ) { ?>
					<a class="link" download href="<?php echo esc_url( $instance['down_url'] ); ?>">
						<div class="text"><i class="icon-rt-file"></i><?php echo esc_html( $instance['down_title'] ); ?></div>
						<div class="icon"><i class="icon-rt-download"></i></div>
					</a>
				<?php } ?>
			</div>
			<div class="rt-download">
				<?php if ( ! empty( $instance['doc_url'] || $instance['doc_title']) ) { ?>
					<a class="link" download href="<?php echo esc_url( $instance['doc_url'] ); ?>">
						<div class="text"><i class="icon-rt-file-alt"></i><?php echo esc_html( $instance['doc_title'] ); ?></div>
						<div class="icon"><i class="icon-rt-download"></i></div>
					</a>
				<?php } ?>
			</div>
		</div>

		<?php echo wp_kses_post( $args['after_widget'] );
	}
}