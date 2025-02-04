<?php
/*
 * Elementor Restaurant & Cafe Addon for Elementor Open Table Widget
 * Author & Copyright: NicheAddon
*/

namespace Elementor;

if (!isset(get_option( 'rcafe_uw_settings' )['nbeds_open_table'])) { // enable & disable

// Only for free users
if ( rcafe_fs()->is_free_plan() ) {

	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	class Restaurant_Elementor_Addon_Unique_OpenTable extends Widget_Base{

		/**
		 * Retrieve the widget name.
		*/
		public function get_name(){
			return 'narestaurant_unique_open_table';
		}

		/**
		 * Retrieve the widget title.
		*/
		public function get_title(){
			return esc_html__( 'Open Table', 'restaurant-cafe-addon-for-elementor' );
		}

		/**
		 * Retrieve the widget icon.
		*/
		public function get_icon() {
			return 'eicon-gallery-grid';
		}

		/**
		 * Retrieve the list of categories the widget belongs to.
		*/
		public function get_categories() {
			return ['narestaurant-unique-category'];
		}

		/**
		 * Register Restaurant & Cafe Addon for Elementor Open Table widget controls.
		 * Adds different input fields to allow the user to change and customize the widget settings.
		*/
		protected function _register_controls(){

			$this->start_controls_section(
				'section_opt',
				[
					'label' => __( 'Section Title', 'restaurant-cafe-addon-for-elementor' ),
				]
			);
			$this->add_control(
				'section_image',
				[
					'label' => esc_html__( 'Section Image', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::MEDIA,
					'frontend_available' => true,
					'default' => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'description' => esc_html__( 'Set your image.', 'restaurant-cafe-addon-for-elementor'),
				]
			);
			$this->add_control(
				'section_title',
				[
					'label' => esc_html__( 'Section Title', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'Make a reservation', 'restaurant-cafe-addon-for-elementor' ),
					'placeholder' => esc_html__( 'Type title text here', 'restaurant-cafe-addon-for-elementor' ),
					'label_block' => true,
				]
			);
			$this->add_control(
				'section_sub_title',
				[
					'label' => esc_html__( 'Section Sub Title', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'Booking', 'restaurant-cafe-addon-for-elementor' ),
					'placeholder' => esc_html__( 'Type title text here', 'restaurant-cafe-addon-for-elementor' ),
					'label_block' => true,
				]
			);
			$this->add_control(
				'title_image',
				[
					'label' => esc_html__( 'Title / Food Image', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::MEDIA,
					'frontend_available' => true,
					'default' => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'description' => esc_html__( 'Set your image.', 'restaurant-cafe-addon-for-elementor'),
				]
			);
			$this->end_controls_section();// end: Section

			$this->start_controls_section(
				'section_opt_form',
				[
					'label' => __( 'Form Options', 'restaurant-cafe-addon-for-elementor' ),
				]
			);
			$this->add_control(
				'ot_date_format',
				[
					'label' => esc_html__( 'Date Formate', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::TEXT,
					'label_block' => true,
					'description' => __( 'Enter date format (for more info <a href="https://wordpress.org/support/article/formatting-date-and-time/" target="_blank">click here</a>).', 'restaurant-cafe-addon-for-elementor' ),
				]
			);
			$this->add_control(
				'metro_id',
				[
					'label' => esc_html__( 'Metro Ids', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::TEXT,
					'label_block' => true,
					'description' => __( 'Default Metro Id : 3401.<br/><a href="https://www.opentable.com/start/home" target="_blank">Know more about metro here.</a>.', 'restaurant-cafe-addon-for-elementor' ),
				]
			);
			$this->add_control(
				'region_ids',
				[
					'label' => esc_html__( 'Region Ids', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::TEXT,
					'label_block' => true,
					'description' => __( 'Default Region Id : 9013.<br/><a href="https://www.opentable.com/start/home" target="_blank">Know more about region here.</a>.', 'restaurant-cafe-addon-for-elementor' ),
				]
			);
			$this->add_control(
				'date_label',
				[
					'label' => esc_html__( 'Date Label', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'Date', 'restaurant-cafe-addon-for-elementor' ),
					'placeholder' => esc_html__( 'Type text here', 'restaurant-cafe-addon-for-elementor' ),
					'label_block' => true,
				]
			);
			$this->add_control(
				'time_label',
				[
					'label' => esc_html__( 'Default Name', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'Time', 'restaurant-cafe-addon-for-elementor' ),
					'placeholder' => esc_html__( 'Enter default name', 'restaurant-cafe-addon-for-elementor' ),
					'label_block' => true,
				]
			);
			$this->add_control(
				'guest_label',
				[
					'label' => esc_html__( 'Default Message', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'Guest', 'restaurant-cafe-addon-for-elementor' ),
					'placeholder' => esc_html__( 'Type text here', 'restaurant-cafe-addon-for-elementor' ),
					'label_block' => true,
				]
			);
			$this->add_control(
				'button_text',
				[
					'label' => esc_html__( 'Button Title', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'Book table', 'restaurant-cafe-addon-for-elementor' ),
					'placeholder' => esc_html__( 'Type button text here', 'restaurant-cafe-addon-for-elementor' ),
					'label_block' => true,
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
							'{{WRAPPER}} .narep-op-table-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
							'{{WRAPPER}} .narep-op-table-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$this->add_responsive_control(
					'info_padding',
					[
						'label' => __( 'Info Padding', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px' ],
						'selectors' => [
							'{{WRAPPER}} .narep-op-table-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$this->add_control(
					'section_bg_color',
					[
						'label' => esc_html__( 'Background Color', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .narep-op-table-wrap' => 'background-color: {{VALUE}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'secn_border',
						'label' => esc_html__( 'Border', 'restaurant-cafe-addon-for-elementor' ),
						'selector' => '{{WRAPPER}} .narep-op-table-wrap',
					]
				);
				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'section_box_shadow',
						'label' => esc_html__( 'Box Shadow', 'restaurant-cafe-addon-for-elementor' ),
						'selector' => '{{WRAPPER}} .narep-op-table-wrap',
					]
				);
				$this->add_control(
					'scn_border_radius',
					[
						'label' => __( 'Border Radius', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} .narep-op-table-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$this->end_controls_section();// end: Section

			// Form
				$this->start_controls_section(
					'section_form_style',
					[
						'label' => esc_html__( 'Form', 'restaurant-cafe-addon-for-elementor' ),
						'tab' => Controls_Manager::TAB_STYLE,
					]
				);
				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'label' => esc_html__( 'Label Typography', 'restaurant-cafe-addon-for-elementor' ),
						'name' => 'label_typography',
						'selector' => '{{WRAPPER}} .narep-op-table-form.narep-form label',
					]
				);
				$this->add_control(
					'lable_text_color',
					[
						'label' => __( 'Label Text Color', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .narep-op-table-form.narep-form label' => 'color: {{VALUE}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'name' => 'form_typography',
						'selector' => '{{WRAPPER}} .narep-op-table-form.narep-form input[type="text"],
						{{WRAPPER}} .narep-op-table-form.narep-form input[type="email"],
						{{WRAPPER}} .narep-op-table-form.narep-form input[type="date"],
						{{WRAPPER}} .narep-op-table-form.narep-form input[type="time"],
						{{WRAPPER}} .narep-op-table-form.narep-form input[type="number"],
						{{WRAPPER}} .narep-op-table-form.narep-form textarea,
						{{WRAPPER}} .narep-op-table-form.narep-form select,
						{{WRAPPER}} .narep-op-table-form.narep-form .form-control,
						{{WRAPPER}} .narep-op-table-form.narep-form .nice-select',
					]
				);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'form_border',
						'label' => esc_html__( 'Border', 'restaurant-cafe-addon-for-elementor' ),
						'selector' => '{{WRAPPER}} .narep-op-table-form.narep-form input[type="text"],
						{{WRAPPER}} .narep-op-table-form.narep-form input[type="email"],
						{{WRAPPER}} .narep-op-table-form.narep-form input[type="date"],
						{{WRAPPER}} .narep-op-table-form.narep-form input[type="time"],
						{{WRAPPER}} .narep-op-table-form.narep-form input[type="number"],
						{{WRAPPER}} .narep-op-table-form.narep-form textarea,
						{{WRAPPER}} .narep-op-table-form.narep-form select,
						{{WRAPPER}} .narep-op-table-form.narep-form .form-control,
						{{WRAPPER}} .narep-op-table-form.narep-form .nice-select',
					]
				);
				$this->add_control(
					'placeholder_text_color',
					[
						'label' => __( 'Placeholder Text Color', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .narep-op-table-form.narep-form input:not([type="submit"])::-webkit-input-placeholder' => 'color: {{VALUE}} !important;',
							'{{WRAPPER}} .narep-op-table-form.narep-form input:not([type="submit"])::-moz-placeholder' => 'color: {{VALUE}} !important;',
							'{{WRAPPER}} .narep-op-table-form.narep-form input:not([type="submit"])::-ms-input-placeholder' => 'color: {{VALUE}} !important;',
							'{{WRAPPER}} .narep-op-table-form.narep-form input:not([type="submit"])::-o-placeholder' => 'color: {{VALUE}} !important;',
							'{{WRAPPER}} .narep-op-table-form.narep-form textarea::-webkit-input-placeholder' => 'color: {{VALUE}} !important;',
							'{{WRAPPER}} .narep-op-table-form.narep-form textarea::-moz-placeholder' => 'color: {{VALUE}} !important;',
							'{{WRAPPER}} .narep-op-table-form.narep-form textarea::-ms-input-placeholder' => 'color: {{VALUE}} !important;',
							'{{WRAPPER}} .narep-op-table-form.narep-form textarea::-o-placeholder' => 'color: {{VALUE}} !important;',
						],
					]
				);
				$this->add_control(
					'text_color',
					[
						'label' => __( 'Text Color', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .narep-op-table-form.narep-form input[type="text"],
							{{WRAPPER}} .narep-op-table-form.narep-form input[type="email"],
							{{WRAPPER}} .narep-op-table-form.narep-form input[type="date"],
							{{WRAPPER}} .narep-op-table-form.narep-form input[type="time"],
							{{WRAPPER}} .narep-op-table-form.narep-form input[type="number"],
							{{WRAPPER}} .narep-op-table-form.narep-form textarea,
							{{WRAPPER}} .narep-op-table-form.narep-form select,
							{{WRAPPER}} .narep-op-table-form.narep-form .form-control,
							{{WRAPPER}} .narep-op-table-form.narep-form .nice-select' => 'color: {{VALUE}} !important;',
						],
					]
				);
				$this->add_control(
					'form_bg_color',
					[
						'label' => __( 'Background Color', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .narep-op-table-form.narep-form input[type="text"],
							{{WRAPPER}} .narep-op-table-form.narep-form input[type="email"],
							{{WRAPPER}} .narep-op-table-form.narep-form input[type="date"],
							{{WRAPPER}} .narep-op-table-form.narep-form input[type="time"],
							{{WRAPPER}} .narep-op-table-form.narep-form input[type="number"],
							{{WRAPPER}} .narep-op-table-form.narep-form textarea,
							{{WRAPPER}} .narep-op-table-form.narep-form select,
							{{WRAPPER}} .narep-op-table-form.narep-form .form-control,
							{{WRAPPER}} .narep-op-table-form.narep-form .nice-select' => 'background-color: {{VALUE}} !important;',
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
						'label' => __( 'Title Spacing', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px' ],
						'selectors' => [
							'{{WRAPPER}} .narep-op-table-title h3' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'label' => esc_html__( 'Typography', 'restaurant-cafe-addon-for-elementor' ),
						'name' => 'adn_title_typography',
						'selector' => '{{WRAPPER}} .narep-op-table-title h3',
					]
				);
				$this->add_control(
					'title_color',
					[
						'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .narep-op-table-title h3' => 'color: {{VALUE}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Text_Shadow::get_type(),
					[
						'name' => 'title_shadow',
						'label' => esc_html__( 'Title Shadow', 'restaurant-cafe-addon-for-elementor' ),
						'selector' => '{{WRAPPER}} .narep-op-table-title h3',
					]
				);
				$this->end_controls_section();// end: Section

			// Sub Title
				$this->start_controls_section(
					'section_sub_title_style',
					[
						'label' => esc_html__( 'Sub Title', 'restaurant-cafe-addon-for-elementor' ),
						'tab' => Controls_Manager::TAB_STYLE,
					]
				);
				$this->add_control(
					'sub_title_padding',
					[
						'label' => __( 'Padding', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} .narep-op-table-title h4, {{WRAPPER}} .narep-op-table-food .narep-op-table-title h3 .res-sub-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'label' => esc_html__( 'Typography', 'restaurant-cafe-addon-for-elementor' ),
						'name' => 'sub_title_typography',
						'selector' => '{{WRAPPER}} .narep-op-table-title h4, {{WRAPPER}} .narep-op-table-food .narep-op-table-title h3 .res-sub-title',
					]
				);
				$this->add_control(
					'sub_title_color',
					[
						'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .narep-op-table-title h4, {{WRAPPER}} .narep-op-table-food .narep-op-table-title h3 .res-sub-title' => 'color: {{VALUE}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Text_Shadow::get_type(),
					[
						'name' => 'sub_title_shadow',
						'label' => esc_html__( 'Title Shadow', 'restaurant-cafe-addon-for-elementor' ),
						'selector' => '{{WRAPPER}} .narep-op-table-title h4, {{WRAPPER}} .narep-op-table-food .narep-op-table-title h3 .res-sub-title',
					]
				);
				$this->add_responsive_control(
					'sub_title_left',
					[
						'label' => esc_html__( 'Title Left', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::SLIDER,
						'range' => [
							'px' => [
								'min' => -1000,
								'max' => 1000,
								'step' => 1,
							],
						],
						'size_units' => [ 'px' ],
						'selectors' => [
							'{{WRAPPER}} .narep-op-table-title h4, {{WRAPPER}} .narep-op-table-food .narep-op-table-title h3 .res-sub-title' => 'left: {{SIZE}}{{UNIT}};',
						],
					]
				);
				$this->add_responsive_control(
					'sub_title_top',
					[
						'label' => esc_html__( 'Title Top', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::SLIDER,
						'range' => [
							'px' => [
								'min' => -1000,
								'max' => 1000,
								'step' => 1,
							],
						],
						'size_units' => [ 'px' ],
						'selectors' => [
							'{{WRAPPER}} .narep-op-table-title h4, {{WRAPPER}} .narep-op-table-food .narep-op-table-title h3 .res-sub-title' => 'top: {{SIZE}}{{UNIT}};',
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

		}

		/**
		 * Render App Works widget output on the frontend.
		 * Written in PHP and used to generate the final HTML.
		*/
		protected function render() {
			$settings = $this->get_settings_for_display();
			$section_image = !empty( $settings['section_image']['id'] ) ? $settings['section_image']['id'] : '';
			$image_url = wp_get_attachment_url( $section_image );
			$section_title = !empty( $settings['section_title'] ) ? $settings['section_title'] : '';
			$section_sub_title = !empty( $settings['section_sub_title'] ) ? $settings['section_sub_title'] : '';
			$title_image = !empty( $settings['title_image']['id'] ) ? $settings['title_image']['id'] : '';
			$title_image_url = wp_get_attachment_url( $title_image );

			$date_label = !empty( $settings['date_label'] ) ? $settings['date_label'] : '';
			$time_label = !empty( $settings['time_label'] ) ? $settings['time_label'] : '';
			$guest_label = !empty( $settings['guest_label'] ) ? $settings['guest_label'] : '';
			$ot_date_format = !empty( $settings['ot_date_format'] ) ? $settings['ot_date_format'] : '';
			$metro_id = !empty( $settings['metro_id'] ) ? $settings['metro_id'] : '';
			$region_ids = !empty( $settings['region_ids'] ) ? $settings['region_ids'] : '';

			$date_label = $date_label ? $date_label : esc_html( 'Date', 'restaurant-cafe-addon-for-elementor' );
			$time_label = $time_label ? $time_label : esc_html( 'Time', 'restaurant-cafe-addon-for-elementor' );
			$guest_label = $guest_label ? $guest_label : esc_html( 'Guest', 'restaurant-cafe-addon-for-elementor' );

			$button_text = !empty( $settings['button_text'] ) ? $settings['button_text'] : '';

			$section_title = $section_title ? '<h3>'.$section_title.'</h3>' : '';
			$section_sub_title = $section_sub_title ? '<h4>'.$section_sub_title.'</h4>' : '';
			$title_image = $title_image_url ? '<div class="narep-image"><img src="'.esc_url($title_image_url).'" alt="Icon"></div>' : '';
			$section_image = $image_url ? '<div class="narep-image"><img src="'.esc_url($image_url).'" alt="'.$section_title.'"></div>' : '';

			if ($image_url) {
				$col_cls = 'nich-col-xl-6 nich-col-lg-12';
			} else {
				$col_cls = 'nich-col-xl-12';
			}

			// Turn output buffer on
			ob_start(); ?>
				<div class="narep-op-table-wrap">
					<div class="nich-row nich-align-items-center">
						<?php if ($image_url) { ?><div class="<?php echo esc_attr($col_cls); ?>">
							<?php echo $section_image; ?>
						</div><?php } ?>
						<div class="<?php echo esc_attr($col_cls); ?>">
							<div class="narep-op-table-info">
								<div class="narep-op-table-title">
									<?php echo $section_sub_title.$section_title.$title_image; ?>
								</div>
								<div class="narep-op-table">
									<div class="narep-op-table-form style-one narep-form">
										<form method="GET" action="//www.opentable.com/s/interim?" target="_blank">
							        <div class="nich-row nich-align-items-center">
							          <div class="nich-col-md-5">
							            <div class="input-group">
							            	<label for="optDate"><i class="fa fa-calendar"></i> <?php echo $date_label; ?> </label>
							              <?php
								              if ($ot_date_format) {
								                $today = date($ot_date_format);
								              }
								              else {
								                $today = date("m/d/Y");
								              }
								            ?>
							              <input type="text" id="narep-tbDate" name="optDate" class="narep-datepicker" placeholder="<?php echo esc_attr($today); ?>">
							            </div>
							          </div>
							          <div class="nich-col-md-4">
							            <div class="input-group bootstrap-timepicker timepicker">
							            	<label for="optTime"><i class="fa fa-clock-o"></i> <?php echo $time_label; ?> </label>
							              <input type="text" id="narep-tbTime" name="optTime" class="narep-timepicker" placeholder="7:30 PM">
							            </div>
							          </div>
							          <div class="nich-col-md-3">
							            <div class="input-group">
							            	<label for="covers"><i class="fa fa-users"></i> <?php echo $guest_label; ?> </label>
							              <select class="form-control onl-res-fo-select" name="covers">
							                <option value="1"><?php echo esc_html__( '1', 'restaurant-cafe-addon-for-elementor' ); ?></option>
							                <option value="2"><?php echo esc_html__( '2', 'restaurant-cafe-addon-for-elementor' ); ?></option>
							                <option value="3"><?php echo esc_html__( '3', 'restaurant-cafe-addon-for-elementor' ); ?></option>
							                <option value="4"><?php echo esc_html__( '4', 'restaurant-cafe-addon-for-elementor' ); ?></option>
							                <option value="5"><?php echo esc_html__( '5', 'restaurant-cafe-addon-for-elementor' ); ?></option>
							                <option value="6"><?php echo esc_html__( '6', 'restaurant-cafe-addon-for-elementor' ); ?></option>
							                <option value="7"><?php echo esc_html__( '7', 'restaurant-cafe-addon-for-elementor' ); ?></option>
							                <option value="8"><?php echo esc_html__( '8', 'restaurant-cafe-addon-for-elementor' ); ?></option>
							                <option value="9"><?php echo esc_html__( '9', 'restaurant-cafe-addon-for-elementor' ); ?></option>
							                <option value="10"><?php echo esc_html__( '10', 'restaurant-cafe-addon-for-elementor' ); ?></option>
							                <option value="11"><?php echo esc_html__( '11', 'restaurant-cafe-addon-for-elementor' ); ?></option>
							                <option value="12"><?php echo esc_html__( '12', 'restaurant-cafe-addon-for-elementor' ); ?></option>
							                <option value="13"><?php echo esc_html__( '13', 'restaurant-cafe-addon-for-elementor' ); ?></option>
							                <option value="14"><?php echo esc_html__( '14', 'restaurant-cafe-addon-for-elementor' ); ?></option>
							                <option value="15"><?php echo esc_html__( '15', 'restaurant-cafe-addon-for-elementor' ); ?></option>
							                <option value="16"><?php echo esc_html__( '16', 'restaurant-cafe-addon-for-elementor' ); ?></option>
							                <option value="17"><?php echo esc_html__( '17', 'restaurant-cafe-addon-for-elementor' ); ?></option>
							                <option value="18"><?php echo esc_html__( '18', 'restaurant-cafe-addon-for-elementor' ); ?></option>
							                <option value="19"><?php echo esc_html__( '19', 'restaurant-cafe-addon-for-elementor' ); ?></option>
							                <option value="20"><?php echo esc_html__( '20', 'restaurant-cafe-addon-for-elementor' ); ?></option>
							              </select>
							            </div>
							          </div>
							          <div class="nich-col-md-12">
							        		<button class="narep-btn" type="submit"><?php echo esc_attr( $button_text ); ?></button>
							        	</div>
							        </div>
							        <?php
							        $metro_id = $metro_id ? $metro_id : 3401;
							        $region_ids = $region_ids ? $region_ids : 9013;
							        ?>
							        <input type="hidden" id="narep-tbDateTime" name="dateTime">
							        <input type="hidden" name="metroId" class="RestaurantID" value="<?php echo esc_attr( $metro_id ); ?>">
							        <input type="hidden" name="regionIds" class="rid" value="<?php echo esc_attr( $region_ids ); ?>">
							        <input type="hidden" name="enableSimpleCuisines" class="GeoID" value="true">
							        <input type="hidden" name="pageType" class="txtDateFormat" value="0">
							      </form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php
			// Return outbut buffer
			echo ob_get_clean();

		}

	}
	Plugin::instance()->widgets_manager->register_widget_type( new Restaurant_Elementor_Addon_Unique_OpenTable() );
} // is_free

} // enable & disable
