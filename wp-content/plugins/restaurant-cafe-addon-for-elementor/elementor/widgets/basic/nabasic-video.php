<?php
/*
 * Elementor Restaurant & Cafe Addon for Elementor Video Widget
 * Author & Copyright: NicheAddon
*/

namespace Elementor;

if (!isset(get_option( 'rcafe_bw_settings' )['nbeds_video'])) { // enable & disable

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Restaurant_Elementor_Addon_Video extends Widget_Base{

	/**
	 * Retrieve the widget name.
	*/
	public function get_name(){
		return 'narestaurant_basic_video';
	}

	/**
	 * Retrieve the widget title.
	*/
	public function get_title(){
		return esc_html__( 'Video', 'restaurant-cafe-addon-for-elementor' );
	}

	/**
	 * Retrieve the widget icon.
	*/
	public function get_icon() {
		return 'eicon-play';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	*/
	public function get_categories() {
		return ['narestaurant-basic-category'];
	}

	/**
	 * Register Restaurant & Cafe Addon for Elementor Video widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	*/
	protected function _register_controls(){

		$this->start_controls_section(
			'section_video',
			[
				'label' => esc_html__( 'Video Options', 'restaurant-cafe-addon-for-elementor' ),
			]
		);
		$this->add_control(
			'need_content',
			[
				'label' => esc_html__( 'Need Content?', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'restaurant-cafe-addon-for-elementor' ),
				'label_off' => esc_html__( 'No', 'restaurant-cafe-addon-for-elementor' ),
				'return_value' => 'true',
			]
		);
		$this->add_control(
			'cnt_head',
			[
				'label' => __( 'Content Options', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'need_content' => 'true',
				],
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
				'condition' => [
					'need_content' => 'true',
				],
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
				'condition' => [
					'need_content' => 'true',
				],
			]
		);
		$this->add_control(
			'title_image',
			[
				'label' => esc_html__( 'Title Image', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::MEDIA,
				'frontend_available' => true,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'description' => esc_html__( 'Set your image.', 'restaurant-cafe-addon-for-elementor'),
				'condition' => [
					'need_content' => 'true',
				],
			]
		);
		$this->add_control(
			'content',
			[
				'label' => esc_html__( 'Content', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::WYSIWYG,
				'placeholder' => esc_html__( 'Type content here', 'restaurant-cafe-addon-for-elementor' ),
				'condition' => [
					'need_content' => 'true',
				],
				'label_block' => true,
			]
		);
		$this->add_control(
			'sign_image',
			[
				'label' => esc_html__( 'Sign Image', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::MEDIA,
				'frontend_available' => true,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'description' => esc_html__( 'Set your image.', 'restaurant-cafe-addon-for-elementor'),
				'condition' => [
					'need_content' => 'true',
				],
			]
		);
		$this->add_control(
			'video_head',
			[
				'label' => __( 'Video Options', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'need_title',
			[
				'label' => esc_html__( 'Need Title?', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'restaurant-cafe-addon-for-elementor' ),
				'label_off' => esc_html__( 'No', 'restaurant-cafe-addon-for-elementor' ),
				'return_value' => 'true',
			]
		);
		$this->add_control(
			'btn_animation',
			[
				'label' => esc_html__( 'Need Button Animation?', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'restaurant-cafe-addon-for-elementor' ),
				'label_off' => esc_html__( 'No', 'restaurant-cafe-addon-for-elementor' ),
				'return_value' => 'true',
			]
		);
		$this->add_control(
			'bg_image',
			[
				'label' => esc_html__( 'Video Image', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->add_control(
			'video_title',
			[
				'label' => esc_html__( 'Title', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Watch the Demo', 'restaurant-cafe-addon-for-elementor' ),
				'label_block' => true,
				'condition' => [
					'need_title' => 'true',
				],
			]
		);
		$this->add_control(
			'video_link',
			[
				'label' => esc_html__( 'Video Link', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'placeholder' => esc_html__( 'Enter your link here', 'restaurant-cafe-addon-for-elementor' ),
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
						'{{WRAPPER}} .narep-title-section' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
						'{{WRAPPER}} .narep-title-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'section_bg_color',
				[
					'label' => esc_html__( 'Background Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .narep-title-section' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'secn_border',
					'label' => esc_html__( 'Border', 'restaurant-cafe-addon-for-elementor' ),
					'selector' => '{{WRAPPER}} .narep-title-section',
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'section_box_shadow',
					'label' => esc_html__( 'Box Shadow', 'restaurant-cafe-addon-for-elementor' ),
					'selector' => '{{WRAPPER}} .narep-title-section',
				]
			);
			$this->add_control(
				'scn_border_radius',
				[
					'label' => __( 'Border Radius', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .narep-title-section' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'label' => __( 'Title Padding', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],
					'selectors' => [
						'{{WRAPPER}} .narep-title-section h3' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'title_margin',
				[
					'label' => __( 'Title Margin', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],
					'selectors' => [
						'{{WRAPPER}} .narep-title-section h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Typography', 'restaurant-cafe-addon-for-elementor' ),
					'name' => 'adn_title_typography',
					'selector' => '{{WRAPPER}} .narep-title-section h3',
				]
			);
			$this->add_control(
				'title_color',
				[
					'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .narep-title-section h3' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name' => 'title_shadow',
					'label' => esc_html__( 'Title Shadow', 'restaurant-cafe-addon-for-elementor' ),
					'selector' => '{{WRAPPER}} .narep-title-section h3',
				]
			);
			$this->add_control(
				'ttlimg',
				[
					'label' => __( 'Title Image', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_responsive_control(
				'title_img_padding',
				[
					'label' => __( 'Title Image Padding', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],
					'selectors' => [
						'{{WRAPPER}} .narep-title-section .narep-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'title_img_margin',
				[
					'label' => __( 'Title Image Margin', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],
					'selectors' => [
						'{{WRAPPER}} .narep-title-section .narep-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'simg_width',
				[
					'label' => esc_html__( 'Image Width', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
							'step' => 1,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .narep-title-section .narep-image' => 'max-width: {{SIZE}}{{UNIT}};',
					],
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
						'{{WRAPPER}} .narep-title-section h4' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Typography', 'restaurant-cafe-addon-for-elementor' ),
					'name' => 'sub_title_typography',
					'selector' => '{{WRAPPER}} .narep-title-section h4',
				]
			);
			$this->add_control(
				'sub_title_color',
				[
					'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .narep-title-section h4' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name' => 'sub_title_shadow',
					'label' => esc_html__( 'Title Shadow', 'restaurant-cafe-addon-for-elementor' ),
					'selector' => '{{WRAPPER}} .narep-title-section h4',
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
						'{{WRAPPER}} .narep-title-section h4' => 'left: {{SIZE}}{{UNIT}};',
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
						'{{WRAPPER}} .narep-title-section h4' => 'top: {{SIZE}}{{UNIT}};',
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
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Typography', 'restaurant-cafe-addon-for-elementor' ),
					'name' => 'content_typography',
					'selector' => '{{WRAPPER}} .narep-title-section p',
				]
			);
			$this->add_control(
				'content_color',
				[
					'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .narep-title-section p' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();// end: Section

		// Video Section
			$this->start_controls_section(
				'video_style',
				[
					'label' => esc_html__( 'Video Section', 'restaurant-cafe-addon-for-elementor' ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'vid_section_height',
				[
					'label' => esc_html__( 'Height', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
							'step' => 1,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .narep-video-wrap .narep-image' => 'min-height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'vid_section_padding',
				[
					'label' => __( 'Padding', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .narep-video-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->start_controls_tabs( 'secn_style' );
				$this->start_controls_tab(
					'vid_secn_normal',
					[
						'label' => esc_html__( 'Normal', 'restaurant-cafe-addon-for-elementor' ),
					]
				);
				$this->add_control(
					'vid_secn_border_radius',
					[
						'label' => __( 'Border Radius', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} .narep-video-wrap .narep-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$this->add_control(
					'vid_secn_bg_color',
					[
						'label' => esc_html__( 'Overlay Color', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .narep-video-wrap .narep-image:after' => 'background-color: {{VALUE}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'vid_secn_border',
						'label' => esc_html__( 'Border', 'restaurant-cafe-addon-for-elementor' ),
						'selector' => '{{WRAPPER}} .narep-video-wrap .narep-image',
					]
				);
				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'vid_secn_box_shadow',
						'label' => esc_html__( 'Section Box Shadow', 'restaurant-cafe-addon-for-elementor' ),
						'selector' => '{{WRAPPER}} .narep-video-wrap .narep-image',
					]
				);
				$this->end_controls_tab();  // end:Normal tab

				$this->start_controls_tab(
					'vid_secn_hover',
					[
						'label' => esc_html__( 'Hover', 'restaurant-cafe-addon-for-elementor' ),
					]
				);
				$this->add_control(
					'vid_secn_hov_border_radius',
					[
						'label' => __( 'Border Radius', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} .narep-video-wrap.narep-hover .narep-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$this->add_control(
					'vid_secn_bg_hover_color',
					[
						'label' => esc_html__( 'Overlay Color', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .narep-video-wrap.narep-hover .narep-image:after' => 'background-color: {{VALUE}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'vid_secn_hover_border',
						'label' => esc_html__( 'Border', 'restaurant-cafe-addon-for-elementor' ),
						'selector' => '{{WRAPPER}} .narep-video-wrap.narep-hover .narep-image',
					]
				);
				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'vid_secn_hover_box_shadow',
						'label' => esc_html__( 'Section Box Shadow', 'restaurant-cafe-addon-for-elementor' ),
						'selector' => '{{WRAPPER}} .narep-video-wrap.narep-hover .narep-image',
					]
				);
				$this->end_controls_tab();  // end:Hover tab
			$this->end_controls_tabs(); // end tabs
			$this->end_controls_section();// end: Section

		// Button
			$this->start_controls_section(
				'section_btn_style',
				[
					'label' => esc_html__( 'Button Style', 'restaurant-cafe-addon-for-elementor' ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'btn_width',
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
						'{{WRAPPER}} .narep-video-btn, {{WRAPPER}} .narep-ripple, {{WRAPPER}} .narep-ripple:before, {{WRAPPER}} .narep-ripple:after' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->start_controls_tabs( 'icon_style' );
				$this->start_controls_tab(
					'icon_normal',
					[
						'label' => esc_html__( 'Normal', 'restaurant-cafe-addon-for-elementor' ),
					]
				);
				$this->add_control(
					'btn_border_radius',
					[
						'label' => __( 'Border Radius', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} .narep-video-btn, {{WRAPPER}} .narep-ripple, {{WRAPPER}} .narep-ripple:before, {{WRAPPER}} .narep-ripple:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$this->add_control(
					'icon_color',
					[
						'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .narep-video-btn i' => 'color: {{VALUE}};',
						],
					]
				);
				$this->add_control(
					'icon_ripple_color',
					[
						'label' => esc_html__( 'Ripple Color', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .narep-ripple, {{WRAPPER}} .narep-ripple:before, {{WRAPPER}} .narep-ripple:after' => 'box-shadow: 0 0 0 0 {{VALUE}};',
						],
					]
				);
				$this->add_control(
					'icon_bg_color',
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
						'name' => 'icon_border',
						'label' => esc_html__( 'Border', 'restaurant-cafe-addon-for-elementor' ),
						'selector' => '{{WRAPPER}} .narep-video-btn',
					]
				);
				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'btn_box_shadow',
						'label' => esc_html__( 'Section Box Shadow', 'restaurant-cafe-addon-for-elementor' ),
						'selector' => '{{WRAPPER}} .narep-video-btn',
					]
				);
				$this->end_controls_tab();  // end:Normal tab

				$this->start_controls_tab(
					'icon_hover',
					[
						'label' => esc_html__( 'Hover', 'restaurant-cafe-addon-for-elementor' ),
					]
				);
				$this->add_control(
					'btn_hov_border_radius',
					[
						'label' => __( 'Border Radius', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} .narep-video-btn:hover,
							{{WRAPPER}} .narep-video-wrap a:hover .narep-video-btn,
							{{WRAPPER}} .narep-video-btn:hover .narep-ripple,
							{{WRAPPER}} .narep-video-btn:hover .narep-ripple:before,
							{{WRAPPER}} .narep-video-btn:hover .narep-ripple:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$this->add_control(
					'icon_hover_color',
					[
						'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .narep-video-btn:hover i, {{WRAPPER}} .narep-video-wrap a:hover .narep-video-btn i' => 'color: {{VALUE}};',
						],
					]
				);
				$this->add_control(
					'icon_hover_ripple_color',
					[
						'label' => esc_html__( 'Ripple Color', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .narep-video-btn:hover .narep-ripple, {{WRAPPER}} .narep-video-btn:hover .narep-ripple:before, {{WRAPPER}} .narep-video-btn:hover .narep-ripple:after' => 'box-shadow: 0 0 0 0 {{VALUE}};',
						],
					]
				);
				$this->add_control(
					'icon_bg_hover_color',
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
						'name' => 'icon_border_hover',
						'label' => esc_html__( 'Border', 'restaurant-cafe-addon-for-elementor' ),
						'selector' => '{{WRAPPER}} .narep-video-btn:hover, {{WRAPPER}} .narep-video-wrap a:hover .narep-video-btn',
					]
				);
				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'btn_hov_box_shadow',
						'label' => esc_html__( 'Section Box Shadow', 'restaurant-cafe-addon-for-elementor' ),
						'selector' => '{{WRAPPER}} .narep-video-btn:hover, {{WRAPPER}} .narep-video-wrap a:hover .narep-video-btn',
					]
				);
				$this->end_controls_tab();  // end:Hover tab
			$this->end_controls_tabs(); // end tabs
			$this->end_controls_section();// end: Section

		// Title Style
			$this->start_controls_section(
				'vid_title_style',
				[
					'label' => esc_html__( 'Video Title', 'restaurant-cafe-addon-for-elementor' ),
					'tab' => Controls_Manager::TAB_STYLE,
					'condition' => [
						'need_title' => 'true',
					],
				]
			);
			$this->add_control(
				'vid_title_padding',
				[
					'label' => __( 'Title Padding', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .narep-video-wrap .video-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'vid_title_typography',
					'selector' => '{{WRAPPER}} .narep-video-wrap .video-label',
				]
			);
			$this->start_controls_tabs( 'video_title_style' );
				$this->start_controls_tab(
					'vid_title_normal',
					[
						'label' => esc_html__( 'Normal', 'restaurant-cafe-addon-for-elementor' ),
					]
				);
				$this->add_control(
					'vid_title_color',
					[
						'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .narep-video-wrap .video-label' => 'color: {{VALUE}};',
						],
					]
				);
				$this->end_controls_tab();  // end:Normal tab

				$this->start_controls_tab(
					'vid_title_hover',
					[
						'label' => esc_html__( 'Hover', 'restaurant-cafe-addon-for-elementor' ),
					]
				);
				$this->add_control(
					'vid_title_hov_color',
					[
						'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .narep-video-wrap a:hover .video-label' => 'color: {{VALUE}};',
						],
					]
				);
				$this->end_controls_tab();  // end:Hover tab
			$this->end_controls_tabs(); // end tabs
			$this->end_controls_section();// end: Section

	}

	/**
	 * Render Video widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	*/
	protected function render() {
		$settings = $this->get_settings_for_display();
		$need_content = !empty( $settings['need_content'] ) ? $settings['need_content'] : '';
		$section_title = !empty( $settings['section_title'] ) ? $settings['section_title'] : '';
		$section_sub_title = !empty( $settings['section_sub_title'] ) ? $settings['section_sub_title'] : '';
		$title_image = !empty( $settings['title_image']['id'] ) ? $settings['title_image']['id'] : '';
		$content = !empty( $settings['content'] ) ? $settings['content'] : '';
		$sign_image = !empty( $settings['sign_image']['id'] ) ? $settings['sign_image']['id'] : '';

		$need_title = !empty( $settings['need_title'] ) ? $settings['need_title'] : '';
		$btn_animation = !empty( $settings['btn_animation'] ) ? $settings['btn_animation'] : '';
		$bg_image = !empty( $settings['bg_image']['id'] ) ? $settings['bg_image']['id'] : '';
		$video_link = !empty( $settings['video_link'] ) ? $settings['video_link'] : '';
		$video_title = !empty( $settings['video_title'] ) ? $settings['video_title'] : '';

		// Video
		$image_url = wp_get_attachment_url( $bg_image );

		$image = $image_url ? '<img src="'.esc_url($image_url).'" alt="Video">' : '';

		$title = $video_title ? '<span class="video-label">'.esc_html($video_title).'</span>' : '';
		if ($btn_animation) {
			$animation = '<span class="narep-ripple"></span>';
		} else {
			$animation = '';
		}

		if ($need_title) {
			$video = $video_link ? '<a href="'.esc_url($video_link).'" class="narep-popup-video"><span class="narep-video-btn-wrap"><span class="narep-video-btn"><i class="fa fa-play" aria-hidden="true"></i>'.wp_kses_post( $animation ).'</span>'.$title.'</span></a>' : '';
		} else {
			$video = $video_link ? '<a href="'.esc_url($video_link).'" class="narep-video-btn narep-popup-video"><i class="fa fa-play" aria-hidden="true"></i>'.wp_kses_post( $animation ).'</a>' : '';
		}
		$title_image_url = wp_get_attachment_url( $title_image );
		$section_title = $section_title ? '<h3>'.wp_kses_post($section_title).'</h3>' : '';
		$section_sub_title = $section_sub_title ? '<h4>'.wp_kses_post($section_sub_title).'</h4>' : '';
		$content = $content ? wp_kses_post($content) : '';
		$title_image = $title_image_url ? '<div class="narep-image"><img src="'.esc_url($title_image_url).'" alt="Icon"></div>' : '';
		$sign_image_url = wp_get_attachment_url( $sign_image );
		$sign_image = $sign_image_url ? '<div class="sign-image"><img src="'.esc_url($sign_image_url).'" alt="Icon"></div>' : '';

		if ($need_content) {
			$output = '<div class="narep-video-section">
									<div class="nich-row nich-align-items-center">
										<div class="nich-col-md-8">
											<div class="narep-title-section-wrap">
												<div class="narep-title-section">
													'.$section_sub_title.$section_title.$title_image.$content.$sign_image.'
												</div>
											</div>
										</div>
										<div class="nich-col-md-4">
											<div class="narep-video-wrap"><div class="narep-image" style="background-image: url('.$image_url.');">'.$image.$video.'</div></div>
										</div>
									</div>
								</div>';
		} else {
	  	$output = '<div class="narep-video-section">
									<div class="nich-row nich-align-items-center">
										<div class="nich-col-md-12">
											<div class="narep-video-wrap"><div class="narep-image" style="background-image: url('.$image_url.');">'.$image.$video.'</div></div>
										</div>
									</div>
								</div>';
		}

	  echo $output;

	}

}
Plugin::instance()->widgets_manager->register_widget_type( new Restaurant_Elementor_Addon_Video() );

} // enable & disable
