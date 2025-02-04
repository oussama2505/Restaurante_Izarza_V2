<?php
/*
 * Elementor Restaurant & Cafe Addon for Elementor Stats Widget
 * Author & Copyright: NicheAddon
*/

namespace Elementor;

if (!isset(get_option( 'rcafe_uw_settings' )['nbeds_stats'])) { // enable & disable

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Restaurant_Elementor_Addon_Unique_Stats extends Widget_Base{

	/**
	 * Retrieve the widget name.
	*/
	public function get_name(){
		return 'narestaurant_unique_stats';
	}

	/**
	 * Retrieve the widget title.
	*/
	public function get_title(){
		return esc_html__( 'Stats', 'restaurant-cafe-addon-for-elementor' );
	}

	/**
	 * Retrieve the widget icon.
	*/
	public function get_icon() {
		return 'eicon-countdown';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	*/
	public function get_categories() {
		return ['narestaurant-unique-category'];
	}

	/**
	 * Register Restaurant & Cafe Addon for Elementor Stats widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	*/
	protected function _register_controls(){

		$this->start_controls_section(
			'section_stats',
			[
				'label' => __( 'Stats Options', 'restaurant-cafe-addon-for-elementor' ),
			]
		);
		$this->add_control(
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
		$this->add_control(
			'stats_image',
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
		$this->add_control(
			'stats_icon',
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
		$this->add_control(
			'stats_link',
			[
				'label' => esc_html__( 'Stats Link', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::URL,
				'placeholder' => 'https://your-link.com',
				'default' => [
					'url' => '',
				],
				'label_block' => true,
			]
		);
		$this->add_control(
			'stats_title',
			[
				'label' => esc_html__( 'Title Text', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Chefs', 'restaurant-cafe-addon-for-elementor' ),
				'placeholder' => esc_html__( 'Type title text here', 'restaurant-cafe-addon-for-elementor' ),
				'label_block' => true,
			]
		);
		$this->add_control(
			'stats_counter',
			[
				'label' => esc_html__( 'Counter', 'restaurant-cafe-addon-for-elementor' ),
				'default' => esc_html__( '100' ),
				'placeholder' => esc_html__( 'Type your counter here', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,
			]
		);
		$this->end_controls_section();// end: Section

		// Section
			$this->start_controls_section(
				'sectn_style',
				[
					'label' => esc_html__( 'Section', 'restaurant-cafe-addon-for-elementor' ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'box_border_radius',
				[
					'label' => __( 'Border Radius', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .narep-stats-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'stats_section_margin',
				[
					'label' => __( 'Margin', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],
					'selectors' => [
						'{{WRAPPER}} .narep-stats-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'stats_section_padding',
				[
					'label' => __( 'Section Padding', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],
					'selectors' => [
						'{{WRAPPER}} .narep-stats-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->start_controls_tabs( 'secn_style' );
				$this->start_controls_tab(
					'secn_normal',
					[
						'label' => esc_html__( 'Normal', 'restaurant-cafe-addon-for-elementor' ),
					]
				);
				$this->add_control(
					'secn_bg_color',
					[
						'label' => esc_html__( 'Background Color', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .narep-stats-item' => 'background-color: {{VALUE}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'secn_border',
						'label' => esc_html__( 'Border', 'restaurant-cafe-addon-for-elementor' ),
						'selector' => '{{WRAPPER}} .narep-stats-item',
					]
				);
				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'secn_box_shadow',
						'label' => esc_html__( 'Section Box Shadow', 'restaurant-cafe-addon-for-elementor' ),
						'selector' => '{{WRAPPER}} .narep-stats-item',
					]
				);
				$this->end_controls_tab();  // end:Normal tab

				$this->start_controls_tab(
					'secn_hover',
					[
						'label' => esc_html__( 'Hover', 'restaurant-cafe-addon-for-elementor' ),
					]
				);
				$this->add_control(
					'secn_nrml_color',
					[
						'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .narep-stats-item.narep-hover .narep-icon,
							 {{WRAPPER}} .narep-stats-item.narep-hover .narep-stats-title,
							 {{WRAPPER}} .narep-stats-item.narep-hover' => 'color: {{VALUE}};',
						],
					]
				);
				$this->add_control(
					'secn_bdrg_color',
					[
						'label' => esc_html__( 'Hover Border Color', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .narep-stats-item.narep-hover' => 'background-color: {{VALUE}};',
						],
					]
				);
				$this->add_control(
					'secn_bg_hover_color',
					[
						'label' => esc_html__( 'Background Color', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .narep-stats-item.narep-hover' => 'background-color: {{VALUE}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name' => 'secn_hov_border',
						'label' => esc_html__( 'Border', 'restaurant-cafe-addon-for-elementor' ),
						'selector' => '{{WRAPPER}} .narep-stats-item.narep-hover',
					]
				);
				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'secn_hov_box_shadow',
						'label' => esc_html__( 'Section Box Shadow', 'restaurant-cafe-addon-for-elementor' ),
						'selector' => '{{WRAPPER}} .narep-stats-item.narep-hover',
					]
				);
				$this->end_controls_tab();  // end:Hover tab
			$this->end_controls_tabs(); // end tabs

			$this->end_controls_section();// end: Section

		// Image
			$this->start_controls_section(
				'section_image_style',
				[
					'label' => esc_html__( 'Image', 'restaurant-cafe-addon-for-elementor' ),
					'tab' => Controls_Manager::TAB_STYLE,
					'condition' => [
						'upload_type' => array('image'),
					],
				]
			);
			$this->add_control(
				'image_padding',
				[
					'label' => __( 'Image Padding', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .narep-stats-item .narep-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();// end: Section

		// Icon
			$this->start_controls_section(
				'section_icon_style',
				[
					'label' => esc_html__( 'Icon', 'restaurant-cafe-addon-for-elementor' ),
					'tab' => Controls_Manager::TAB_STYLE,
					'condition' => [
						'upload_type' => array('icon'),
					],
				]
			);
			$this->add_control(
				'icon_color',
				[
					'label' => esc_html__( 'Icon Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .narep-stats-item .narep-icon i' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'icon_size',
				[
					'label' => esc_html__( 'Icon Size', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 500,
							'step' => 1,
						],
					],
					'size_units' => [ 'px' ],
					'selectors' => [
						'{{WRAPPER}} .narep-stats-item .narep-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'icon_lheight',
				[
					'label' => esc_html__( 'Icon width & Line Height', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 500,
							'step' => 1,
						],
					],
					'size_units' => [ 'px' ],
					'selectors' => [
						'{{WRAPPER}} .narep-stats-item .narep-icon i' => 'line-height: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .narep-stats-item .narep-icon' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
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
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Typography', 'restaurant-cafe-addon-for-elementor' ),
					'name' => 'sasstp_title_typography',
					'selector' => '{{WRAPPER}} .narep-stats-title',
				]
			);
			$this->add_control(
				'title_color',
				[
					'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .narep-stats-title' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();// end: Section

		// Counter
			$this->start_controls_section(
				'section_content_style',
				[
					'label' => esc_html__( 'Counter', 'restaurant-cafe-addon-for-elementor' ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Typography', 'restaurant-cafe-addon-for-elementor' ),
					'name' => 'content_typography',
					'selector' => '{{WRAPPER}} .narep-stats-item .stats-counter',
				]
			);
			$this->add_control(
				'content_color',
				[
					'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .narep-stats-item .stats-counter' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();// end: Section

	}

	/**
	 * Render App Works widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	*/
	protected function render() {
		$settings = $this->get_settings_for_display();
		$upload_type = !empty( $settings['upload_type'] ) ? $settings['upload_type'] : '';
		$stats_image = !empty( $settings['stats_image']['id'] ) ? $settings['stats_image']['id'] : '';
		$stats_icon = !empty( $settings['stats_icon'] ) ? $settings['stats_icon'] : '';
		$stats_title = !empty( $settings['stats_title'] ) ? $settings['stats_title'] : '';
		$stats_counter = !empty( $settings['stats_counter'] ) ? $settings['stats_counter'] : '';

		$stats_link = !empty( $settings['stats_link']['url'] ) ? $settings['stats_link']['url'] : '';
		$stats_link_external = !empty( $settings['stats_link']['is_external'] ) ? 'target="_blank"' : '';
		$stats_link_nofollow = !empty( $settings['stats_link']['nofollow'] ) ? 'rel="nofollow"' : '';
		$stats_link_attr = !empty( $stats_link ) ?  $stats_link_external.' '.$stats_link_nofollow : '';

		// Image
		$image_url = wp_get_attachment_url( $stats_image );

		$stats_image = $image_url ? '<div class="narep-image"><img src="'.esc_url($image_url).'" alt="'.esc_attr($stats_title).'"></div>' : '';
		$stats_icon = $stats_icon ? '<div class="narep-icon"><i class="icon-linea '.esc_attr($stats_icon).'"></i></div>' : '';

		if ($upload_type === 'icon'){
		  $icon_main = $stats_icon;
		} else {
		  $icon_main = $stats_image;
		}
		$title = $stats_title ? '<span class="narep-stats-title">'.esc_html($stats_title).'</span>' : '';
		$counter = $stats_counter ? '<span class="stats-counter">'.esc_html($stats_counter).'</span>' : '';
		$output = '<div class="narep-stats-wrap">';
		if ($stats_link) {
			$output .= '<a href="'.esc_url($stats_link).'" '.$stats_link_attr.' class="narep-stats-item">
	                '.$icon_main.'
	                <span class="narep-stats-info">'.$title.$counter.'</span>
	              </a>';
    } else {
    	$output .= '<div class="narep-stats-item">
	                '.$icon_main.'
	                <span class="narep-stats-info">'.$title.$counter.'</span>
	              </div>';
    }
		$output .= '</div>';
		echo $output;

	}

}
Plugin::instance()->widgets_manager->register_widget_type( new Restaurant_Elementor_Addon_Unique_Stats() );

} // enable & disable
