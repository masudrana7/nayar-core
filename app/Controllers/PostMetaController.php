<?php
//phpcs:disable

namespace RT\NayarCore\Controllers;
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
use RT\Nayar\Helpers\Fns;
use \RT_Postmeta;
use RT\NayarCore\Traits\SingletonTraits;
use RT\NayarCore\Builder\Builder;
use RT\NayarCore\Helper\FnsBuilder;
use RT\NayarCore\Modules\IconList;

class PostMetaController {
	use SingletonTraits;

	public $postmeta;

	public function __construct() {
		$this->postmeta = RT_Postmeta::getInstance();
//		$this->add_meta_box();
		add_action( 'init', [ $this, 'add_meta_box' ] );
	}

	/**
	 * Add all metabox
	 * @return void
	 */
	function add_meta_box() {

		$this->postmeta->add_meta_box(
			"rt_page_settings",
			__( 'Layout Settings', 'nayar-core' ),
			[ 'page', 'post', 'rt-team', 'rt-project' ],
			'',
			'',
			'high',
			[
				'fields' => [
					"rt_layout_meta_data" => [
						'label' => __( 'Layouts', 'nayar-core' ),
						'type'  => 'group',
						'value' => $this->get_post_page_meta_args(),
					],
				],
			]
		);

		//Post Info
		$this->postmeta->add_meta_box(
			"rt_post_info",
			__( 'Post Info', 'nayar-core' ),
			[ 'post' ],
			'',
			'',
			'high',
			[
				'fields' => $this->get_post_info_meta(),
			]
		);

		//Team meta
		$this->postmeta->add_meta_box(
			"rt_team_info",
			__( 'Doctor Info', 'nayar-core' ),
			[ 'rt-team' ],
			'',
			'',
			'high',
			[
				'fields' => $this->get_team_info_meta(),
			]
		);
		$this->postmeta->add_meta_box(
			"rt_team_social",
			__( 'Doctor Social', 'nayar-core' ),
			[ 'rt-team' ],
			'',
			'',
			'high',
			[
				'fields' => $this->get_team_social_meta(),
			]
		);

		$this->postmeta->add_meta_box(
			"rt_team_education",
			__( 'Doctor Skill', 'nayar-core' ),
			[ 'rt-team' ],
			'',
			'',
			'high',
			[
				'fields' => $this->get_team_education_meta(),
			]
		);

		$this->postmeta->add_meta_box(
			"rt_team_skill",
			__( 'Doctor Skill', 'nayar-core' ),
			[ 'rt-team' ],
			'',
			'',
			'high',
			[
				'fields' => $this->get_team_skill_meta(),
			]
		);

		$this->postmeta->add_meta_box(
			"rt_team_contact",
			__( 'Doctor Contact', 'nayar-core' ),
			[ 'rt-team' ],
			'',
			'',
			'high',
			[
				'fields' => $this->get_team_contact_meta(),
			]
		);

		//Project meta
		$this->postmeta->add_meta_box(
			"rt_project_info",
			__( 'Project Info', 'nayar-core' ),
			[ 'rt-project' ],
			'',
			'',
			'high',
			[
				'fields' => $this->get_project_info_meta(),
			]
		);

        //header footer build
		$this->postmeta->add_meta_box(
			"rt_el_builder_settings",
			__( 'Header - Footer Builder Settings', 'nayar-core' ),
			[ 'elementor-nayar' ],
			'',
			'',
			'high',
			[
				'fields' => $this->get_el_builder_meta_args(),
			]
		);
	}

	function get_el_builder_meta_args() {
		return apply_filters( 'nayar_layout_meta_field', [
			'template_type' => [
				'label'   => __( 'Template Type', 'nayar-core' ),
				'type'    => 'select',
				'options' => [
					'default' => __( 'Choose Options', 'nayar-core' ),
					'header'  => __( 'Header', 'nayar-core' ),
					'footer'  => __( 'Footer', 'nayar-core' ),
				],
				'default' => 'default',
			],

			'show_on' => [
				'label'   => __( 'Show On', 'nayar-core' ),
				'type'    => 'multi_select2',
				'options' => FnsBuilder::get_builder_type(),
				'default' => [],
				'class'   => 'rt-header-footer-select'
			],

			'choose_post' => [
				'label'       => __( 'Choose posts or pages', 'nayar-core' ),
				'type'        => 'ajax_select',
				'data_source' => 'post',
				'default'     => [],
			],

		] );
	}

	function get_post_page_meta_args() {
		$sidebars = [ 'default' => __( 'Default from customizer', 'nayar-core' ) ] + Fns::sidebar_lists();

		return apply_filters( 'nayar_layout_meta_field', [
			'layout'            => [
				'label'   => __( 'Layout', 'nayar-core' ),
				'type'    => 'select',
				'options' => [
					'default'       => __( 'Default from customizer', 'nayar-core' ),
					'full-width'    => __( 'Full Width', 'nayar-core' ),
					'left-sidebar'  => __( 'Left Sidebar', 'nayar-core' ),
					'right-sidebar' => __( 'Right Sidebar', 'nayar-core' ),
				],
				'default' => 'default',
			],
			'single_post_style' => [
				'label'   => __( 'Post View Style', 'nayar-core' ),
				'type'    => 'select',
				'options' => [ 'default' => __( 'Default from customizer', 'nayar-core' ) ] + Fns::single_post_style(),
				'default' => 'default',
			],
			'header_style'      => [
				'label'   => __( 'Header Style', 'nayar-core' ),
				'type'    => 'select',
				'options' => [
					'default' => __( 'Default from customizer', 'nayar-core' ),
					'1'       => __( 'Layout 1', 'nayar-core' ),
					'2'       => __( 'Layout 2', 'nayar-core' ),
				],
				'default' => 'default',
			],
			'sidebar'           => [
				'label'   => __( 'Custom Sidebar', 'nayar-core' ),
				'type'    => 'select',
				'options' => $sidebars,
				'default' => 'default',
			],
			'top_bar'           => [
				'label'   => __( 'Top Bar Visibility', 'nayar-core' ),
				'type'    => 'select',
				'options' => [
					'default' => __( 'Default from customizer', 'nayar-core' ),
					'on'      => __( 'ON', 'nayar-core' ),
					'off'     => __( 'OFF', 'nayar-core' ),
				],
				'default' => 'default',
			],
			'topbar_style'      => [
				'label'   => __( 'Top Bar Style', 'nayar-core' ),
				'type'    => 'select',
				'options' => [
					'default' => __( 'Default from customizer', 'nayar-core' ),
					'1'       => __( 'Layout 1', 'nayar-core' ),
				],
				'default' => 'default',
			],
			'header_width'      => [
				'label'   => __( 'Header Width', 'nayar-core' ),
				'type'    => 'select',
				'options' => [
					'default' => __( 'Default from customizer', 'nayar-core' ),
					'box'     => __( 'Box Width', 'nayar-core' ),
					'full'    => __( 'Full Width', 'nayar-core' ),
				],
				'default' => 'default',
			],
			'menu_alignment'    => [
				'label'   => __( 'Menu Alignment', 'nayar-core' ),
				'type'    => 'select',
				'options' => [
					'default'     => __( 'Default from customizer', 'nayar-core' ),
					'menu-left'   => __( 'Left Alignment', 'nayar-core' ),
					'menu-center' => __( 'Center Alignment', 'nayar-core' ),
					'menu-right'  => __( 'Right Alignment', 'nayar-core' ),
				],
				'default' => 'default',
			],

			'tr_header'        => [
				'label'   => __( 'Transparent Header', 'nayar-core' ),
				'type'    => 'select',
				'options' => [
					'default' => __( 'Default from customizer', 'nayar-core' ),
					'on'      => __( 'ON', 'nayar-core' ),
					'off'     => __( 'OFF', 'nayar-core' ),
				],
				'default' => 'default',
			],

			'tr_header_color' => [
				'label'   => __( 'Transparent color', 'nayar-core' ),
				'type'    => 'select',
				'options' => [
					'default'   => __( 'Default from customizer', 'nayar-core' ),
					'tr-header-light'   => __( 'Light Color', 'nayar-core' ),
					'tr-header-dark'    => __( 'Dark Color', 'nayar-core' ),
				],
				'default' => 'default',
			],

			'banner'           => [
				'label'   => __( 'Banner Visibility', 'nayar-core' ),
				'type'    => 'select',
				'options' => [
					'default' => __( 'Default from customizer', 'nayar-core' ),
					'on'      => __( 'ON', 'nayar-core' ),
					'off'     => __( 'OFF', 'nayar-core' ),
				],
				'default' => 'default',
			],
			'breadcrumb_title' => [
				'label'   => __( 'Banner Title', 'nayar-core' ),
				'type'    => 'select',
				'options' => [
					'default' => __( 'Default from customizer', 'nayar-core' ),
					'on'      => __( 'ON', 'nayar-core' ),
					'off'     => __( 'OFF', 'nayar-core' ),
				],
				'default' => 'default',
			],
			'breadcrumb'       => [
				'label'   => __( 'Banner Breadcrumb', 'nayar-core' ),
				'type'    => 'select',
				'options' => [
					'default' => __( 'Default from customizer', 'nayar-core' ),
					'on'      => __( 'ON', 'nayar-core' ),
					'off'     => __( 'OFF', 'nayar-core' ),
				],
				'default' => 'default',
			],

			'banner_image'    => [
				'type'  => 'image',
				'label' => __( 'Banner Background Image', 'nayar-core' ),
			],
			'banner_color'    => [
				'type'  => 'color_picker',
				'label' => __( 'Banner Background Color', 'nayar-core' ),
			],


			'footer_style'     => [
				'label'   => __( 'Footer Layout', 'nayar-core' ),
				'type'    => 'select',
				'options' => [
					'default' => __( 'Default from customizer', 'nayar-core' ),
					'1'       => __( 'Layout 1', 'nayar-core' ),
					'2'       => __( 'Layout 2', 'nayar-core' ),
				],
				'default' => 'default',
			],
			'footer_schema'    => [
				'label'   => __( 'Footer Schema', 'nayar-core' ),
				'type'    => 'select',
				'options' => [
					'default'      => __( 'Default from customizer', 'nayar-core' ),
					'footer-light' => __( 'Light Footer', 'nayar-core' ),
					'footer-dark'  => __( 'Dark Footer', 'nayar-core' ),
				],
				'default' => 'default',
			],
			'padding_top'    => [
				'label' => __( 'Padding Top (Page Content)', 'nayar-core' ),
				'type'  => 'number',
			],
			'padding_bottom'   => [
				'label' => __( 'Padding Bottom (Page Content)', 'nayar-core' ),
				'type'  => 'number',
			],
			'page_bg_image'    => [
				'type'  => 'image',
				'label' => __( 'Background Image', 'nayar-core' ),
			],
			'page_bg_color'    => [
				'type'  => 'color_picker',
				'label' => __( 'Background Color', 'nayar-core' ),
			],

		] );
	}

	function get_post_info_meta() {
		return apply_filters( 'rt_post_info', [
			'rt_youtube_link' => [
				'label'   => __( 'Youtube Link', 'nayar-core' ),
				'type'    => 'text',
				'default' => '',
			],
			'rt_post_gallery' => [
				'label' => __( 'Post Gallery', 'nayar-core' ),
				'type'  => 'gallery',
				'desc'  => __( 'Only work for the gallery post format', 'nayar-core' ),
			],
		] );
	}

	//Team meta info
	function get_team_info_meta() {
		return apply_filters( 'rt_team_meta_field', [
			'rt_team_info_title' => array(
				'label' => __( 'About Title', 'nayar-core' ),
				'type'  => 'text',
			),

			'rt_team_designation' => [
				'label'   => __( 'Doctor Designation', 'nayar-core' ),
				'type'    => 'text',
				'default' => '',
			],

			'rt_team_phone' => [
				'label'   => __( 'Doctor Phone', 'nayar-core' ),
				'type'    => 'text',
				'default' => '',
			],

			'rt_team_day' => [
				'label'   => __( 'Open Day', 'nayar-core' ),
				'type'    => 'text',
				'default' => '',
			],

			'rt_team_website' => [
				'label'   => __( 'Doctor Website', 'nayar-core' ),
				'type'    => 'text',
				'default' => '',
			],

			'rt_team_email' => [
				'label'   => __( 'Doctor Email', 'nayar-core' ),
				'type'    => 'text',
				'default' => '',
			],

			'rt_team_address' => [
				'label'   => __( 'Doctor Address', 'nayar-core' ),
				'type'    => 'text',
				'default' => '',
			],

			'rt_appointment_text' => [
				'label'   => __( 'Book Appointment', 'nayar-core' ),
				'type'    => 'text',
				'default' => 'Book Appointment',
			],

			'rt_appointment_url' => [
				'label'   => __( 'Book Appointment URL', 'nayar-core' ),
				'type'    => 'text',
				'default' => '#',
			],

		] );
	}
	function get_team_social_meta() {
		return apply_filters( 'rt_team_meta_social', [
			'rt_team_socials' => array(
				'type'  => 'group',
				'value' => Fns::get_team_socials(),
			),
		] );
	}

	function get_team_education_meta () {
		return apply_filters( 'rt_team_meta_education', [

			'rt_team_education_title' => array(
				'label' => __( 'Education Title', 'nayar-core' ),
				'type'  => 'text',
			),

			'rt_team_education_info' => [
				'label'   => __( 'Doctor Education Info', 'nayar-core' ),
				'type'    => 'textarea',
			],

			'rt_team_education' => [
				'type'  => 'repeater',
				'button' => __( 'Add New Education', 'nayar-core' ),
				'value'  => [
					'degree_name' => [
						'label' => __( 'Degree name', 'nayar-core' ),
						'type'  => 'text',
						'desc'  => __( 'MBBS – Bachelor of Medicine & Surgery', 'nayar-core' ),
					],
					'university_name_year' => [
						'label' => __( 'University Name And  Year', 'nayar-core' ),
						'type'  => 'text',
						'desc'  => __( 'King Edward Medical University, Lahore 2006 – 2011', 'nayar-core' ),
					],
				]
			],
		] );
	}
	function get_team_skill_meta() {
		return apply_filters( 'rt_team_meta_skill', [

			'rt_team_skill_title' => array(
				'label' => __( 'Skill Title', 'nayar-core' ),
				'type'  => 'text',
			),

			'rt_team_skill_info' => [
				'label'   => __( 'Doctor Skill Info', 'nayar-core' ),
				'type'    => 'textarea',
			],

			'rt_team_skill' => [
				'type'  => 'repeater',
				'button' => __( 'Add New Skill', 'nayar-core' ),
				'value'  => [
					'skill_name' => [
						'label' => __( 'Skill Name', 'nayar-core' ),
						'type'  => 'text',
						'desc'  => __( 'eg. Marketing', 'nayar-core' ),
					],
					'skill_value' => [
						'label' => __( 'Skill Percentage (%)', 'nayar-core' ),
						'type'  => 'text',
						'desc'  => __( 'eg. 75', 'nayar-core' ),
					],
					'skill_color' => [
						'label' => __( 'Skill Color', 'nayar-core' ),
						'type'  => 'color_picker',
						'desc'  => __( 'If not selected, primary color will be used', 'nayar-core' ),
					],
				]
			],
		] );
	}

	function get_team_contact_meta() {
		return apply_filters( 'rt_team_meta_contact', [
			'rt_team_contact_form' => array(
				'label' => __( 'Contact Form Shortcode', 'nayar-core' ),
				'type'  => 'text',
			),
		] );
	}

	//Project meta info
	function get_project_info_meta() {
		return apply_filters( 'rt_project_meta_field', [
			'rt_project_title' => [
				'label'   => __( 'Info Title', 'nayar-core' ),
				'type'    => 'text',
				'default' => __( 'Project Info', 'nayar-core' ),
			],

			'rt_project_text' => [
				'label'   => __( 'Info Text', 'nayar-core' ),
				'type'    => 'text',
				'default' => '',
			],

			'rt_project_client' => [
				'label'   => __( 'Client', 'nayar-core' ),
				'type'    => 'text',
				'default' => '',
			],

			'rt_project_start' => [
				'label'   => __( 'Starts On', 'nayar-core' ),
				'type'    => 'text',
				'default' => '',
			],

			'rt_project_end' => [
				'label'   => __( 'End On', 'nayar-core' ),
				'type'    => 'text',
				'default' => '',
			],

			'rt_project_weblink' => [
				'label'   => __( 'Weblink', 'nayar-core' ),
				'type'    => 'text',
				'default' => '',
			],

			'rt_project_rating' => [
				'label' => __( 'Select the Rating', 'nayar-core' ),
				'type'  => 'select',
				'options' => array(
					'-1' => __( 'Default', 'nayar-core' ),
					'1'    => '1',
					'2'    => '2',
					'3'    => '3',
					'4'    => '4',
					'5'    => '5'
				),
				'default'  => '-1',
			],

		] );
	}
}

