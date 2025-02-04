<?php
/*
 * Elementor Restaurant & Cafe Addon for Elementor Pro Food Item Widget
 * Author & Copyright: NicheAddon
*/

namespace Elementor;

if (!isset(get_option( 'rcafe_uw_settings' )['nbeds_food_item'])) { // enable & disable

	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	class Restaurant_Elementor_Addon_Unique_FoodItem extends Widget_Base{

		/**
		 * Retrieve the widget name.
		*/
		public function get_name(){
			return 'narestaurant_unique_food_item';
		}

		/**
		 * Retrieve the widget title.
		*/
		public function get_title(){
			return esc_html__( 'Food Item', 'restaurant-cafe-addon-for-elementor' );
		}

		/**
		 * Retrieve the widget icon.
		*/
		public function get_icon() {
			return 'eicon-basket-solid';
		}

		/**
		 * Retrieve the list of categories the widget belongs to.
		*/
		public function get_categories() {
			return ['narestaurant-unique-category'];
		}

		/**
		 * Register Restaurant & Cafe Addon for Elementor Pro Food Item widget controls.
		 * Adds different input fields to allow the user to change and customize the widget settings.
		*/
		protected function _register_controls(){

			$this->start_controls_section(
				'section_food_item',
				[
					'label' => __( 'Food Item Options', 'restaurant-cafe-addon-for-elementor' ),
				]
			);
			$this->add_control(
				'food_style',
				[
					'label' => __( 'Food Item Style', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'one' 			=> esc_html__( 'Style One (Slider)', 'restaurant-cafe-addon-for-elementor' ),
						'two' 			=> esc_html__( 'Style Two (Static)', 'restaurant-cafe-addon-for-elementor' ),
					],
					'default' => 'one',
				]
			);
			$this->add_control(
				'food_col',
				[
					'label' => __( 'Food Item Column', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'one' 			=> esc_html__( 'One', 'restaurant-cafe-addon-for-elementor' ),
						'two' 			=> esc_html__( 'Two', 'restaurant-cafe-addon-for-elementor' ),
						'three' 			=> esc_html__( 'Three', 'restaurant-cafe-addon-for-elementor' ),
						'four' 			=> esc_html__( 'Four', 'restaurant-cafe-addon-for-elementor' ),
					],
					'default' => 'three',
				]
			);
			$repeater = new Repeater();
			$repeater->add_control(
				'item_style',
				[
					'label' => __( 'Food Item Style', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'one' 			=> esc_html__( 'Style One', 'restaurant-cafe-addon-for-elementor' ),
						'two' 			=> esc_html__( 'Style Two', 'restaurant-cafe-addon-for-elementor' ),
					],
					'default' => 'one',
				]
			);
			$repeater->add_control(
				'food_item_image',
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
				'non_veg',
				[
					'label' => esc_html__( 'Non-Veg?', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Yes', 'restaurant-cafe-addon-for-elementor' ),
					'label_off' => esc_html__( 'No', 'restaurant-cafe-addon-for-elementor' ),
					'return_value' => 'true',
					'condition' => [
						'item_style' => 'two',
					],
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
				'list_text',
				[
					'label' => esc_html__( 'Title', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'Beef Soup', 'restaurant-cafe-addon-for-elementor' ),
					'placeholder' => esc_html__( 'Type title text here', 'restaurant-cafe-addon-for-elementor' ),
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'text_link',
				[
					'label' => esc_html__( 'Title Link', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::URL,
					'placeholder' => 'https://your-link.com',
					'default' => [
						'url' => '',
					],
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'list_label',
				[
					'label' => esc_html__( 'Label', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'Type label text here', 'restaurant-cafe-addon-for-elementor' ),
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'label_bg',
				[
					'label' => esc_html__( 'Background Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
				]
			);
			$repeater->add_control(
				'list_price',
				[
					'label' => esc_html__( 'Price', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( '$11', 'restaurant-cafe-addon-for-elementor' ),
					'placeholder' => esc_html__( 'Type price text here', 'restaurant-cafe-addon-for-elementor' ),
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'list_content',
				[
					'label' => esc_html__( 'List Content', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::TEXTAREA,
					'default' => esc_html__( 'Straight-from-the-wok spicy supper with rice, prawns and bacon.', 'restaurant-cafe-addon-for-elementor' ),
					'placeholder' => esc_html__( 'Type title text here', 'restaurant-cafe-addon-for-elementor' ),
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'btn_text',
				[
					'label' => esc_html__( 'Button Text', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'Add To Cart', 'restaurant-cafe-addon-for-elementor' ),
					'placeholder' => esc_html__( 'Type title text here', 'restaurant-cafe-addon-for-elementor' ),
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'btn_icon',
				[
					'label' => esc_html__( 'Button Icon', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::ICON,
					'options' => NAREP_Controls_Helper_Output::get_include_icons(),
					'frontend_available' => true,
					'default' => 'fa fa-shopping-cart',
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
			$repeater->add_control(
				'rating',
				[
					'label' => esc_html__( 'Customer Rating', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'1' => esc_html__( '1', 'restaurant-cafe-addon-for-elementor' ),
						'2' => esc_html__( '2', 'restaurant-cafe-addon-for-elementor' ),
						'3' => esc_html__( '3', 'restaurant-cafe-addon-for-elementor' ),
						'4' => esc_html__( '4', 'restaurant-cafe-addon-for-elementor' ),
						'5' => esc_html__( '5', 'restaurant-cafe-addon-for-elementor' ),
					],
					'default' => '3',
					'description' => esc_html__( 'Select your rating.', 'restaurant-cafe-addon-for-elementor' ),
					'condition' => [
						'item_style' => 'two',
					],
				]
			);
			$this->add_control(
				'listItems_groups',
				[
					'label' => esc_html__( 'List', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::REPEATER,
					'default' => [
						[
							'list_text' => esc_html__( 'Beef Soup', 'restaurant-cafe-addon-for-elementor' ),
						],
					],
					'fields' => $repeater->get_controls(),
					'title_field' => '{{{ list_text }}}',
					'prevent_empty' => false,
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
				$this->add_responsive_control(
					'carousel_items',
					[
						'label' => esc_html__( 'How many items?', 'restaurant-elementor-addon' ),
						'type' => Controls_Manager::NUMBER,
						'min' => 1,
						'max' => 100,
						'step' => 1,
						'default' => 3,
						'description' => esc_html__( 'Enter the number of items to show.', 'restaurant-elementor-addon' ),
					]
				);
				$this->add_control(
					'carousel_margin',
					[
						'label' => __( 'Space Between Items', 'restaurant-elementor-addon' ),
						'type' => Controls_Manager::SLIDER,
						'default' => [
							'size' =>30,
						],
						'label_block' => true,
					]
				);
				$this->add_control(
					'carousel_autoplay_timeout',
					[
						'label' => __( 'Auto Play Timeout', 'restaurant-elementor-addon' ),
						'type' => Controls_Manager::NUMBER,
						'default' => 5000,
					]
				);
				$this->add_control(
					'carousel_loop',
					[
						'label' => esc_html__( 'Need Loop?', 'restaurant-elementor-addon' ),
						'type' => Controls_Manager::SWITCHER,
						'label_on' => esc_html__( 'Yes', 'restaurant-elementor-addon' ),
						'label_off' => esc_html__( 'No', 'restaurant-elementor-addon' ),
						'description' => esc_html__( 'Continuously moving carousel, if enabled.', 'restaurant-elementor-addon' ),
						'return_value' => 'true',
						'default' => 'true',
					]
				);
				$this->add_control(
					'carousel_dots',
					[
						'label' => esc_html__( 'Need Dots?', 'restaurant-elementor-addon' ),
						'type' => Controls_Manager::SWITCHER,
						'label_on' => esc_html__( 'Yes', 'restaurant-elementor-addon' ),
						'label_off' => esc_html__( 'No', 'restaurant-elementor-addon' ),
						'description' => esc_html__( 'If you want Carousel Dots, enable it.', 'restaurant-elementor-addon' ),
						'return_value' => 'true',
						'default' => 'true',
					]
				);
				$this->add_control(
					'carousel_nav',
					[
						'label' => esc_html__( 'Need Navigation?', 'restaurant-elementor-addon' ),
						'type' => Controls_Manager::SWITCHER,
						'label_on' => esc_html__( 'Yes', 'restaurant-elementor-addon' ),
						'label_off' => esc_html__( 'No', 'restaurant-elementor-addon' ),
						'description' => esc_html__( 'If you want Carousel Navigation, enable it.', 'restaurant-elementor-addon' ),
						'return_value' => 'true',
						'default' => 'true',
					]
				);
				$this->add_control(
					'carousel_autoplay',
					[
						'label' => esc_html__( 'Need Autoplay?', 'restaurant-elementor-addon' ),
						'type' => Controls_Manager::SWITCHER,
						'label_on' => esc_html__( 'Yes', 'restaurant-elementor-addon' ),
						'label_off' => esc_html__( 'No', 'restaurant-elementor-addon' ),
						'description' => esc_html__( 'If you want to start Carousel automatically, enable it.', 'restaurant-elementor-addon' ),
						'return_value' => 'true',
						'default' => 'true',
					]
				);
				$this->add_control(
					'carousel_animate_out',
					[
						'label' => esc_html__( 'Animate Out', 'restaurant-elementor-addon' ),
						'type' => Controls_Manager::SWITCHER,
						'label_on' => esc_html__( 'Yes', 'restaurant-elementor-addon' ),
						'label_off' => esc_html__( 'No', 'restaurant-elementor-addon' ),
						'description' => esc_html__( 'CSS3 animation out.', 'restaurant-elementor-addon' ),
						'return_value' => 'true',
					]
				);
				$this->add_control(
					'carousel_mousedrag',
					[
						'label' => esc_html__( 'Need Mouse Drag?', 'restaurant-elementor-addon' ),
						'type' => Controls_Manager::SWITCHER,
						'label_on' => esc_html__( 'Yes', 'restaurant-elementor-addon' ),
						'label_off' => esc_html__( 'No', 'restaurant-elementor-addon' ),
						'description' => esc_html__( 'If you want to disable Mouse Drag, check it.', 'restaurant-elementor-addon' ),
						'return_value' => 'true',
					]
				);
				$this->add_control(
					'carousel_autowidth',
					[
						'label' => esc_html__( 'Need Auto Width?', 'restaurant-elementor-addon' ),
						'type' => Controls_Manager::SWITCHER,
						'label_on' => esc_html__( 'Yes', 'restaurant-elementor-addon' ),
						'label_off' => esc_html__( 'No', 'restaurant-elementor-addon' ),
						'description' => esc_html__( 'Adjust Auto Width automatically for each carousel items.', 'restaurant-elementor-addon' ),
						'return_value' => 'true',
					]
				);
				$this->add_control(
					'carousel_autoheight',
					[
						'label' => esc_html__( 'Need Auto Height?', 'restaurant-elementor-addon' ),
						'type' => Controls_Manager::SWITCHER,
						'label_on' => esc_html__( 'Yes', 'restaurant-elementor-addon' ),
						'label_off' => esc_html__( 'No', 'restaurant-elementor-addon' ),
						'description' => esc_html__( 'Adjust Auto Height automatically for each carousel items.', 'restaurant-elementor-addon' ),
						'return_value' => 'true',
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
							'{{WRAPPER}} .narep-food-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
							'{{WRAPPER}} .narep-food-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$this->add_control(
					'section_bg_color',
					[
						'label' => esc_html__( 'Background Color', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .narep-food-item' => 'background-color: {{VALUE}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'secn_border',
						'label' => esc_html__( 'Border', 'restaurant-cafe-addon-for-elementor' ),
						'selector' => '{{WRAPPER}} .narep-food-item',
					]
				);
				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'section_box_shadow',
						'label' => esc_html__( 'Box Shadow', 'restaurant-cafe-addon-for-elementor' ),
						'selector' => '{{WRAPPER}} .narep-food-item',
					]
				);
				$this->add_control(
					'scn_border_radius',
					[
						'label' => __( 'Border Radius', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} .narep-food-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
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
					'image_border_radius',
					[
						'label' => __( 'Border Radius', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} .narep-food-item .narep-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'image_border',
						'label' => esc_html__( 'Border', 'restaurant-cafe-addon-for-elementor' ),
						'selector' => '{{WRAPPER}} .narep-food-item .narep-image',
					]
				);
				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'image_box_shadow',
						'label' => esc_html__( 'Image Box Shadow', 'restaurant-cafe-addon-for-elementor' ),
						'selector' => '{{WRAPPER}} .narep-food-item .narep-image',
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
					'title_margin',
					[
						'label' => __( 'Title Spacing', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px' ],
						'selectors' => [
							'{{WRAPPER}} .narep-food-item-info h4' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'label' => esc_html__( 'Typography', 'restaurant-cafe-addon-for-elementor' ),
						'name' => 'sastool_title_typography',
						'selector' => '{{WRAPPER}} .narep-food-item-info h4',
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
								'{{WRAPPER}} .narep-food-item-info h4, {{WRAPPER}} .narep-food-item-info h4 a' => 'color: {{VALUE}};',
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
								'{{WRAPPER}} .narep-food-item-info h4 a:hover' => 'color: {{VALUE}};',
							],
						]
					);
					$this->end_controls_tab();  // end:Hover tab
				$this->end_controls_tabs(); // end tabs
				$this->end_controls_section();// end: Section

			// Price
				$this->start_controls_section(
					'section_price_style',
					[
						'label' => esc_html__( 'Price', 'restaurant-cafe-addon-for-elementor' ),
						'tab' => Controls_Manager::TAB_STYLE,
					]
				);
				$this->add_responsive_control(
					'price_padding',
					[
						'label' => __( 'Padding', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px' ],
						'selectors' => [
							'{{WRAPPER}} h5.item-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$this->add_control(
					'price_border_radius',
					[
						'label' => __( 'Border Radius', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} h5.item-price' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$this->add_control(
					'price_bg_color',
					[
						'label' => esc_html__( 'Background Color', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} h5.item-price' => 'background-color: {{VALUE}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'price_border',
						'label' => esc_html__( 'Price Border', 'restaurant-cafe-addon-for-elementor' ),
						'selector' => '{{WRAPPER}} h5.item-price',
					]
				);
				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'label' => esc_html__( 'Typography', 'restaurant-cafe-addon-for-elementor' ),
						'name' => 'sastool_price_typography',
						'selector' => '{{WRAPPER}} h5.item-price',
					]
				);
				$this->add_control(
					'price_color',
					[
						'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} h5.item-price' => 'color: {{VALUE}};',
						],
					]
				);
				$this->end_controls_section();// end: Section

			// Label
				$this->start_controls_section(
					'section_label_style',
					[
						'label' => esc_html__( 'Label', 'restaurant-cafe-addon-for-elementor' ),
						'tab' => Controls_Manager::TAB_STYLE,
					]
				);
				$this->add_responsive_control(
					'label_padding',
					[
						'label' => __( 'Padding', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px' ],
						'selectors' => [
							'{{WRAPPER}} .item-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'label' => esc_html__( 'Typography', 'restaurant-cafe-addon-for-elementor' ),
						'name' => 'label_typography',
						'selector' => '{{WRAPPER}} .item-label',
					]
				);
				$this->add_control(
					'label_color',
					[
						'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .item-label span' => 'color: {{VALUE}};',
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
							'{{WRAPPER}} .narep-food-item-info p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'label' => esc_html__( 'Typography', 'restaurant-cafe-addon-for-elementor' ),
						'name' => 'sastool_content_typography',
						'selector' => '{{WRAPPER}} .narep-food-item-info p',
					]
				);
				$this->add_control(
					'content_color',
					[
						'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .narep-food-item-info p' => 'color: {{VALUE}};',
						],
					]
				);
				$this->end_controls_section();// end: Section

			// Star Rating
				$this->start_controls_section(
					'section_star_style',
					[
						'label' => esc_html__( 'Star Rating', 'restaurant-cafe-addon-for-elementor' ),
						'tab' => Controls_Manager::TAB_STYLE,
					]
				);
				$this->add_responsive_control(
					'star_padding',
					[
						'label' => __( 'Star Rating Padding', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} .narep-customer-rating' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$this->add_control(
					'star_margin',
					[
						'label' => __( 'Star Margin', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} .narep-customer-rating i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$this->start_controls_tabs( 'testimonials_star_style' );
					$this->start_controls_tab(
						'star_normal',
						[
							'label' => esc_html__( 'Normal', 'restaurant-cafe-addon-for-elementor' ),
						]
					);
					$this->add_control(
						'star_color',
						[
							'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .narep-customer-rating .fa-star-o' => 'color: {{VALUE}};',
							],
						]
					);
					$this->end_controls_tab();  // end:Normal tab
					$this->start_controls_tab(
						'star_hover',
						[
							'label' => esc_html__( 'Active', 'restaurant-cafe-addon-for-elementor' ),
						]
					);
					$this->add_control(
						'star_hov_color',
						[
							'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .narep-customer-rating' => 'color: {{VALUE}};',
							],
						]
					);
					$this->end_controls_tab();  // end:Hover tab
				$this->end_controls_tabs(); // end tabs
				$this->end_controls_section();// end: Section

			// Link
				$this->start_controls_section(
					'section_link_style',
					[
						'label' => esc_html__( 'Link', 'restaurant-cafe-addon-for-elementor' ),
						'tab' => Controls_Manager::TAB_STYLE,
					]
				);
				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'label' => esc_html__( 'Typography', 'restaurant-cafe-addon-for-elementor' ),
						'name' => 'link_typography',
						'selector' => '{{WRAPPER}} .narep-link',
					]
				);
				$this->start_controls_tabs( 'link_style' );
					$this->start_controls_tab(
						'link_normal',
						[
							'label' => esc_html__( 'Normal', 'restaurant-cafe-addon-for-elementor' ),
						]
					);
					$this->add_control(
						'link_color',
						[
							'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .narep-link' => 'color: {{VALUE}};',
							],
						]
					);
					$this->end_controls_tab();  // end:Normal tab
					$this->start_controls_tab(
						'link_hover',
						[
							'label' => esc_html__( 'Hover', 'restaurant-cafe-addon-for-elementor' ),
						]
					);
					$this->add_control(
						'link_hover_color',
						[
							'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .narep-link:hover' => 'color: {{VALUE}};',
							],
						]
					);
					$this->add_control(
						'link_bg_hover_color',
						[
							'label' => esc_html__( 'Line Color', 'restaurant-cafe-addon-for-elementor' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .narep-link span:after' => 'background-color: {{VALUE}};',
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
			$food_style = !empty( $settings['food_style'] ) ? $settings['food_style'] : '';
			$food_col = !empty( $settings['food_col'] ) ? $settings['food_col'] : '';
			$listItems_groups = !empty( $settings['listItems_groups'] ) ? $settings['listItems_groups'] : '';

			// Carousel
				$carousel_items = !empty( $settings['carousel_items'] ) ? $settings['carousel_items'] : '';
				$carousel_items_tablet = !empty( $settings['carousel_items_tablet'] ) ? $settings['carousel_items_tablet'] : '';
				$carousel_items_mobile = !empty( $settings['carousel_items_mobile'] ) ? $settings['carousel_items_mobile'] : '';
				$carousel_margin = !empty( $settings['carousel_margin']['size'] ) ? $settings['carousel_margin']['size'] : '';
				$carousel_autoplay_timeout = !empty( $settings['carousel_autoplay_timeout'] ) ? $settings['carousel_autoplay_timeout'] : '';

				$carousel_loop  = ( isset( $settings['carousel_loop'] ) && ( 'true' == $settings['carousel_loop'] ) ) ? true : false;
				$carousel_dots  = ( isset( $settings['carousel_dots'] ) && ( 'true' == $settings['carousel_dots'] ) ) ? true : false;
				$carousel_nav  = ( isset( $settings['carousel_nav'] ) && ( 'true' == $settings['carousel_nav'] ) ) ? true : false;
				$carousel_autoplay  = ( isset( $settings['carousel_autoplay'] ) && ( 'true' == $settings['carousel_autoplay'] ) ) ? true : false;
				$carousel_animate_out  = ( isset( $settings['carousel_animate_out'] ) && ( 'true' == $settings['carousel_animate_out'] ) ) ? true : false;
				$carousel_mousedrag  = ( isset( $settings['carousel_mousedrag'] ) && ( 'true' == $settings['carousel_mousedrag'] ) ) ? $settings['carousel_mousedrag'] : 'false';
				$carousel_autowidth  = ( isset( $settings['carousel_autowidth'] ) && ( 'true' == $settings['carousel_autowidth'] ) ) ? true : false;
				$carousel_autoheight  = ( isset( $settings['carousel_autoheight'] ) && ( 'true' == $settings['carousel_autoheight'] ) ) ? true : false;
				
				$carousel_items = $carousel_items ? $carousel_items : "1";
				$carousel_tablet = $carousel_items_tablet ? $carousel_items_tablet : "1";
				$carousel_mobile = $carousel_items_mobile ? $carousel_items_mobile : "1";
				$carousel_margin = $carousel_margin ? $carousel_margin : "0";
				$carousel_autoplay_timeout = $carousel_autoplay_timeout ? $carousel_autoplay_timeout : '';
				$carousel_loop = ('true' == $carousel_loop) ? "true" : "false";
				$carousel_dots = ('true' == $carousel_dots) ? "true" : "false";
				$carousel_nav = ('true' == $carousel_nav) ? "true" : "false";
				$carousel_autoplay = ('true' == $carousel_autoplay) ? "true" : "false";
				$carousel_animate_out = ('true' == $carousel_animate_out) ? "true" : "false";
				$carousel_mousedrag = ('true' == $carousel_mousedrag) ? "true" : "false";
				$carousel_autowidth = ('true' == $carousel_autowidth) ? "true" : "false";
				$carousel_autoheight = ('true' == $carousel_autoheight) ? "true" : "false";				

			if ($food_style === 'two') {
				$style_class = ' style-two';
				if ($food_col === 'two') {
					$col_class = 'nich-col-lg-6';
				} elseif ($food_col === 'three') {
					$col_class = 'nich-col-lg-4 nich-col-md-6';
				} elseif ($food_col === 'four') {
					$col_class = 'nich-col-lg-3 nich-col-md-6';
				} else {
					$col_class = 'nich-col-lg-12';
				}
			} else {
				$style_class = '';
				$col_class = 'item';
			}

			$output = '<div class="narep-food-item-wrap'.esc_attr( $style_class ).'">';
			if ($food_style === 'two') {
				$output .= '<div class="nich-row">';
			} else {
				$output .= '<div class="owl-carousel" data-items="'. esc_attr( $carousel_items ) .'" data-items-tablet="'. esc_attr( $carousel_items_tablet ) .'" data-items-mobile-landscape="'. esc_attr( $carousel_mobile ) .'" data-items-mobile-portrait="'. esc_attr( $carousel_mobile ) .'" data-margin="'. esc_attr( $carousel_margin ) .'" data-autoplay-timeout="'. esc_attr( $carousel_autoplay_timeout ) .'" data-loop="'. esc_attr( $carousel_loop ) .'" data-dots="'. esc_attr( $carousel_dots ) .'" data-nav="'. esc_attr( $carousel_nav ) .'" data-autoplay="'. esc_attr( $carousel_autoplay ) .'" data-animateout="'. esc_attr( $carousel_animate_out ) .'" data-mouse-drag="'. esc_attr( $carousel_mousedrag ) .'" data-auto-width="'. esc_attr( $carousel_autowidth ) .'" data-auto-height="'. esc_attr( $carousel_autoheight ) .'"';
			}
									if ( is_array( $listItems_groups ) && !empty( $listItems_groups ) ) {
									  foreach ( $listItems_groups as $each_list ) {
										$item_style = !empty( $each_list['item_style'] ) ? $each_list['item_style'] : '';
									  	$food_item_image = !empty( $each_list['food_item_image']['id'] ) ? $each_list['food_item_image']['id'] : '';
										$image_url = wp_get_attachment_url( $food_item_image );
									  	$non_veg = !empty( $each_list['non_veg'] ) ? $each_list['non_veg'] : '';
									  	$list_text = !empty( $each_list['list_text'] ) ? $each_list['list_text'] : '';
									  	$text_link = !empty( $each_list['text_link']['url'] ) ? $each_list['text_link']['url'] : '';
										$text_link_external = !empty( $each_list['text_link']['is_external'] ) ? 'target="_blank"' : '';
										$text_link_nofollow = !empty( $each_list['text_link']['nofollow'] ) ? 'rel="nofollow"' : '';
										$text_link_attr = !empty( $text_link ) ?  $text_link_external.' '.$text_link_nofollow : '';
									  	$list_label = !empty( $each_list['list_label'] ) ? $each_list['list_label'] : '';
									  	$list_price = !empty( $each_list['list_price'] ) ? $each_list['list_price'] : '';
									  	$list_content = !empty( $each_list['list_content'] ) ? $each_list['list_content'] : '';
									  	$link_style = !empty( $each_list['link_style'] ) ? $each_list['link_style'] : '';
										$image_link = !empty( $each_list['image_link']['url'] ) ? $each_list['image_link']['url'] : '';
										$image_link_external = !empty( $each_list['image_link']['is_external'] ) ? 'target="_blank"' : '';
										$image_link_nofollow = !empty( $each_list['image_link']['nofollow'] ) ? 'rel="nofollow"' : '';
										$image_link_attr = !empty( $image_link ) ?  $image_link_external.' '.$image_link_nofollow : '';

									  	$btn_text = !empty( $each_list['btn_text'] ) ? $each_list['btn_text'] : '';
									  	$btn_icon = !empty( $each_list['btn_icon'] ) ? $each_list['btn_icon'] : '';
									  	$btn_link = !empty( $each_list['btn_link']['url'] ) ? $each_list['btn_link']['url'] : '';
										$btn_link_external = !empty( $each_list['btn_link']['is_external'] ) ? 'target="_blank"' : '';
										$btn_link_nofollow = !empty( $each_list['btn_link']['nofollow'] ) ? 'rel="nofollow"' : '';
										$btn_link_attr = !empty( $btn_link ) ?  $btn_link_external.' '.$btn_link_nofollow : '';
									  	$label_bg = !empty( $each_list['label_bg'] ) ? $each_list['label_bg'] : '';
									  	$rating = !empty( $each_list['rating'] ) ? $each_list['rating'] : '';

									  	$label_bg = $label_bg ? ' style="background-color: '.$label_bg.';color: '.$label_bg.';"' : '';

											if ($item_style === 'two') {
												if ($non_veg) {
													$vnv_cls = ' non-veg';
												} else {
													$vnv_cls = ' veg';
												}
												$style_cls = ' food-item-two';
											} else {
												$vnv_cls = '';
												$style_cls = '';
											}
											if ($food_item_image) {
												$img_cls = '';
											} else {
												$img_cls = ' no-img';
											}

									  	$list_title_link = $text_link ? '<a href="'.esc_url($text_link).'" '.$text_link_attr.'>'. esc_html($list_text) .'</a>' : esc_html($list_text);
											$list_label = !empty( $list_label ) ? '<h4 class="item-label"'.$label_bg.'><span>'.$list_label.'</span></h4>' : '';
											$list_price = !empty( $list_price ) ? '<h5 class="item-price">'.$list_price.'</h5>' : '';
											$list_title = !empty( $list_text ) ? '<h3>'.$list_title_link.'</h3>' : '';
											$list_content = !empty( $list_content ) ? '<p>'.$list_content.'</p>' : '';

											if ($link_style === 'two') {
												$popup_class = '';
												$food_image = $image_link ? '<a href="'.esc_url($image_link).'" '.$image_link_attr.'><img src="'.esc_url($image_url).'" alt="'.esc_attr($list_text).'"></a>' : '<img src="'.esc_url($image_url).'" alt="'.esc_attr($list_text).'">';
											} else {
												$popup_class = ' narep-popup';
												$food_image = '<a href="'. esc_url($image_url) .'"><img src="'.esc_url($image_url).'" alt="'.esc_attr($list_text).'"></a>';
											}
											$food_item_image = $image_url ? '<div class="narep-image'.$popup_class.'">'.$food_image.'</div>' : '';
											$btn_icon = $btn_icon ? '<i class="'.esc_attr($btn_icon).'"></i> ' : '';
											if ($item_style === 'two') {
												$button = $btn_link ? '<div class="narep-btn-wrap"><a href="'.esc_url($btn_link).'" '.$btn_link_attr.' class="narep-btn black-btn">'. esc_html($btn_text) .'</a></div>' : '';
											} else {
												$button = $btn_link ? '<div class="narep-link-wrap"><a href="'.esc_url($btn_link).'" '.$btn_link_attr.' class="narep-link">'.$btn_icon.'<span>'. esc_html($btn_text) .'</span></a></div>' : '';
											}

	                  	$output .= '<div class="'.$col_class.'"><div class="narep-food-item zoom-image'.$img_cls.$style_cls.$vnv_cls.'">
											              '.$list_label.$food_item_image.'<div class="narep-food-item-info">'.$list_title.$list_price.$list_content.$button;
																		if ($item_style === 'two') {
												              $output .= '<div class="narep-customer-rating">';
											                	for( $i=1; $i<= $rating; $i++) {
															            $output .= '<i class="fa fa-star"></i>';
															          }
															          for( $i=5; $i > $rating; $i--) {
															            $output .= '<i class="fa fa-star-o"></i>';
															          }
											                $output .= '</div>';
										              	}
							                			$output .= '</div>
											            </div></div>';
		                }
		              }
	    $output .= '</div></div>';
			echo $output;

		if ( Plugin::$instance->editor->is_edit_mode() ) : ?>
		<script type="text/javascript">
	    jQuery(document).ready(function($) {
				$('.owl-carousel').each( function() {
			    var $carousel = $(this);
			    var $items = ($carousel.data('items') !== undefined) ? $carousel.data('items') : 1;
			    var $items_tablet = ($carousel.data('items-tablet') !== undefined) ? $carousel.data('items-tablet') : 1;
			    var $items_mobile_landscape = ($carousel.data('items-mobile-landscape') !== undefined) ? $carousel.data('items-mobile-landscape') : 1;
			    var $items_mobile_portrait = ($carousel.data('items-mobile-portrait') !== undefined) ? $carousel.data('items-mobile-portrait') : 1;
			    $carousel.owlCarousel ({
			      loop : ($carousel.data('loop') !== undefined) ? $carousel.data('loop') : true,
			      items : $carousel.data('items'),
			      margin : ($carousel.data('margin') !== undefined) ? $carousel.data('margin') : 0,
			      dots : ($carousel.data('dots') !== undefined) ? $carousel.data('dots') : true,
			      nav : ($carousel.data('nav') !== undefined) ? $carousel.data('nav') : false,
			      navText : ["<div class='slider-no-current'><span class='current-no'></span><span class='total-no'></span></div><span class='current-monials'></span>", "<div class='slider-no-next'></div><span class='next-monials'></span>"],
			      autoplay : ($carousel.data('autoplay') !== undefined) ? $carousel.data('autoplay') : false,
			      autoplayTimeout : ($carousel.data('autoplay-timeout') !== undefined) ? $carousel.data('autoplay-timeout') : 5000,
			      animateIn : ($carousel.data('animatein') !== undefined) ? $carousel.data('animatein') : false,
			      animateOut : ($carousel.data('animateout') !== undefined) ? $carousel.data('animateout') : false,
			      mouseDrag : ($carousel.data('mouse-drag') !== undefined) ? $carousel.data('mouse-drag') : true,
			      autoWidth : ($carousel.data('auto-width') !== undefined) ? $carousel.data('auto-width') : false,
			      autoHeight : ($carousel.data('auto-height') !== undefined) ? $carousel.data('auto-height') : false,
			      center : ($carousel.data('center') !== undefined) ? $carousel.data('center') : false,
			      responsiveClass: true,
			      dotsEachNumber: true,
			      smartSpeed: 600,
			      autoplayHoverPause: true,
			      responsive : {
			        0 : {
			          items : $items_mobile_portrait,
			        },
			        480 : {
			          items : $items_mobile_landscape,
			        },
			        768 : {
			          items : $items_tablet,
			        },
			        992 : {
			          items : $items,
			        }
			      }
			    });
			    var totLength = $('.owl-dot', $carousel).length;
			    $('.total-no', $carousel).html(totLength);
			    $('.current-no', $carousel).html(totLength);
			    $carousel.owlCarousel();
			    $('.current-no', $carousel).html(1);
			    $carousel.on('changed.owl.carousel', function(event) {
			      var total_items = event.page.count;
			      var currentNum = event.page.index + 1;
			      $('.total-no', $carousel ).html(total_items);
			      $('.current-no', $carousel).html(currentNum);
			    });
			  });
		  });
		</script>
		<?php endif;

		}

	}
	Plugin::instance()->widgets_manager->register_widget_type( new Restaurant_Elementor_Addon_Unique_FoodItem() );

} // enable & disable
