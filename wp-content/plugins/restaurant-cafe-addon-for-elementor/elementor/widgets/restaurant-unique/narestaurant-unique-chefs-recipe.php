<?php
/*
 * Elementor Restaurant & Cafe Addon for Elementor Chefs Recipe Widget
 * Author & Copyright: NicheAddon
*/

namespace Elementor;

if (!isset(get_option( 'rcafe_uw_settings' )['nbeds_chefs_recipe'])) { // enable & disable

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Restaurant_Elementor_Addon_Unique_ChefsRecipe extends Widget_Base{

	/**
	 * Retrieve the widget name.
	*/
	public function get_name(){
		return 'narestaurant_unique_chefs_recipe';
	}

	/**
	 * Retrieve the widget title.
	*/
	public function get_title(){
		return esc_html__( 'Chefs Recipe', 'restaurant-cafe-addon-for-elementor' );
	}

	/**
	 * Retrieve the widget icon.
	*/
	public function get_icon() {
		return 'eicon-info-box';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	*/
	public function get_categories() {
		return ['narestaurant-unique-category'];
	}

	/**
	 * Register Restaurant & Cafe Addon for Elementor Chefs widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	*/
	protected function _register_controls(){

		$this->start_controls_section(
			'section_chefs',
			[
				'label' => __( 'Chefs Recipe Options', 'restaurant-cafe-addon-for-elementor' ),
			]
		);
		$this->add_control(
			'chefs_image',
			[
				'label' => esc_html__( 'Chefs Image', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::MEDIA,
				'frontend_available' => true,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'description' => esc_html__( 'Set your image.', 'restaurant-cafe-addon-for-elementor'),
			]
		);
		$this->add_control(
			'chefs_name',
			[
				'label' => esc_html__( 'Chef Name', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'James Philander', 'restaurant-cafe-addon-for-elementor' ),
				'placeholder' => esc_html__( 'Type text here', 'restaurant-cafe-addon-for-elementor' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'chefs_role',
			[
				'label' => esc_html__( 'Chef Role', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'EXECUTIVE CHEF', 'restaurant-cafe-addon-for-elementor' ),
				'placeholder' => esc_html__( 'Type text here', 'restaurant-cafe-addon-for-elementor' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'btn_text',
			[
				'label' => esc_html__( 'Button Title', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Buy Now', 'restaurant-cafe-addon-for-elementor' ),
				'placeholder' => esc_html__( 'Type button text here', 'restaurant-cafe-addon-for-elementor' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'btn_link',
			[
				'label' => esc_html__( 'Button Link', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::URL,
				'placeholder' => 'https://your-link.com',
				'default' => [
					'url' => '',
				],
				'label_block' => true,
			]
		);
		$this->add_control(
			'chefs_info',
			[
				'label' => esc_html__( 'Chef Info', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using Content here, content here, making it look like readable English. Many desktop publishing.', 'restaurant-cafe-addon-for-elementor' ),
				'placeholder' => esc_html__( 'Type text here', 'restaurant-cafe-addon-for-elementor' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'scn_inner',
			[
				'label' => __( 'Chefs Recipes', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'after',
			]
		);
		$this->add_control(
			'recipes_title',
			[
				'label' => esc_html__( 'Chefs Receipe', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Chef’s receipe', 'restaurant-cafe-addon-for-elementor' ),
				'placeholder' => esc_html__( 'Type receipe text here', 'restaurant-cafe-addon-for-elementor' ),
				'label_block' => true,
			]
		);
		$repeater = new Repeater();
		$repeater->add_control(
			'food_image',
			[
				'label' => esc_html__( 'Food Image', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::MEDIA,
				'frontend_available' => true,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'description' => esc_html__( 'Set your image.', 'restaurant-cafe-addon-for-elementor'),
			]
		);
		$repeater->add_control(
			'link_style',
			[
				'label' => __( 'Link Style', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'one' 			=> esc_html__( 'Image Popup', 'restaurant-cafe-addon-for-elementor' ),
					'two' 			=> esc_html__( 'Custom Link', 'restaurant-cafe-addon-for-elementor' ),
					'three' 			=> esc_html__( 'Video Link', 'restaurant-cafe-addon-for-elementor' ),
				],
				'default' => 'one',
			]
		);
		$repeater->add_control(
			'image_link',
			[
				'label' => esc_html__( 'Image Link', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::URL,
				'placeholder' => 'https://your-link.com',
				'default' => [
					'url' => '',
				],
				'label_block' => true,
				'condition' => [
					'link_style' => 'two',
				],
			]
		);
		$repeater->add_control(
			'video_link',
			[
				'label' => esc_html__( 'Video Link', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter Video link', 'restaurant-cafe-addon-for-elementor' ),
				'label_block' => true,
				'condition' => [
					'link_style' => 'three',
				],
			]
		);
		$repeater->add_control(
			'prep_time',
			[
				'label' => esc_html__( 'Preparation Time', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( '5 Mins', 'restaurant-cafe-addon-for-elementor' ),
				'label_block' => true,
				'condition' => [
					'link_style' => 'three',
				],
			]
		);
		$repeater->add_control(
			'btn_icon',
			[
				'label' => esc_html__( 'Button Icon', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::ICON,
				'options' => NAREP_Controls_Helper_Output::get_include_icons(),
				'frontend_available' => true,
				'default' => 'fa fa-play',
				'condition' => [
					'link_style' => 'three',
				],
			]
		);
		$repeater->add_control(
			'list_text',
			[
				'label' => esc_html__( 'Receipe Title', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Mixture of Salad', 'restaurant-cafe-addon-for-elementor' ),
				'placeholder' => esc_html__( 'Type title text here', 'restaurant-cafe-addon-for-elementor' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'receipes_groups',
			[
				'label' => esc_html__( 'Ingredients', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'list_text' => esc_html__( 'Mixture of Salad', 'restaurant-cafe-addon-for-elementor' ),
					],
				],
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ list_text }}}',
				'prevent_empty' => false,
			]
		);
		$this->add_control(
			'scn_innert',
			[
				'label' => __( 'Contact', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'after',
			]
		);
		$this->add_control(
			'contact_title',
			[
				'label' => esc_html__( 'Contact Title', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Contact', 'restaurant-cafe-addon-for-elementor' ),
				'placeholder' => esc_html__( 'Type title text here', 'restaurant-cafe-addon-for-elementor' ),
				'label_block' => true,
			]
		);
		$repeaterTwo = new Repeater();
		$repeaterTwo->add_control(
			'social_icon',
			[
				'label' => esc_html__( 'Social Icon', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::ICON,
				'options' => NAREP_Controls_Helper_Output::get_include_icons(),
				'frontend_available' => true,
				'default' => 'fa fa-facebook-square',
			]
		);
		$repeaterTwo->add_control(
			'icon_link',
			[
				'label' => esc_html__( 'Icon Link', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::URL,
				'placeholder' => 'https://your-link.com',
				'default' => [
					'url' => '',
				],
				'label_block' => true,
			]
		);
		$this->add_control(
			'contact_groups',
			[
				'label' => esc_html__( 'Social Iocns', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeaterTwo->get_controls(),
				'title_field' => '{{{ social_icon }}}',
			]
		);
		$this->add_control(
			'toggle_align',
			[
				'label' => esc_html__( 'Toggle Align?', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'restaurant-cafe-addon-for-elementor' ),
				'label_off' => esc_html__( 'No', 'restaurant-cafe-addon-for-elementor' ),
				'return_value' => 'true',
			]
		);
		$this->end_controls_section();// end: Section

		// Carousel Options
			$this->start_controls_section(
				'section_carousel',
				[
					'label' => esc_html__( 'Carousel Options', 'restaurant-elementor-addon' ),
				]
			);
			$this->add_control(
				'carousel_item',
				[
					'label' => __( 'Slider Item', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::NUMBER,
				]
			);
			$this->add_control(
				'$carousel_space',
				[
					'label' => __( 'Slider Item Space', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::NUMBER,
				]
			);
			$this->add_control(
				'carousel_loop',
				[
					'label' => esc_html__( 'Disable Loop?', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Yes', 'restaurant-cafe-addon-for-elementor' ),
					'label_off' => esc_html__( 'No', 'restaurant-cafe-addon-for-elementor' ),
					'return_value' => 'true',
					'description' => esc_html__( 'Continuously moving carousel, if enabled.', 'restaurant-cafe-addon-for-elementor' ),
				]
			);
			$this->add_control(
				'carousel_dots',
				[
					'label' => esc_html__( 'Dots', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Yes', 'restaurant-cafe-addon-for-elementor' ),
					'label_off' => esc_html__( 'No', 'restaurant-cafe-addon-for-elementor' ),
					'return_value' => 'true',
					'description' => esc_html__( 'If you want Carousel Dots, enable it.', 'restaurant-cafe-addon-for-elementor' ),
				]
			);
			$this->add_control(
				'carousel_nav',
				[
					'label' => esc_html__( 'Navigation', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Yes', 'restaurant-cafe-addon-for-elementor' ),
					'label_off' => esc_html__( 'No', 'restaurant-cafe-addon-for-elementor' ),
					'return_value' => 'true',
					'description' => esc_html__( 'If you want Carousel Navigation, enable it.', 'restaurant-cafe-addon-for-elementor' ),
				]
			);
			$this->add_control(
				'carousel_autoplay',
				[
					'label' => esc_html__( 'Autoplay', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Yes', 'restaurant-cafe-addon-for-elementor' ),
					'label_off' => esc_html__( 'No', 'restaurant-cafe-addon-for-elementor' ),
					'return_value' => 'true',
					'description' => esc_html__( 'If you want to start Carousel automatically, enable it.', 'restaurant-cafe-addon-for-elementor' ),
				]
			);
			$this->add_control(
				'carousel_autoplay_timeout',
				[
					'label' => __( 'Auto Play Timeout', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::NUMBER,
					'condition' => [
						'carousel_autoplay' => 'true',
					],
				]
			);
			$this->add_control(
				'clickable_pagi',
				[
					'label' => esc_html__( 'Pagination Dots Clickable?', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Yes', 'restaurant-cafe-addon-for-elementor' ),
					'label_off' => esc_html__( 'No', 'restaurant-cafe-addon-for-elementor' ),
					'return_value' => 'true',
					'description' => esc_html__( 'If you want pagination dots clickable, enable it.', 'restaurant-cafe-addon-for-elementor' ),
				]
			);
			$this->add_control(
				'carousel_speed',
				[
					'label' => __( 'Auto Play Speed', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::NUMBER,
				]
			);
			$this->add_control(
				'carousel_effect',
				[
					'label' => __( 'Slider Effect', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'fade' => esc_html__( 'Fade', 'restaurant-cafe-addon-for-elementor' ),
						'slide' => esc_html__( 'Slide', 'restaurant-cafe-addon-for-elementor' ),
						'cube' => esc_html__( 'Cube', 'restaurant-cafe-addon-for-elementor' ),
						'coverflow' => esc_html__( 'Coverflow', 'restaurant-cafe-addon-for-elementor' ),
					],
					'default' => 'fade',
					'description' => esc_html__( 'Select your slider navigation style.', 'restaurant-cafe-addon-for-elementor' ),
				]
			);
			$this->add_control(
				'carousel_mousedrag',
				[
					'label' => esc_html__( 'Disable Mouse Drag?', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Yes', 'restaurant-cafe-addon-for-elementor' ),
					'label_off' => esc_html__( 'No', 'restaurant-cafe-addon-for-elementor' ),
					'return_value' => 'true',
					'description' => esc_html__( 'If you want to disable Mouse Drag, check it.', 'restaurant-cafe-addon-for-elementor' ),
				]
			);
			$this->end_controls_section();// end: Section

		// Section
			$this->start_controls_section(
				'section_box_style',
				[
					'label' => esc_html__( 'Section', 'restaurant-cafe-addon-for-elementor' ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'section_bg_color',
				[
					'label' => esc_html__( 'Background Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .narep-chefs-info' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'section_padding',
				[
					'label' => __( 'Padding', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],
					'selectors' => [
						'{{WRAPPER}} .narep-chefs-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'section_border_radius',
				[
					'label' => __( 'Border Radius', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .narep-chefs-info' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'secn_border',
					'label' => esc_html__( 'Border', 'restaurant-cafe-addon-for-elementor' ),
					'selector' => '{{WRAPPER}} .narep-chefs-info',
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'section_box_shadow',
					'label' => esc_html__( 'Box Shadow', 'restaurant-cafe-addon-for-elementor' ),
					'selector' => '{{WRAPPER}} .narep-chefs-info',
				]
			);
			$this->end_controls_section();// end: Section

		// Image
			$this->start_controls_section(
				'sectn_style',
				[
					'label' => esc_html__( 'Image', 'restaurant-cafe-addon-for-elementor' ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'lay_color',
				[
					'label' => esc_html__( 'Overlay Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .narep-chefs-carousel .img-link:after' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'image_border_radius',
				[
					'label' => __( 'Border Radius', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .narep-chefs-food .narep-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'img_width',
				[
					'label' => esc_html__( 'Image Width', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1500,
							'step' => 1,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'size_units' => [ 'px', '%' ],
					'selectors' => [
						'{{WRAPPER}} .narep-chefs-food .narep-image' => 'max-width:{{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'image_border',
					'label' => esc_html__( 'Border', 'restaurant-cafe-addon-for-elementor' ),
					'selector' => '{{WRAPPER}} .narep-chefs-food .narep-image',
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'image_box_shadow',
					'label' => esc_html__( 'Image Box Shadow', 'restaurant-cafe-addon-for-elementor' ),
					'selector' => '{{WRAPPER}} .narep-chefs-food .narep-image',
				]
			);
			$this->end_controls_section();// end: Section

		// Title
			$this->start_controls_section(
				'section_title_style',
				[
					'label' => esc_html__( 'Title', 'restaurant-cafe-addon-for-elementor' ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'title_padding',
				[
					'label' => __( 'Padding', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],
					'selectors' => [
						'{{WRAPPER}} .narep-chefs-name h2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Typography', 'restaurant-cafe-addon-for-elementor' ),
					'name' => 'sastool_title_typography',
					'selector' => '{{WRAPPER}} .narep-chefs-name h2',
				]
			);
			$this->add_control(
				'title_color',
				[
					'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .narep-chefs-name h2' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();// end: Section

		// Role
			$this->start_controls_section(
				'section_role_style',
				[
					'label' => esc_html__( 'Role', 'restaurant-cafe-addon-for-elementor' ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'role_padding',
				[
					'label' => __( 'Padding', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],
					'selectors' => [
						'{{WRAPPER}} .narep-chefs-name h3' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Typography', 'restaurant-cafe-addon-for-elementor' ),
					'name' => 'sastool_role_typography',
					'selector' => '{{WRAPPER}} .narep-chefs-name h3',
				]
			);
			$this->add_control(
				'role_color',
				[
					'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .narep-chefs-name h3' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();// end: Section

		// Button
			$this->start_controls_section(
				'section_btn_style',
				[
					'label' => esc_html__( 'Button', 'restaurant-cafe-addon-for-elementor' ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'btn_width',
				[
					'label' => esc_html__( 'Button Width', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1500,
							'step' => 1,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'size_units' => [ 'px', '%' ],
					'selectors' => [
						'{{WRAPPER}} .narep-btn' => 'min-width:{{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'btn_margin',
				[
					'label' => __( 'Margin', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],
					'selectors' => [
						'{{WRAPPER}} .narep-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'btn_padding',
				[
					'label' => __( 'Padding', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],
					'selectors' => [
						'{{WRAPPER}} .narep-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'btn_border_radius',
				[
					'label' => __( 'Border Radius', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .narep-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Typography', 'restaurant-cafe-addon-for-elementor' ),
					'name' => 'btn_typography',
					'selector' => '{{WRAPPER}} .narep-btn',
				]
			);
			$this->start_controls_tabs( 'btn_style' );
				$this->start_controls_tab(
					'btn_normal',
					[
						'label' => esc_html__( 'Normal', 'restaurant-cafe-addon-for-elementor' ),
					]
				);
				$this->add_control(
					'btn_color',
					[
						'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .narep-btn' => 'color: {{VALUE}};',
						],
					]
				);
				$this->add_control(
					'btn_bg_color',
					[
						'label' => esc_html__( 'Background Color', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .narep-btn' => 'background-color: {{VALUE}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'btn_border',
						'label' => esc_html__( 'Border', 'restaurant-cafe-addon-for-elementor' ),
						'selector' => '{{WRAPPER}} .narep-btn',
					]
				);
				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'btn_shadow',
						'label' => esc_html__( 'Button Shadow', 'restaurant-cafe-addon-for-elementor' ),
						'selector' => '{{WRAPPER}} .narep-btn:after',
					]
				);
				$this->end_controls_tab();  // end:Normal tab
				$this->start_controls_tab(
					'btn_hover',
					[
						'label' => esc_html__( 'Hover', 'restaurant-cafe-addon-for-elementor' ),
					]
				);
				$this->add_control(
					'btn_hover_color',
					[
						'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .narep-btn:hover' => 'color: {{VALUE}};',
						],
					]
				);
				$this->add_control(
					'btn_bg_hover_color',
					[
						'label' => esc_html__( 'Background Color', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .narep-btn:hover' => 'background-color: {{VALUE}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'btn_hover_border',
						'label' => esc_html__( 'Border', 'restaurant-cafe-addon-for-elementor' ),
						'selector' => '{{WRAPPER}} .narep-btn:hover',
					]
				);
				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'btn_hover_shadow',
						'label' => esc_html__( 'Button Shadow', 'restaurant-cafe-addon-for-elementor' ),
						'selector' => '{{WRAPPER}} .narep-btn:hover:after',
					]
				);
				$this->end_controls_tab();  // end:Hover tab
			$this->end_controls_tabs(); // end tabs
			$this->end_controls_section();// end: Section

		// Section Title
			$this->start_controls_section(
				'section_se_title_style',
				[
					'label' => esc_html__( 'Section Title', 'restaurant-cafe-addon-for-elementor' ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'se_title_padding',
				[
					'label' => __( 'Padding', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],
					'selectors' => [
						'{{WRAPPER}} .narep-chefs-info h5' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Typography', 'restaurant-cafe-addon-for-elementor' ),
					'name' => 'se_title_typography',
					'selector' => '{{WRAPPER}} .narep-chefs-info h5',
				]
			);
			$this->add_control(
				'se_title_color',
				[
					'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .narep-chefs-info h5' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();// end: Section

		// Food Title
			$this->start_controls_section(
				'section_food_title_style',
				[
					'label' => esc_html__( 'Food Title', 'restaurant-cafe-addon-for-elementor' ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'food_title_padding',
				[
					'label' => __( 'Padding', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],
					'selectors' => [
						'{{WRAPPER}} .narep-chefs-info h5' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Typography', 'restaurant-cafe-addon-for-elementor' ),
					'name' => 'food_title_typography',
					'selector' => '{{WRAPPER}} .narep-chefs-info h5',
				]
			);
			$this->add_control(
				'food_title_color',
				[
					'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .narep-chefs-info h5' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();// end: Section

		// Preparation Time
			$this->start_controls_section(
				'section_prep_time_style',
				[
					'label' => esc_html__( 'Preparation Time', 'restaurant-cafe-addon-for-elementor' ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'prep_time_padding',
				[
					'label' => __( 'Padding', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],
					'selectors' => [
						'{{WRAPPER}} .narep-chefs-food .prep-time' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'prep_box_shadow',
					'label' => esc_html__( 'Box Shadow', 'restaurant-cafe-addon-for-elementor' ),
					'selector' => '{{WRAPPER}} .narep-chefs-food .prep-time',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Typography', 'restaurant-cafe-addon-for-elementor' ),
					'name' => 'prep_time_typography',
					'selector' => '{{WRAPPER}} .narep-chefs-food .prep-time',
				]
			);
			$this->add_control(
				'prep_time_color',
				[
					'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .narep-chefs-food .prep-time' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'prep_time_bg_color',
				[
					'label' => esc_html__( 'Background Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .narep-chefs-food .prep-time' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();// end: Section

		// Content
			$this->start_controls_section(
				'section_list_style',
				[
					'label' => esc_html__( 'Content', 'restaurant-cafe-addon-for-elementor' ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'cnt_padding',
				[
					'label' => __( 'Content Padding', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .narep-chefs-info p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Content Typography', 'restaurant-cafe-addon-for-elementor' ),
					'name' => 'cnt_typography',
					'selector' => '{{WRAPPER}} .narep-chefs-info p',
				]
			);
			$this->add_control(
				'cnt_color',
				[
					'label' => esc_html__( 'Content Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .narep-chefs-info p' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();// end: Section

		// Video Button
			$this->start_controls_section(
				'section_video_style',
				[
					'label' => esc_html__( 'Video Button', 'restaurant-cafe-addon-for-elementor' ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'vid_btn_width',
				[
					'label' => esc_html__( 'Button Width', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 500,
							'step' => 1,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .narep-video-btn' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->start_controls_tabs( 'icon_style' );
				$this->start_controls_tab(
					'vid_icon_normal',
					[
						'label' => esc_html__( 'Normal', 'restaurant-cafe-addon-for-elementor' ),
					]
				);
				$this->add_control(
					'vid_btn_border_radius',
					[
						'label' => __( 'Border Radius', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} .narep-video-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$this->add_control(
					'vid_icon_color',
					[
						'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .narep-video-btn i' => 'color: {{VALUE}};',
						],
					]
				);
				$this->add_control(
					'vid_icon_bg_color',
					[
						'label' => esc_html__( 'Background Color', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .narep-video-btn' => 'background-color: {{VALUE}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'vid_icon_border',
						'label' => esc_html__( 'Border', 'restaurant-cafe-addon-for-elementor' ),
						'selector' => '{{WRAPPER}} .narep-video-btn',
					]
				);
				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'vid_btn_box_shadow',
						'label' => esc_html__( 'Section Box Shadow', 'restaurant-cafe-addon-for-elementor' ),
						'selector' => '{{WRAPPER}} .narep-video-btn',
					]
				);
				$this->end_controls_tab();  // end:Normal tab

				$this->start_controls_tab(
					'vid_icon_hover',
					[
						'label' => esc_html__( 'Hover', 'restaurant-cafe-addon-for-elementor' ),
					]
				);
				$this->add_control(
					'vid_btn_hov_border_radius',
					[
						'label' => __( 'Border Radius', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} .narep-video-btn:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$this->add_control(
					'vid_icon_hover_color',
					[
						'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .narep-video-btn:hover i' => 'color: {{VALUE}};',
						],
					]
				);
				$this->add_control(
					'vid_icon_bg_hover_color',
					[
						'label' => esc_html__( 'Background Color', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .narep-video-btn:hover, {{WRAPPER}} .narep-video-wrap a:hover .narep-video-btn' => 'background-color: {{VALUE}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'vid_icon_border_hover',
						'label' => esc_html__( 'Border', 'restaurant-cafe-addon-for-elementor' ),
						'selector' => '{{WRAPPER}} .narep-video-btn:hover, {{WRAPPER}} .narep-video-wrap a:hover .narep-video-btn',
					]
				);
				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'vid_btn_hov_box_shadow',
						'label' => esc_html__( 'Section Box Shadow', 'restaurant-cafe-addon-for-elementor' ),
						'selector' => '{{WRAPPER}} .narep-video-btn:hover, {{WRAPPER}} .narep-video-wrap a:hover .narep-video-btn',
					]
				);
				$this->end_controls_tab();  // end:Hover tab
			$this->end_controls_tabs(); // end tabs
			$this->end_controls_section();// end: Section

		// Navigation
			$this->start_controls_section(
				'section_navigation_style',
				[
					'label' => esc_html__( 'Navigation', 'event-elementor-addon' ),
					'tab' => Controls_Manager::TAB_STYLE,
					'condition' => [
						'carousel_nav' => 'true',
					],
					'frontend_available' => true,
				]
			);
			$this->add_responsive_control(
				'arrow_size',
				[
					'label' => esc_html__( 'Size', 'event-elementor-addon' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 42,
							'max' => 1000,
							'step' => 1,
						],
					],
					'size_units' => [ 'px' ],
					'selectors' => [
						'{{WRAPPER}} .owl-carousel .owl-nav button.owl-prev, {{WRAPPER}} .owl-carousel .owl-nav button.owl-next' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .owl-carousel .owl-nav button.owl-prev:before, {{WRAPPER}} .owl-carousel .owl-nav button.owl-next:before' => 'font-size: calc({{SIZE}}{{UNIT}} - 16px);line-height: calc({{SIZE}}{{UNIT}} - 20px);',
					],
				]
			);
			$this->start_controls_tabs( 'nav_arrow_style' );
				$this->start_controls_tab(
					'nav_arrow_normal',
					[
						'label' => esc_html__( 'Normal', 'event-elementor-addon' ),
					]
				);
				$this->add_control(
					'nav_arrow_color',
					[
						'label' => esc_html__( 'Color', 'event-elementor-addon' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .owl-carousel .owl-nav button.owl-prev:before, {{WRAPPER}} .owl-carousel .owl-nav button.owl-next:before' => 'color: {{VALUE}};',
						],
					]
				);
				$this->add_control(
					'nav_arrow_bg_color',
					[
						'label' => esc_html__( 'Background Color', 'event-elementor-addon' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .owl-carousel .owl-nav button.owl-prev, {{WRAPPER}} .owl-carousel .owl-nav button.owl-next' => 'background-color: {{VALUE}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'nav_border',
						'label' => esc_html__( 'Border', 'event-elementor-addon' ),
						'selector' => '{{WRAPPER}} .owl-carousel .owl-nav button.owl-prev, {{WRAPPER}} .owl-carousel .owl-nav button.owl-next',
					]
				);
				$this->end_controls_tab();  // end:Normal tab

				$this->start_controls_tab(
					'nav_arrow_hover',
					[
						'label' => esc_html__( 'Hover', 'event-elementor-addon' ),
					]
				);
				$this->add_control(
					'nav_arrow_hov_color',
					[
						'label' => esc_html__( 'Color', 'event-elementor-addon' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .owl-carousel .owl-nav button.owl-prev:hover:before, {{WRAPPER}} .owl-carousel .owl-nav button.owl-next:hover:before' => 'color: {{VALUE}};',
						],
					]
				);
				$this->add_control(
					'nav_arrow_bg_hover_color',
					[
						'label' => esc_html__( 'Background Color', 'event-elementor-addon' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .owl-carousel .owl-nav button.owl-prev:hover, {{WRAPPER}} .owl-carousel .owl-nav button.owl-next:hover' => 'background-color: {{VALUE}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'nav_active_border',
						'label' => esc_html__( 'Border', 'event-elementor-addon' ),
						'selector' => '{{WRAPPER}} .owl-carousel .owl-nav button.owl-prev:hover, {{WRAPPER}} .owl-carousel .owl-nav button.owl-next:hover',
					]
				);
				$this->end_controls_tab();  // end:Hover tab

			$this->end_controls_tabs(); // end tabs
			$this->end_controls_section();// end: Section

		// Dots
			$this->start_controls_section(
				'section_dots_style',
				[
					'label' => esc_html__( 'Dots', 'event-elementor-addon' ),
					'tab' => Controls_Manager::TAB_STYLE,
					'condition' => [
						'carousel_dots' => 'true',
					],
					'frontend_available' => true,
				]
			);
			$this->add_responsive_control(
				'dots_size',
				[
					'label' => esc_html__( 'Size', 'event-elementor-addon' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
							'step' => 1,
						],
					],
					'size_units' => [ 'px' ],
					'selectors' => [
						'{{WRAPPER}} .owl-carousel .owl-dot' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->add_responsive_control(
				'dots_margin',
				[
					'label' => __( 'Margin', 'event-elementor-addon' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .owl-carousel .owl-dot' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->start_controls_tabs( 'dots_style' );
				$this->start_controls_tab(
					'dots_normal',
					[
						'label' => esc_html__( 'Normal', 'event-elementor-addon' ),
					]
				);
				$this->add_control(
					'dots_color',
					[
						'label' => esc_html__( 'Background Color', 'event-elementor-addon' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .owl-carousel .owl-dot' => 'background: {{VALUE}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'dots_border',
						'label' => esc_html__( 'Border', 'event-elementor-addon' ),
						'selector' => '{{WRAPPER}} .owl-carousel .owl-dot',
					]
				);
				$this->end_controls_tab();  // end:Normal tab

				$this->start_controls_tab(
					'dots_active',
					[
						'label' => esc_html__( 'Active', 'event-elementor-addon' ),
					]
				);
				$this->add_control(
					'dots_active_color',
					[
						'label' => esc_html__( 'Background Color', 'event-elementor-addon' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .owl-carousel .owl-dot.active' => 'background: {{VALUE}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'dots_active_border',
						'label' => esc_html__( 'Border', 'event-elementor-addon' ),
						'selector' => '{{WRAPPER}} .owl-carousel .owl-dot.active',
					]
				);
				$this->end_controls_tab();  // end:Active tab

			$this->end_controls_tabs(); // end tabs
			$this->end_controls_section();// end: Section

	}

	/**
	 * Render App Works widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	*/
	protected function render() {
		$settings = $this->get_settings_for_display();
		$chefs_image = !empty( $settings['chefs_image']['id'] ) ? $settings['chefs_image']['id'] : '';
		$image_url = wp_get_attachment_url( $chefs_image );
		$chefs_name = !empty( $settings['chefs_name'] ) ? $settings['chefs_name'] : '';
		$chefs_role = !empty( $settings['chefs_role'] ) ? $settings['chefs_role'] : '';
		$btn_text = !empty( $settings['btn_text'] ) ? $settings['btn_text'] : '';
  	$btn_link = !empty( $settings['btn_link']['url'] ) ? $settings['btn_link']['url'] : '';
		$btn_link_external = !empty( $settings['btn_link']['is_external'] ) ? 'target="_blank"' : '';
		$btn_link_nofollow = !empty( $settings['btn_link']['nofollow'] ) ? 'rel="nofollow"' : '';
		$btn_link_attr = !empty( $btn_link ) ?  $btn_link_external.' '.$btn_link_nofollow : '';

		$chefs_info = !empty( $settings['chefs_info'] ) ? $settings['chefs_info'] : '';
		$recipes_title = !empty( $settings['recipes_title'] ) ? $settings['recipes_title'] : '';
		$contact_title = !empty( $settings['contact_title'] ) ? $settings['contact_title'] : '';
		$toggle_align = !empty( $settings['toggle_align'] ) ? $settings['toggle_align'] : '';

		$receipes_groups = !empty( $settings['receipes_groups'] ) ? $settings['receipes_groups'] : '';
		$contact_groups = !empty( $settings['contact_groups'] ) ? $settings['contact_groups'] : '';

  	$title = !empty( $chefs_name ) ? '<h2 class="narep-chefs-title">'.$chefs_name.'</h2>' : '';
  	$role = !empty( $chefs_role ) ? '<h3>'.$chefs_role.'</h3>' : '';
  	$recipes_title = !empty( $recipes_title ) ? '<h5>'.$recipes_title.'</h5>' : '';
  	$chefs_info = !empty( $chefs_info ) ? '<p>'.$chefs_info.'</p>' : '';
  	$contact_title = !empty( $contact_title ) ? '<h5>'.$contact_title.'</h5>' : '';
		$chefs_image = $image_url ? '<div class="narep-image chefs-image"><img src="'.esc_url($image_url).'" alt="'.esc_attr($chefs_name).'"></div>' : '';
		$button = $btn_link ? '<div class="narep-btn-wrap"><a href="'.esc_url($btn_link).'" '.$btn_link_attr.' class="narep-btn black-btn">'. esc_html($btn_text) .'</a></div>' : '';

		if ($toggle_align) {
			$f_cls = ' nich-order-1';
			$s_cls = ' nich-order-2';
		} else {
			$f_cls = '';
			$s_cls = '';
		}

		// Carousel
			$carousel_item = !empty( $settings['carousel_item'] ) ? $settings['carousel_item'] : '';
			$swipeSliders_groups = !empty( $settings['swipeSliders_groups'] ) ? $settings['swipeSliders_groups'] : [];
			$carousel_autoplay_timeout = !empty( $settings['carousel_autoplay_timeout'] ) ? $settings['carousel_autoplay_timeout'] : '';
			$carousel_speed = !empty( $settings['carousel_speed'] ) ? $settings['carousel_speed'] : '';
			$carousel_loop  = ( isset( $settings['carousel_loop'] ) && ( 'true' == $settings['carousel_loop'] ) ) ? $settings['carousel_loop'] : 'false';
			$carousel_dots  = ( isset( $settings['carousel_dots'] ) && ( 'true' == $settings['carousel_dots'] ) ) ? true : false;
			$carousel_nav  = ( isset( $settings['carousel_nav'] ) && ( 'true' == $settings['carousel_nav'] ) ) ? true : false;
			$carousel_autoplay  = ( isset( $settings['carousel_autoplay'] ) && ( 'true' == $settings['carousel_autoplay'] ) ) ? true : false;
			$clickable_pagi = ( isset( $settings['clickable_pagi'] ) && ( 'true' == $settings['clickable_pagi'] ) ) ? true : false;
			$carousel_mousedrag  = ( isset( $settings['carousel_mousedrag'] ) && ( 'true' == $settings['carousel_mousedrag'] ) ) ? $settings['carousel_mousedrag'] : 'false';

		// Carousel Data's
			$carousel_item = $carousel_item ? ' data-item="'.$carousel_item.'"' : ' data-item="3"';
			$carousel_space = $carousel_space ? ' data-space="'.$carousel_space.'"' : ' data-space="30"';
			$carousel_loop = $carousel_loop !== 'true' ? ' data-loop="true"' : ' data-loop="false"';
			$carousel_autoplay_timeout = $carousel_autoplay_timeout ? ' data-swiper-autoplay='. $carousel_autoplay_timeout .'' : ' data-swiper-autoplay=5000';
			$carousel_speed = $carousel_speed ? ' data-speed="'. $carousel_speed .'"' : ' data-speed="1000"';
			$carousel_autoplay = $carousel_autoplay ? ' data-autoplay="true"' : ' data-autoplay="false"';
			$clickable_pagi = $clickable_pagi ? 'data-clickpage="true"' : '';
			$carousel_effect = (isset($settings['carousel_effect'])) ? ' data-effect="'.$carousel_effect.'"' : '';
			$carousel_mousedrag = $carousel_mousedrag !== 'true' ? ' data-mousedrag="true"' : ' data-mousedrag="false"';
			$content_entrance_animation = !empty( $settings['content_entrance_animation'] ) ? $settings['content_entrance_animation'] : '';
			$title_entrance_animation = !empty( $settings['title_entrance_animation'] ) ? $settings['title_entrance_animation'] : '';
			$button_entrance_animation = !empty( $settings['button_entrance_animation'] ) ? $settings['button_entrance_animation'] : '';
			$image_entrance_animation = !empty( $settings['image_entrance_animation'] ) ? $settings['image_entrance_animation'] : '';

		$output = '<div class="narep-chefs-wrap zoom-image">
								<div class="narep-chefs-item">
			            <div class="nich-row nich-align-items-center">
			              <div class="nich-col-xl-6 nich-col-lg-12'.$s_cls.'">'.$chefs_image.'</div>
			              <div class="nich-col-xl-6 nich-col-lg-12'.$f_cls.'">
			                <div class="narep-chefs-info">
			                	<div class="narep-chefs-info-wrap">
				                	<div class="narep-chefs-name">'.$title.$role.'</div>'.$button.'
			                  </div>
			                  '.$chefs_info.'
			                  <div class="narep-chefs-carousel">'.$recipes_title.'
			                  <div class="swiper narep-swiper-slide swiper-slides swiper-keyboard" '. $carousel_item . $carousel_space . $carousel_loop . $carousel_autoplay . $carousel_effect . $carousel_speed . $clickable_pagi . $carousel_mousedrag.' data-swiper="container"><div class="swiper-wrapper">';
													if ( is_array( $receipes_groups ) && !empty( $receipes_groups ) ) {
													  foreach ( $receipes_groups as $each_list ) {
													  	$food_image = !empty( $each_list['food_image']['id'] ) ? $each_list['food_image']['id'] : '';
															$food_image_url = wp_get_attachment_url( $food_image );
													  	$list_text = !empty( $each_list['list_text'] ) ? $each_list['list_text'] : '';
													  	$link_style = !empty( $each_list['link_style'] ) ? $each_list['link_style'] : '';
													  	$image_link = !empty( $each_list['image_link']['url'] ) ? $each_list['image_link']['url'] : '';
															$image_link_external = !empty( $each_list['image_link']['is_external'] ) ? 'target="_blank"' : '';
															$image_link_nofollow = !empty( $each_list['image_link']['nofollow'] ) ? 'rel="nofollow"' : '';
															$image_link_attr = !empty( $image_link ) ?  $image_link_external.' '.$image_link_nofollow : '';

															$video_link = !empty( $each_list['video_link'] ) ? $each_list['video_link'] : '';
															$prep_time = !empty( $each_list['prep_time'] ) ? $each_list['prep_time'] : '';
															$btn_icon = !empty( $each_list['btn_icon'] ) ? $each_list['btn_icon'] : '';
													  	$btn_icon = $btn_icon ? ' <i class="'.esc_attr($btn_icon).'"></i>' : '';
													  	$prep_time = $prep_time ? '<h6 class="prep-time">'.$prep_time.'</h6>' : '';
															$video = $video_link ? $prep_time.'<div class="narep-video-btn-wrap"><a href="'.esc_url($video_link).'" class="narep-video-btn narep-popup-video">'.$btn_icon.'</a></div>' : '';

															if ($link_style === 'two') {
																$popup_class = '';
																$food_image = $image_link ? '<a href="'.esc_url($image_link).'" '.$image_link_attr.'><img src="'.esc_url($food_image_url).'" alt="'.esc_attr($list_text).'"></a>' : '<img src="'.esc_url($food_image_url).'" alt="'.esc_attr($list_text).'">';
															} elseif ($link_style === 'three') {
																$popup_class = ' img-link';
																$food_image = $video_link ? '<img src="'.esc_url($food_image_url).'" alt="'.esc_attr($list_text).'">'.$video : '<img src="'.esc_url($food_image_url).'" alt="'.esc_attr($list_text).'">';
															} else {
																$popup_class = ' narep-popup';
																$food_image = '<a href="'. esc_url($food_image_url) .'"><img src="'.esc_url($food_image_url).'" alt="'.esc_attr($list_text).'"></a>';
															}
															$food_item_image = $food_image_url ? '<div class="narep-image'.$popup_class.'">'.$food_image.'</div>' : '';
													  	$text = $list_text ? '<h4>'. esc_html($list_text) .'</h4>' : '';
					                  	$output .= '<div class="swiper-slide">
					                  								<div class="narep-chefs-food zoom-image">
					                  									'.$food_item_image.$text.'
					                  								</div>
				                  								</div>';
						                }
						              }
	          $output .= '</div>';
	          						if ($carousel_nav) {
													$output .= '<div class="swiper-button-prev"></div><div class="swiper-button-next"></div>';
												}
										    if ($carousel_dots) {
										    	$output .= '<div class="swiper-pagination"></div>';
										    }
										    $output .= '<div class="swiper-scrollbar"></div></div></div>'.$contact_title;
												// Group Param Output
												if ( is_array( $contact_groups ) && !empty( $contact_groups ) ) {
													$output .= '<div class="narep-social rounded">';
												  foreach ( $contact_groups as $contact_list ) {
												  $icon_link = !empty( $contact_list['icon_link'] ) ? $contact_list['icon_link'] : '';

													$link_url = !empty( $icon_link['url'] ) ? esc_url($icon_link['url']) : '';
													$link_external = !empty( $icon_link['is_external'] ) ? 'target="_blank"' : '';
													$link_nofollow = !empty( $icon_link['nofollow'] ) ? 'rel="nofollow"' : '';
													$link_attr = !empty( $icon_link['url'] ) ?  $link_external.' '.$link_nofollow : '';

												  $social_icon = !empty( $contact_list['social_icon'] ) ? $contact_list['social_icon'] : '';
													$icon = $social_icon ? '<i class="'.esc_attr($social_icon).'" aria-hidden="true"></i>' : '';

												  $output .= '<a href="'.esc_url($link_url).'" '.$link_attr.'>'.$icon.'</a>';
													}
													$output .= '</div>';
												}
          $output .= '</div>
			              </div>
			            </div>
			          </div>
		          </div>';
		echo $output;

	}

}
Plugin::instance()->widgets_manager->register_widget_type( new Restaurant_Elementor_Addon_Unique_ChefsRecipe() );

} // enable & disable
