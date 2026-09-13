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
use RT\NayarCore\Traits\SingletonTraits;
use RT\NayarCore\Api\Widgets\About_Widget;
use RT\NayarCore\Api\Widgets\Contact_Widget;
use RT\NayarCore\Api\Widgets\Post_Widget;
use RT\NayarCore\Api\Widgets\Search_Widget;
use RT\NayarCore\Api\Widgets\Download_Widget;

class WidgetInit {
	use SingletonTraits;

	public $widgets;

	public function __construct() {

		// Widgets -- filename=>classname /@dev
		$this->widgets = [
			About_Widget::class,
			Contact_Widget::class,
			Post_Widget::class,
			Search_Widget::class,
			Download_Widget::class,
		];

		add_action( 'widgets_init', [ $this, 'custom_widgets' ] );
	}

	public function custom_widgets() {
		if ( ! class_exists( 'RT_Widget_Fields' ) ) {
			return;
		}

		foreach ( $this->widgets as $class ) {
			register_widget( $class );
		}
	}
}