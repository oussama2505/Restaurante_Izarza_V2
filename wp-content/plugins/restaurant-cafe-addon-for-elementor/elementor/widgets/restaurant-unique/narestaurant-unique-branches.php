<?php
/*
 * Elementor Restaurant & Cafe Addon for Elementor Branches Widget
 * Author & Copyright: NicheAddon
*/

namespace Elementor;

if (!isset(get_option( 'rcafe_uw_settings' )['nbeds_branches'])) { // enable & disable

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Restaurant_Elementor_Addon_Unique_Branches extends Widget_Base{

	/**
	 * Retrieve the widget name.
	*/
	public function get_name(){
		return 'narestaurant_unique_branches';
	}

	/**
	 * Retrieve the widget title.
	*/
	public function get_title(){
		return esc_html__( 'Branches', 'restaurant-cafe-addon-for-elementor' );
	}

	/**
	 * Retrieve the widget icon.
	*/
	public function get_icon() {
		return 'eicon-map-pin';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	*/
	public function get_categories() {
		return ['narestaurant-unique-category'];
	}

	/**
	 * Register Restaurant & Cafe Addon for Elementor Branches widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	*/
	protected function _register_controls(){

		$this->start_controls_section(
			'section_branches',
			[
				'label' => __( 'Branches', 'restaurant-cafe-addon-for-elementor' ),
			]
		);
		$this->add_control(
			'map_image',
			[
				'label' => esc_html__( 'Upload Image', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::MEDIA,
				'frontend_available' => true,
				'default' => [
					'url' => plugins_url( '/', __FILE__ ) . 'assets/images/map-bg.png',
				],
				'description' => esc_html__( 'Set your map image.', 'restaurant-cafe-addon-for-elementor'),
			]
		);
		$repeater = new Repeater();

		$repeater->add_control(
			'list_text',
			[
				'label' => esc_html__( 'Branch', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'text_link',
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
		$repeater->add_responsive_control(
			'icon_top',
			[
				'label' => esc_html__( 'Top', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1200,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ 'px', '%' ],
			]
		);
		$repeater->add_responsive_control(
			'icon_left',
			[
				'label' => esc_html__( 'Left', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1200,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ 'px', '%' ],
			]
		);
		$this->add_control(
			'listItems_groups',
			[
				'label' => esc_html__( 'Branches', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'list_text' => esc_html__( 'Sydney, Australia', 'restaurant-cafe-addon-for-elementor' ),
					],

				],
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ list_text }}}',
			]
		);

		$this->end_controls_section();// end: Section

		// Style
		// Tooltip
			$this->start_controls_section(
				'section_content_style',
				[
					'label' => esc_html__( 'Tooltip', 'restaurant-cafe-addon-for-elementor' ),
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
						'{{WRAPPER}} .narep-tooltip-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'tip_border',
					'label' => esc_html__( 'Border', 'restaurant-cafe-addon-for-elementor' ),
					'selector' => '{{WRAPPER}} .narep-tooltip-text',
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'tip_box_shadow',
					'label' => esc_html__( 'Box Shadow', 'restaurant-cafe-addon-for-elementor' ),
					'selector' => '{{WRAPPER}} .narep-tooltip-text',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Typography', 'restaurant-cafe-addon-for-elementor' ),
					'name' => 'tip_typography',
					'selector' => '{{WRAPPER}} .narep-tooltip-text',
				]
			);
			$this->add_control(
				'tip_color',
				[
					'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .narep-tooltip-text, {{WRAPPER}} .narep-tooltip-text a' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'tip_bg_color',
				[
					'label' => esc_html__( 'Background Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .narep-tooltip-text' => 'background-color: {{VALUE}};',
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
		$listItems_groups = !empty( $settings['listItems_groups'] ) ? $settings['listItems_groups'] : [];
		$map_image = !empty( $settings['map_image']['id'] ) ? $settings['map_image']['id'] : '';
		$image_url = wp_get_attachment_url( $map_image );

		$output = '<div class="narep-map-wrap">
							  <div class="narep-image"><img src="'.$image_url.'" alt="Global Branches"></div>
							  <div class="narep-map-locations">';
							  	// Group Param Output
										if( is_array( $listItems_groups ) && !empty( $listItems_groups ) ){
										  foreach ( $listItems_groups as $each_list ) {
											$list_text = $each_list['list_text'] ? $each_list['list_text'] : '';
											$text_link = !empty( $each_list['text_link'] ) ? $each_list['text_link'] : '';

											$link_url = !empty( $text_link['url'] ) ? esc_url($text_link['url']) : '';
											$link_external = !empty( $text_link['is_external'] ) ? 'target="_blank"' : '';
											$link_nofollow = !empty( $text_link['nofollow'] ) ? 'rel="nofollow"' : '';
											$link_attr = !empty( $text_link['url'] ) ?  $link_external.' '.$link_nofollow : '';

											$text = $link_url ? '<a href="'.esc_url($link_url).'" '.$link_attr.'>'.$list_text.'</a>' : $list_text;

											$icon_top = $each_list['icon_top']['size'] ? $each_list['icon_top']['size'] : '';
											$icon_top_unit = $each_list['icon_top']['unit'] ? $each_list['icon_top']['unit'] : '';
											$icon_left = $each_list['icon_left']['size'] ? $each_list['icon_left']['size'] : '';
											$icon_left_unit = $each_list['icon_left']['unit'] ? $each_list['icon_left']['unit'] : '';

											$top = $icon_top ? 'top: '.$icon_top.$icon_top_unit.';' : '';
											$left = $icon_left ? 'left: '.$icon_left.$icon_left_unit.';' : '';
											if ($icon_top || $icon_left) {
												$style = ' style="'.$top.$left.'"';
											} else {
												$style = '';
											}

										  $output .= '<div class="narep-location-item"'.$style.'>
															      <div class="narep-location-tooltip">
															      	<div class="narep-tooltip-text">'.$text.'</div>
															      </div>
															    </div>';
										  }
										}

	  $output .= '</div>
							</div>';

		echo $output;

	}

}
Plugin::instance()->widgets_manager->register_widget_type( new Restaurant_Elementor_Addon_Unique_Branches() );

} // enable & disable
