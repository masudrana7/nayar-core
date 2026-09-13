<?php
//phpcs:disable
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

namespace RT\NayarCore\Hooks;
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
use RT\NayarCore\Traits\SingletonTraits;

class ActionHooks {
	use SingletonTraits;

	public function __construct() {
		add_action( 'after_setup_theme', [ $this, 'remove_admin_bar' ], 999 );
	}


	//Remove admin bar
	function remove_admin_bar() {
		if ( nayar_option('rt_remove_admin_bar') && ! current_user_can( 'administrator' ) && ! is_admin() ) {
			show_admin_bar( false );
		}
	}

}