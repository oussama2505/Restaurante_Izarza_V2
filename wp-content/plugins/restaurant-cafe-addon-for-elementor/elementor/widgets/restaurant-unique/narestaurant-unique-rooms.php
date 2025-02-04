<?php
/*
 * Elementor Restaurant & Cafe Addon for Elementor Rooms Widget
 * Author & Copyright: NicheAddon
*/

namespace Elementor;

if (!isset(get_option( 'rcafe_uw_settings' )['nbeds_rooms'])) { // enable & disable

// Only for free users
if ( rcafe_fs()->is_free_plan() ) {

	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	class Restaurant_Elementor_Addon_Unique_Rooms extends Widget_Base{

		/**
		 * Retrieve the widget name.
		*/
		public function get_name(){
			return 'narestaurant_unique_rooms';
		}

		/**
		 * Retrieve the widget title.
		*/
		public function get_title(){
			return esc_html__( 'Rooms', 'restaurant-cafe-addon-for-elementor' );
		}

		/**
		 * Retrieve the widget icon.
		*/
		public function get_icon() {
			return 'eicon-tv';
		}

		/**
		 * Retrieve the list of categories the widget belongs to.
		*/
		public function get_categories() {
			return ['narestaurant-unique-category'];
		}

		/**
		 * Register Restaurant & Cafe Addon for Elementor Rooms widget controls.
		 * Adds different input fields to allow the user to change and customize the widget settings.
		*/
		protected function _register_controls(){

			$this->start_controls_section(
				'section_rooms',
				[
					'label' => __( 'Rooms Options', 'restaurant-cafe-addon-for-elementor' ),
				]
			);
			$repeater = new Repeater();
			$repeater->add_control(
				'rooms_image',
				[
					'label' => esc_html__( 'Rooms Image', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::MEDIA,
					'frontend_available' => true,
					'default' => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'description' => esc_html__( 'Set your image.', 'restaurant-cafe-addon-for-elementor'),
				]
			);
			$repeater->add_control(
				'rooms_title',
				[
					'label' => esc_html__( 'Rooms Title', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'Outdoor Wedding', 'restaurant-cafe-addon-for-elementor' ),
					'placeholder' => esc_html__( 'Type title text here', 'restaurant-cafe-addon-for-elementor' ),
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'title_link',
				[
					'label' => esc_html__( 'Text Link', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::URL,
					'placeholder' => 'https://your-link.com',
					'default' => [
						'url' => '',
					],
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'rooms_sub_title',
				[
					'label' => esc_html__( 'Rooms Sub Title', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'Wedding Hall', 'restaurant-cafe-addon-for-elementor' ),
					'placeholder' => esc_html__( 'Type sub title text here', 'restaurant-cafe-addon-for-elementor' ),
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'rooms_price',
				[
					'label' => esc_html__( 'Room Price', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( '$250', 'restaurant-cafe-addon-for-elementor' ),
					'placeholder' => esc_html__( 'Type sub title text here', 'restaurant-cafe-addon-for-elementor' ),
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'rooms_time',
				[
					'label' => esc_html__( 'Room Timing', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'per day', 'restaurant-cafe-addon-for-elementor' ),
					'placeholder' => esc_html__( 'Type time text here', 'restaurant-cafe-addon-for-elementor' ),
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'rooms_content',
				[
					'label' => esc_html__( 'Rooms Content', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::TEXTAREA,
					'default' => esc_html__( 'The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using Content here, content here, making it look like readable English...', 'restaurant-cafe-addon-for-elementor' ),
					'placeholder' => esc_html__( 'Type text here', 'restaurant-cafe-addon-for-elementor' ),
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'btn_text',
				[
					'label' => esc_html__( 'Button Title', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'Buy Now', 'restaurant-cafe-addon-for-elementor' ),
					'placeholder' => esc_html__( 'Type button text here', 'restaurant-cafe-addon-for-elementor' ),
					'label_block' => true,
				]
			);
			$repeater->add_control(
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
			$repeater->start_controls_tabs( 'rm_info' );
				$repeater->start_controls_tab(
					'rm_info1',
					[
						'label' => esc_html__( 'Info 1', 'restaurant-cafe-addon-for-elementor' ),
					]
				);
				$repeater->add_control(
					'upload_type',
					[
						'label' => __( 'Icon Type', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::SELECT,
						'options' => [
							'image' => esc_html__( 'Image', 'restaurant-cafe-addon-for-elementor' ),
							'icon' => esc_html__( 'Icon', 'restaurant-cafe-addon-for-elementor' ),
						],
						'default' => 'icon',
					]
				);
				$repeater->add_control(
					'info_image',
					[
						'label' => esc_html__( 'Upload Icon', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::MEDIA,
						'condition' => [
							'upload_type' => 'image',
						],
						'frontend_available' => true,
						'default' => [
							'url' => Utils::get_placeholder_image_src(),
						],
						'description' => esc_html__( 'Set your icon image.', 'restaurant-cafe-addon-for-elementor'),
					]
				);
				$repeater->add_control(
					'info_icon',
					[
						'label' => esc_html__( 'Sub Title Icon', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::ICON,
						'options' => NAREP_Controls_Helper_Output::get_include_icons(),
						'frontend_available' => true,
						'default' => 'icofont-chef',
						'condition' => [
							'upload_type' => 'icon',
						],
					]
				);
				$repeater->add_control(
					'info_text',
					[
						'label' => esc_html__( 'Room Info', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::TEXT,
						'default' => esc_html__( 'Buffet', 'restaurant-cafe-addon-for-elementor' ),
						'placeholder' => esc_html__( 'Type title text here', 'restaurant-cafe-addon-for-elementor' ),
						'label_block' => true,
					]
				);
				$repeater->end_controls_tab();
				$repeater->start_controls_tab(
					'rm_info2',
					[
						'label' => esc_html__( 'Info 2', 'restaurant-cafe-addon-for-elementor' ),
					]
				);
				$repeater->add_control(
					'upload_type_two',
					[
						'label' => __( 'Icon Type', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::SELECT,
						'options' => [
							'image' => esc_html__( 'Image', 'restaurant-cafe-addon-for-elementor' ),
							'icon' => esc_html__( 'Icon', 'restaurant-cafe-addon-for-elementor' ),
						],
						'default' => 'icon',
					]
				);
				$repeater->add_control(
					'info_image_two',
					[
						'label' => esc_html__( 'Upload Icon', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::MEDIA,
						'condition' => [
							'upload_type_two' => 'image',
						],
						'frontend_available' => true,
						'default' => [
							'url' => Utils::get_placeholder_image_src(),
						],
						'description' => esc_html__( 'Set your icon image.', 'restaurant-cafe-addon-for-elementor'),
					]
				);
				$repeater->add_control(
					'info_icon_two',
					[
						'label' => esc_html__( 'Sub Title Icon', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::ICON,
						'options' => NAREP_Controls_Helper_Output::get_include_icons(),
						'frontend_available' => true,
						'default' => 'icofont-chef',
						'condition' => [
							'upload_type_two' => 'icon',
						],
					]
				);
				$repeater->add_control(
					'info_text_two',
					[
						'label' => esc_html__( 'Room Info', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::TEXT,
						'default' => esc_html__( 'Buffet', 'restaurant-cafe-addon-for-elementor' ),
						'placeholder' => esc_html__( 'Type title text here', 'restaurant-cafe-addon-for-elementor' ),
						'label_block' => true,
					]
				);
				$repeater->end_controls_tab();
			$repeater->end_controls_tabs();
			$repeater->add_control(
				'toggle_align',
				[
					'label' => esc_html__( 'Toggle Align?', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Yes', 'restaurant-cafe-addon-for-elementor' ),
					'label_off' => esc_html__( 'No', 'restaurant-cafe-addon-for-elementor' ),
					'return_value' => 'true',
					'separator' => 'before',
				]
			);
			$this->add_control(
				'roomItems_groups',
				[
					'label' => esc_html__( 'Rooms Item', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::REPEATER,
					'default' => [
						[
							'rooms_title' => esc_html__( 'Outdoor Wedding', 'restaurant-cafe-addon-for-elementor' ),
						],
					],
					'fields' => $repeater->get_controls(),
					'title_field' => '{{{ rooms_title }}}',
					'prevent_empty' => false,
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
				$this->add_responsive_control(
					'section_margin',
					[
						'label' => __( 'Margin', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px' ],
						'selectors' => [
							'{{WRAPPER}} .narep-rooms-info' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
							'{{WRAPPER}} .narep-rooms-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'secn_border',
						'label' => esc_html__( 'Border', 'restaurant-cafe-addon-for-elementor' ),
						'selector' => '{{WRAPPER}} .narep-rooms-info',
					]
				);
				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'section_box_shadow',
						'label' => esc_html__( 'Box Shadow', 'restaurant-cafe-addon-for-elementor' ),
						'selector' => '{{WRAPPER}} .narep-rooms-info',
					]
				);
				$this->add_responsive_control(
					'secn_width',
					[
						'label' => esc_html__( 'Content Max Width', 'restaurant-cafe-addon-for-elementor' ),
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
							'{{WRAPPER}} .narep-rooms-info' => 'max-width:{{SIZE}}{{UNIT}};',
						],
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
							'{{WRAPPER}} .narep-rooms-title h3' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'label' => esc_html__( 'Typography', 'restaurant-cafe-addon-for-elementor' ),
						'name' => 'sastool_title_typography',
						'selector' => '{{WRAPPER}} .narep-rooms-title h3',
					]
				);
				$this->start_controls_tabs( 'title_style' );
					$this->start_controls_tab(
						'title_normal',
						[
							'label' => esc_html__( 'Normal', 'restaurant-cafe-addon-for-elementor' ),
						]
					);
					$this->add_control(
						'title_color',
						[
							'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .narep-rooms-title h3, {{WRAPPER}} .narep-rooms-title h3 a' => 'color: {{VALUE}};',
							],
						]
					);
					$this->end_controls_tab();  // end:Normal tab
					$this->start_controls_tab(
						'title_hover',
						[
							'label' => esc_html__( 'Hover', 'restaurant-cafe-addon-for-elementor' ),
						]
					);
					$this->add_control(
						'title_hover_color',
						[
							'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .narep-rooms-title h3 a:hover' => 'color: {{VALUE}};',
							],
						]
					);
					$this->end_controls_tab();  // end:Hover tab
				$this->end_controls_tabs(); // end tabs
				$this->end_controls_section();// end: Section

			// Sub Title
				$this->start_controls_section(
					'section_sub_title_style',
					[
						'label' => esc_html__( 'Sub Title', 'restaurant-cafe-addon-for-elementor' ),
						'tab' => Controls_Manager::TAB_STYLE,
					]
				);
				$this->add_responsive_control(
					'sub_title_padding',
					[
						'label' => __( 'Padding', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px' ],
						'selectors' => [
							'{{WRAPPER}} .rooms-title-wrap p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'label' => esc_html__( 'Typography', 'restaurant-cafe-addon-for-elementor' ),
						'name' => 'sub_title_typography',
						'selector' => '{{WRAPPER}} .rooms-title-wrap p',
					]
				);
				$this->add_control(
					'sub_title_color',
					[
						'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .rooms-title-wrap p' => 'color: {{VALUE}};',
						],
					]
				);
				$this->end_controls_section();// end: Section

			// Time
				$this->start_controls_section(
					'section_time_style',
					[
						'label' => esc_html__( 'Time', 'restaurant-cafe-addon-for-elementor' ),
						'tab' => Controls_Manager::TAB_STYLE,
					]
				);
				$this->add_responsive_control(
					'time_padding',
					[
						'label' => __( 'Padding', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px' ],
						'selectors' => [
							'{{WRAPPER}} .rooms-price-wrap p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'label' => esc_html__( 'Typography', 'restaurant-cafe-addon-for-elementor' ),
						'name' => 'time_typography',
						'selector' => '{{WRAPPER}} .rooms-price-wrap p',
					]
				);
				$this->add_control(
					'time_color',
					[
						'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .rooms-price-wrap p' => 'color: {{VALUE}};',
						],
					]
				);
				$this->end_controls_section();// end: Section

			// Content
				$this->start_controls_section(
					'section_content_style',
					[
						'label' => esc_html__( 'Content', 'restaurant-cafe-addon-for-elementor' ),
						'tab' => Controls_Manager::TAB_STYLE,
					]
				);
				$this->add_responsive_control(
					'content_padding',
					[
						'label' => __( 'Padding', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px' ],
						'selectors' => [
							'{{WRAPPER}} .narep-rooms-info p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'label' => esc_html__( 'Typography', 'restaurant-cafe-addon-for-elementor' ),
						'name' => 'sastool_content_typography',
						'selector' => '{{WRAPPER}} .narep-rooms-info p',
					]
				);
				$this->add_control(
					'content_color',
					[
						'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .narep-rooms-info p' => 'color: {{VALUE}};',
						],
					]
				);
				$this->end_controls_section();// end: Section

			// List
				$this->start_controls_section(
					'section_list_style',
					[
						'label' => esc_html__( 'List', 'restaurant-cafe-addon-for-elementor' ),
						'tab' => Controls_Manager::TAB_STYLE,
					]
				);
				$this->add_control(
					'rinfo_icon',
					[
						'label' => __( 'Icon', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::HEADING,
						'separator' => 'after',
					]
				);
				$this->add_control(
					'icon_padding',
					[
						'label' => __( 'Padding', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} ul.narep-room-list li h4 span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$this->add_control(
					'rinfo_icon_color',
					[
						'label' => esc_html__( 'Icon Color', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} ul.narep-room-list li h4 span' => 'color: {{VALUE}};',
						],
					]
				);
				$this->add_control(
					'rinfo_icon_size',
					[
						'label' => esc_html__( 'Icon Size', 'restaurant-cafe-addon-for-elementor' ),
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
							'{{WRAPPER}} ul.narep-room-list li h4 span i' => 'font-size: {{SIZE}}{{UNIT}};',
						],
					]
				);
				$this->add_control(
					'rinfo_text',
					[
						'label' => __( 'Text', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::HEADING,
						'separator' => 'after',
					]
				);
				$this->add_control(
					'list_padding',
					[
						'label' => __( 'Padding', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} ul.narep-room-list li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'label' => esc_html__( 'Typography', 'restaurant-cafe-addon-for-elementor' ),
						'name' => 'list_typography',
						'selector' => '{{WRAPPER}} ul.narep-room-list li',
					]
				);
				$this->start_controls_tabs( 'list_style' );
					$this->start_controls_tab(
						'list_normal',
						[
							'label' => esc_html__( 'Normal', 'restaurant-cafe-addon-for-elementor' ),
						]
					);
					$this->add_control(
						'list_color',
						[
							'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} ul.narep-room-list li, {{WRAPPER}} ul.narep-room-list li a' => 'color: {{VALUE}};',
							],
						]
					);
					$this->end_controls_tab();  // end:Normal tab
					$this->start_controls_tab(
						'list_hover',
						[
							'label' => esc_html__( 'Hover', 'restaurant-cafe-addon-for-elementor' ),
						]
					);
					$this->add_control(
						'list_hover_color',
						[
							'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} ul.narep-room-list li a:hover' => 'color: {{VALUE}};',
							],
						]
					);
					$this->end_controls_tab();  // end:Hover tab
				$this->end_controls_tabs(); // end tabs
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

		}

		/**
		 * Render App Works widget output on the frontend.
		 * Written in PHP and used to generate the final HTML.
		*/
		protected function render() {
			$settings = $this->get_settings_for_display();
			$roomItems_groups = !empty( $settings['roomItems_groups'] ) ? $settings['roomItems_groups'] : '';

			$output = '<div class="narep-rooms-item">';
			if ( is_array( $roomItems_groups ) && !empty( $roomItems_groups ) ) {
			  foreach ( $roomItems_groups as $each_room ) {
					$rooms_image = !empty( $each_room['rooms_image']['id'] ) ? $each_room['rooms_image']['id'] : '';
					$image_url = wp_get_attachment_url( $rooms_image );
					$rooms_title = !empty( $each_room['rooms_title'] ) ? $each_room['rooms_title'] : '';
					$title_link = !empty( $each_room['title_link']['url'] ) ? $each_room['title_link']['url'] : '';
					$title_link_external = !empty( $each_room['title_link']['is_external'] ) ? 'target="_blank"' : '';
					$title_link_nofollow = !empty( $each_room['title_link']['nofollow'] ) ? 'rel="nofollow"' : '';
					$title_link_attr = !empty( $title_link ) ?  $title_link_external.' '.$title_link_nofollow : '';
					$rooms_sub_title = !empty( $each_room['rooms_sub_title'] ) ? $each_room['rooms_sub_title'] : '';
					$rooms_price = !empty( $each_room['rooms_price'] ) ? $each_room['rooms_price'] : '';
					$rooms_time = !empty( $each_room['rooms_time'] ) ? $each_room['rooms_time'] : '';
					$rooms_content = !empty( $each_room['rooms_content'] ) ? $each_room['rooms_content'] : '';
					$btn_text = !empty( $each_room['btn_text'] ) ? $each_room['btn_text'] : '';
					$btn_link = !empty( $each_room['btn_link']['url'] ) ? $each_room['btn_link']['url'] : '';
					$btn_link_external = !empty( $each_room['btn_link']['is_external'] ) ? 'target="_blank"' : '';
					$btn_link_nofollow = !empty( $each_room['btn_link']['nofollow'] ) ? 'rel="nofollow"' : '';
					$btn_link_attr = !empty( $btn_link ) ?  $btn_link_external.' '.$btn_link_nofollow : '';
					$upload_type = !empty( $each_room['upload_type'] ) ? $each_room['upload_type'] : '';
					$info_image = !empty( $each_room['info_image']['id'] ) ? $each_room['info_image']['id'] : '';
					$info_icon = !empty( $each_room['info_icon'] ) ? $each_room['info_icon'] : '';
			  	$info_text = !empty( $each_room['info_text'] ) ? $each_room['info_text'] : '';
			  	$upload_type_two = !empty( $each_room['upload_type_two'] ) ? $each_room['upload_type_two'] : '';
					$info_image_two = !empty( $each_room['info_image_two']['id'] ) ? $each_room['info_image_two']['id'] : '';
					$info_icon_two = !empty( $each_room['info_icon_two'] ) ? $each_room['info_icon_two'] : '';
			  	$info_text_two = !empty( $each_room['info_text_two'] ) ? $each_room['info_text_two'] : '';
					$toggle_align = !empty( $each_room['toggle_align'] ) ? $each_room['toggle_align'] : '';

					$rooms_image = $image_url ? '<div class="narep-image"><img src="'.esc_url($image_url).'" alt="'.esc_attr($rooms_title).'"></div>' : '';
			  	$title_link = !empty( $title_link ) ? '<a href="'.esc_url($title_link).'" '.$title_link_attr.'>'.esc_html($rooms_title).'</a>' : esc_html($rooms_title);
			  	$title = !empty( $rooms_title ) ? '<h3>'.$title_link.'</h3>' : '';
			  	$subtitle = !empty( $rooms_sub_title ) ? '<p>'.$rooms_sub_title.'</p>' : '';
			  	$price = !empty( $rooms_price ) ? '<h3>'.$rooms_price.'</h3>' : '';
			  	$time = !empty( $rooms_time ) ? '<p>'.$rooms_time.'</p>' : '';
			  	$content = !empty( $rooms_content ) ? '<p>'.$rooms_content.'</p>' : '';
					$button = $btn_link ? '<li><div class="narep-btn-wrap"><a href="'.esc_url($btn_link).'" '.$btn_link_attr.' class="narep-btn black-btn">'. esc_html($btn_text) .'</a></div></li>' : '';

					if ($toggle_align) {
						$f_cls = ' nich-order-1';
						$s_cls = ' nich-order-2';
					} else {
						$f_cls = '';
						$s_cls = '';
					}

					$info_image_url = wp_get_attachment_url( $info_image );
					$info_image = $info_image_url ? '<span class="narep-icon"><img src="'.esc_url($info_image_url).'" alt="'.esc_attr($info_text).'"></span>' : '';
					$info_icon = $info_icon ? '<span class="narep-icon"><i class="'.esc_attr($info_icon).'"></i></span>' : '';

					if ($upload_type === 'icon'){
					  $icon_main = $info_icon;
					} else {
					  $icon_main = $info_image;
					}
			  	$info1 = $info_text ? '<li><h4>'.$icon_main. esc_html($info_text) .'</h4></li>' : '';

					$info_image_two_url = wp_get_attachment_url( $info_image_two );
					$info_image_two = $info_image_two_url ? '<span class="narep-icon"><img src="'.esc_url($info_image_two_url).'" alt="'.esc_attr($info_text_two).'"></span>' : '';
					$info_icon_two = $info_icon_two ? '<span class="narep-icon"><i class="'.esc_attr($info_icon_two).'"></i></span>' : '';

					if ($upload_type_two === 'icon'){
					  $icon_main_two = $info_icon_two;
					} else {
					  $icon_main_two = $info_image_two;
					}
			  	$info2 = $info_text_two ? '<li><h4>'.$icon_main_two. esc_html($info_text_two) .'</h4></li>' : '';

					$output .= '<div class="nich-row nich-align-items-center">
				                <div class="nich-col-xl-6 nich-col-lg-12'.$s_cls.'">'.$rooms_image.'</div>
				                <div class="nich-col-xl-6 nich-col-lg-12'.$f_cls.'">
				                  <div class="narep-rooms-info">
				                  	<div class="narep-rooms-title">
					                  	<div class="rooms-title-wrap">
					                  		'.$title.$subtitle.'
					                  	</div>
					                  	<div class="rooms-price-wrap">
					                  		'.$price.$time.'
					                  	</div>
				                  	</div>
				                    '.$content.'
				                    <ul class="narep-room-list">'.$button.$info1.$info2.'</ul>
				                  </div>
				                </div>
				              </div>';
	      }
	    }
			$output .= '</div>';
			echo $output;

		}

	}
	Plugin::instance()->widgets_manager->register_widget_type( new Restaurant_Elementor_Addon_Unique_Rooms() );
} // is_free

} // enable & disable
