<?php
/**
 * Theme Demo Configuration File
 *
 * This file contains the configuration for the demo importer.
 *
 * @package @package Radiustheme\Nayar
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

return [
	// Basic theme information.
	'blog_slug'           => 'blog',
	'demo_url'            => 'https://www.radiustheme.com/demo/wordpress/themes/nayar/',
	'commenter_email'     => 'dev-email@wpengine.local',
	'menus'               => [
		'primary'  => 'Primary Menu',
	],

	// File paths.
	'demo_content_zip'    => 'demo-files/demo-content.zip',

	// Demo variants.
	'demo_variants'       => [
		'home' => [
			'name'    => 'Home',
			'preview' => 'screenshots/home-1.webp',
			'url'     => '',
		],
		'home-2' => [
			'name'    => 'Home 2',
			'preview' => 'screenshots/home-2.webp',
			'url'     => 'home-2/',
		],
		'home-3' => [
			'name'    => 'Home 3',
			'preview' => 'screenshots/home-3.webp',
			'url'     => 'home-3/',
		],
		'home-4' => [
			'name'    => 'Home 4',
			'preview' => 'screenshots/home-4.webp',
			'url'     => 'home-4/',
		],
		'home-5' => [
			'name'    => 'Home 5',
			'preview' => 'screenshots/home-5.webp',
			'url'     => 'home-5/',
		],
	],

	// Additional settings.
	'settings_json'       => [
		'_fluentform_global_form_settings',
		'rtsb_extra_settings',
		'rtsb_settings',
		'rtsb_template_settings',
	],
	'fluent_forms_json'   => 'fluentform',

	// WordPress repository plugins.
	'wp_plugins'          => [
		'breadcrumb-navxt'               => 'Breadcrumb NavXT',
		'elementor'                      => 'Elementor Page Builder',
		'fluentform'                     => 'WP Fluent Forms',
		'woocommerce'                    => 'WooCommerce',
		'shopbuilder'                    => 'ShopBuilder – Elementor WooCommerce Builder Addons',
	],

	// Bundled/Premium plugins.
	'bundled_plugins'     => [
		'nayar-core' => [
			'name' => 'Nayar Core',
			'file' => 'plugin-bundle/nayar-core.zip',
		],
		'rt-framework'                       => [
			'name' => 'RT Framework',
			'file' => 'plugin-bundle/rt-framework.zip',
		],
	],

	// Enable/disable import features.
	'features'            => [
		'woo_support'     => true,
		//'elementor_fixes' => true,
	],

	// Pre-import options.
	'pre_import_options'  => [
		'elementor_experiment-e_font_icon_svg' => 'inactive',
	],

	// Post-import options.
	'post_import_options' => [
		'elementor_unfiltered_files_upload' => true,
	],
];
