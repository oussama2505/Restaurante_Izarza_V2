<?php
/*
 * Elementor Restaurant & Cafe Addon for Elementor Food Menu Widget
 * Author & Copyright: NicheAddon
*/
namespace Elementor;

if (!isset(get_option( 'rcafe_uw_settings' )['nbeds_food_menu'])) { // enable & disable

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Restaurant_Elementor_Addon_Unique_FoodMenu extends Widget_Base{

	/**
	 * Retrieve the widget name.
	*/
	public function get_name(){
		return 'narestaurant_unique_food_menu';
	}

	/**
	 * Retrieve the widget title.
	*/
	public function get_title(){
		return esc_html__( 'Food Menu', 'restaurant-cafe-addon-for-elementor' );
	}

	/**
	 * Retrieve the widget icon.
	*/
	public function get_icon() {
		return 'eicon-menu-card';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	*/
	public function get_categories() {
		return ['narestaurant-unique-category'];
	}

	/**
	 * Register Restaurant & Cafe Addon for Elementor Food Menu widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	*/
	protected function _register_controls(){

		$this->start_controls_section(
			'section_food_menu',
			[
				'label' => __( 'Food Menu Options', 'restaurant-cafe-addon-for-elementor' ),
			]
		);
		$this->add_control(
			'menu_style',
			[
				'label' => __( 'Menu Style', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'one' 			=> esc_html__( 'Style One (List)', 'restaurant-cafe-addon-for-elementor' ),
					'two' 			=> esc_html__( 'Style Two (Grid)', 'restaurant-cafe-addon-for-elementor' ),
					'three' 			=> esc_html__( 'Style Three (List)', 'restaurant-cafe-addon-for-elementor' ),
					'four' 			=> esc_html__( 'Style Four (List)', 'restaurant-cafe-addon-for-elementor' ),
				],
				'default' => 'one',
			]
		);
		$repeater = new Repeater();
		$repeater->add_control(
			'need_indicator',
			[
				'label' => esc_html__( 'Need Indicator?', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'restaurant-cafe-addon-for-elementor' ),
				'label_off' => esc_html__( 'No', 'restaurant-cafe-addon-for-elementor' ),
				'return_value' => 'true',
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
					'need_indicator' => 'true',
				],
			]
		);
		$repeater->add_control(
			'food_menu_image',
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
				'default' => esc_html__( 'Offer seamless patient experience - from booking home collections to receiving reports and payments.', 'restaurant-cafe-addon-for-elementor' ),
				'placeholder' => esc_html__( 'Type title text here', 'restaurant-cafe-addon-for-elementor' ),
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
			]
		);
		$repeater->add_control(
			'toggle_align',
			[
				'label' => esc_html__( 'Toggle Align?', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'restaurant-cafe-addon-for-elementor' ),
				'label_off' => esc_html__( 'No', 'restaurant-cafe-addon-for-elementor' ),
				'return_value' => 'true',
			]
		);
		$repeater->add_control(
			'heighlight',
			[
				'label' => esc_html__( 'Heighlight?', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'restaurant-cafe-addon-for-elementor' ),
				'label_off' => esc_html__( 'No', 'restaurant-cafe-addon-for-elementor' ),
				'return_value' => 'true',
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
						'{{WRAPPER}} .narep-food-menu-item-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
						'{{WRAPPER}} .narep-food-menu-item-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'section_bg_color',
				[
					'label' => esc_html__( 'Background Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .narep-food-menu-item-wrap, {{WRAPPER}} .narep-food-menu-item-wrap .food-title, {{WRAPPER}} .narep-food-menu-item-wrap .food-price' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'section_hbg_color',
				[
					'label' => esc_html__( 'Heighlighted Background Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .food-menu-heighlight, {{WRAPPER}} .food-menu-heighlight .food-title, {{WRAPPER}} .food-menu-heighlight .food-price' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'line_color',
				[
					'label' => esc_html__( 'Line Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .narep-food-menu-title:after' => 'border-color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'secn_border',
					'label' => esc_html__( 'Border', 'restaurant-cafe-addon-for-elementor' ),
					'selector' => '{{WRAPPER}} .narep-food-menu-item-wrap',
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'section_box_shadow',
					'label' => esc_html__( 'Box Shadow', 'restaurant-cafe-addon-for-elementor' ),
					'selector' => '{{WRAPPER}} .narep-food-menu-item-wrap',
				]
			);
			$this->add_control(
				'scn_border_radius',
				[
					'label' => __( 'Border Radius', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .narep-food-menu-item-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
						'{{WRAPPER}} .narep-food-menu-item .narep-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'image_border',
					'label' => esc_html__( 'Border', 'restaurant-cafe-addon-for-elementor' ),
					'selector' => '{{WRAPPER}} .narep-food-menu-item .narep-image',
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'image_box_shadow',
					'label' => esc_html__( 'Image Box Shadow', 'restaurant-cafe-addon-for-elementor' ),
					'selector' => '{{WRAPPER}} .narep-food-menu-item .narep-image',
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
						'{{WRAPPER}} .narep-food-menu-info h4' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Typography', 'restaurant-cafe-addon-for-elementor' ),
					'name' => 'sastool_title_typography',
					'selector' => '{{WRAPPER}} .narep-food-menu-info h4',
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
							'{{WRAPPER}} .narep-food-menu-info h4, {{WRAPPER}} .narep-food-menu-info h4 a' => 'color: {{VALUE}};',
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
							'{{WRAPPER}} .narep-food-menu-info h4 a:hover' => 'color: {{VALUE}};',
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
						'{{WRAPPER}} .food-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
						'{{WRAPPER}} .food-price' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'price_bg_color',
				[
					'label' => esc_html__( 'Background Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .narep-food-menu-wrap .food-price, {{WRAPPER}} .narep-food-menu-wrap .food-price span' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'price_border',
					'label' => esc_html__( 'Price Border', 'restaurant-cafe-addon-for-elementor' ),
					'selector' => '{{WRAPPER}} .food-price',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Typography', 'restaurant-cafe-addon-for-elementor' ),
					'name' => 'sastool_price_typography',
					'selector' => '{{WRAPPER}} .food-price',
				]
			);
			$this->add_control(
				'price_color',
				[
					'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .food-price' => 'color: {{VALUE}};',
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
						'{{WRAPPER}} .food-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'label_bg_color',
				[
					'label' => esc_html__( 'Background Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .food-label' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Typography', 'restaurant-cafe-addon-for-elementor' ),
					'name' => 'sastool_label_typography',
					'selector' => '{{WRAPPER}} .food-label',
				]
			);
			$this->add_control(
				'label_color',
				[
					'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .food-label' => 'color: {{VALUE}};',
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
						'{{WRAPPER}} .narep-food-menu-info p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Typography', 'restaurant-cafe-addon-for-elementor' ),
					'name' => 'sastool_content_typography',
					'selector' => '{{WRAPPER}} .narep-food-menu-info p',
				]
			);
			$this->add_control(
				'content_color',
				[
					'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .narep-food-menu-info p' => 'color: {{VALUE}};',
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
		$menu_style = !empty( $settings['menu_style'] ) ? $settings['menu_style'] : '';
		$listItems_groups = !empty( $settings['listItems_groups'] ) ? $settings['listItems_groups'] : '';

		if ($menu_style === 'two') {
			$style_cls = ' food-menu-two';
		} elseif ($menu_style === 'three') {
			$style_cls = ' food-menu-three';
		} elseif ($menu_style === 'four') {
			$style_cls = ' food-menu-four';
		} else {
			$style_cls = '';
		}

		$output = '<div class="narep-food-menu-wrap'.$style_cls.'">';
		if ($menu_style === 'two') { $output .= '<div class="nich-row nich-align-items-center">'; }
								if ( is_array( $listItems_groups ) && !empty( $listItems_groups ) ) {
								  foreach ( $listItems_groups as $each_list ) {
								  	$food_menu_image = !empty( $each_list['food_menu_image']['id'] ) ? $each_list['food_menu_image']['id'] : '';
								  	$need_indicator = !empty( $each_list['need_indicator'] ) ? $each_list['need_indicator'] : '';
								  	$non_veg = !empty( $each_list['non_veg'] ) ? $each_list['non_veg'] : '';
										$image_url = wp_get_attachment_url( $food_menu_image );
								  	$list_text = !empty( $each_list['list_text'] ) ? $each_list['list_text'] : '';
								  	$text_link = !empty( $each_list['text_link']['url'] ) ? $each_list['text_link']['url'] : '';
										$text_link_external = !empty( $each_list['text_link']['is_external'] ) ? 'target="_blank"' : '';
										$text_link_nofollow = !empty( $each_list['text_link']['nofollow'] ) ? 'rel="nofollow"' : '';
										$text_link_attr = !empty( $text_link ) ?  $text_link_external.' '.$text_link_nofollow : '';
								  	$list_label = !empty( $each_list['list_label'] ) ? $each_list['list_label'] : '';
								  	$list_price = !empty( $each_list['list_price'] ) ? $each_list['list_price'] : '';
								  	$list_content = !empty( $each_list['list_content'] ) ? $each_list['list_content'] : '';
										$rating = !empty( $each_list['rating'] ) ? $each_list['rating'] : '';
										$toggle_align = !empty( $each_list['toggle_align'] ) ? $each_list['toggle_align'] : '';
										$heighlight = !empty( $each_list['heighlight'] ) ? $each_list['heighlight'] : '';
								  	$link_style = !empty( $each_list['link_style'] ) ? $each_list['link_style'] : '';
										$image_link = !empty( $each_list['image_link']['url'] ) ? $each_list['image_link']['url'] : '';
										$image_link_external = !empty( $each_list['image_link']['is_external'] ) ? 'target="_blank"' : '';
										$image_link_nofollow = !empty( $each_list['image_link']['nofollow'] ) ? 'rel="nofollow"' : '';
										$image_link_attr = !empty( $image_link ) ?  $image_link_external.' '.$image_link_nofollow : '';

										if ($need_indicator) {
											if ($non_veg) {
												$vnv_cls = ' non-veg';
											} else {
												$vnv_cls = ' veg';
											}
											$indic_cls = ' food-indicator';
										} else {
											$vnv_cls = '';
											$indic_cls = '';
										}

								  	if ($toggle_align) {
											$toggle_cls = ' food-menu-toggle';
										} else {
											$toggle_cls = '';
										}
										if ($heighlight) {
											$heighlight_cls = ' food-menu-heighlight';
										} else {
											$heighlight_cls = '';
										}
										if ($food_menu_image) {
											$img_cls = ' hav-img';
										} else {
											$img_cls = ' no-img';
										}

								  	$list_title_link = $text_link ? '<a href="'.esc_url($text_link).'" '.$text_link_attr.'>'. esc_html($list_text) .'</a>' : esc_html($list_text);
										$list_label_two = !empty( $list_label ) ? '<h5 class="food-label">'.$list_label.'</h5>' : '';
										$list_label = !empty( $list_label ) ? '<span class="food-label">'.$list_label.'</span>' : '';
										$list_price_two = !empty( $list_price ) ? '<h5 class="food-price"><span>'.$list_price.'</span></h5>' : '';
										$list_price = !empty( $list_price ) ? '<span class="food-price">'.$list_price.'</span>' : '';
										$list_title = !empty( $list_text ) ? '<h4 class="narep-food-menu-title"><span class="food-title">'.$list_title_link.$list_label.'</span>'.$list_price.'</h4>' : '';
										$list_title_two = !empty( $list_text ) ? '<h4 class="narep-food-menu-title">'.$list_title_link.'</h4>' : '';
										$list_title_three = !empty( $list_text ) ? '<h4 class="narep-food-menu-title"><span class="food-title">'.$list_title_link.'</span></h4>' : '';
										$list_content = !empty( $list_content ) ? '<p>'.$list_content.'</p>' : '';

										if ($link_style === 'two') {
											$popup_class = '';
											$food_image = $image_link ? '<a href="'.esc_url($image_link).'" '.$image_link_attr.'><img src="'.esc_url($image_url).'" alt="'.esc_attr($list_text).'"></a>' : '<img src="'.esc_url($image_url).'" alt="'.esc_attr($list_text).'">';
										} else {
											$popup_class = ' narep-popup';
											$food_image = '<a href="'. esc_url($image_url) .'"><img src="'.esc_url($image_url).'" alt="'.esc_attr($list_text).'"></a>';
										}

										$food_menu_image = $image_url ? '<div class="narep-food-menu-item"><div class="narep-image'.$popup_class.'">'.$food_image.'</div></div>' : '';
										$food_menu_image_two = $image_url ? '<div class="narep-food-menu-item"><div class="narep-image'.$popup_class.'">'.$food_image.'</div>'.$list_price.'</div>' : '';
										$food_menu_image_three = $image_url ? '<div class="narep-image'.$popup_class.'">'.$food_image.$list_label_two.'</div>' : '';

										$btn_text = !empty( $each_list['btn_text'] ) ? $each_list['btn_text'] : '';
								  	$btn_link = !empty( $each_list['btn_link']['url'] ) ? $each_list['btn_link']['url'] : '';
										$btn_link_external = !empty( $each_list['btn_link']['is_external'] ) ? 'target="_blank"' : '';
										$btn_link_nofollow = !empty( $each_list['btn_link']['nofollow'] ) ? 'rel="nofollow"' : '';
										$btn_link_attr = !empty( $btn_link ) ?  $btn_link_external.' '.$btn_link_nofollow : '';

										$button = $btn_link ? '<div class="narep-btn-wrap"><a href="'.esc_url($btn_link).'" '.$btn_link_attr.' class="narep-btn black-btn">'. esc_html($btn_text) .'</a></div>' : '';

										if ($menu_style === 'two') {
											$output .= '<div class="nich-col-lg-4">
																		<div class="narep-food-menu-item-wrap zoom-image'.$toggle_cls.$img_cls.$heighlight_cls.$vnv_cls.$indic_cls.'">
												              '.$list_label_two.$food_menu_image_two.'<div class="narep-food-menu-info">'.$list_title_two.$list_content.'</div>'.$button.'
												            </div>
											            </div>';
										} elseif ($menu_style === 'three') {
											if ($food_menu_image) {
											$output .= '<div class="narep-food-menu-item-wrap zoom-image'.$toggle_cls.$img_cls.$heighlight_cls.$vnv_cls.$indic_cls.'">
											              <div class="narep-food-menu-item">'.$food_menu_image_three.'
											              	<div class="narep-customer-rating">';
											                	for( $i=1; $i<= $rating; $i++) {
															            $output .= '<i class="fa fa-star"></i>';
															          }
															          for( $i=5; $i > $rating; $i--) {
															            $output .= '<i class="fa fa-star-o"></i>';
															          }
											                $output .= '</div>
											                </div><div class="narep-food-menu-info">'.$list_title_three.$list_content.$list_price_two.'</div>
											            </div>';
						          } else {
						          	$output .= '<div class="narep-food-menu-item-wrap zoom-image'.$toggle_cls.$img_cls.$heighlight_cls.$vnv_cls.$indic_cls.'">
						          								<div class="narep-food-menu-info">'.$list_title.'
						          								<div class="menu-info-inner">'.$list_content.'
							          								<div class="narep-customer-rating">';
												                	for( $i=1; $i<= $rating; $i++) {
																            $output .= '<i class="fa fa-star"></i>';
																          }
																          for( $i=5; $i > $rating; $i--) {
																            $output .= '<i class="fa fa-star-o"></i>';
																          }
												                $output .= '</div>
											                </div>'.$button.'
											                </div>
											            	</div>';
						          }
										} elseif ($menu_style === 'four') {
											$output .= '<div class="narep-food-menu-item-wrap zoom-image'.$toggle_cls.$img_cls.$heighlight_cls.$vnv_cls.$indic_cls.'">
											              '.$food_menu_image.'<div class="narep-food-menu-info">'.$list_title.$list_content.'</div>'.$button.'
											            </div>';
										} else {
	                  	$output .= '<div class="narep-food-menu-item-wrap zoom-image'.$toggle_cls.$img_cls.$heighlight_cls.$vnv_cls.$indic_cls.'">
											              '.$food_menu_image.'<div class="narep-food-menu-info">'.$list_title.$list_content.'</div>
											            </div>';
										}
	                }
	              }
		if ($menu_style === 'two') { $output .= '</div>'; }
    $output .= '</div>';
		echo $output;

	}

}
Plugin::instance()->widgets_manager->register_widget_type( new Restaurant_Elementor_Addon_Unique_FoodMenu() );

} // enable & disable
