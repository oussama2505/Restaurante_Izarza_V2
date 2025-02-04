<?php
/*
 * Elementor Restaurant & Cafe Addon for Elementor Specialties Widget
 * Author & Copyright: NicheAddon
*/

namespace Elementor;

if (!isset(get_option( 'rcafe_uw_settings' )['nbeds_specialties'])) { // enable & disable

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Restaurant_Elementor_Addon_Unique_Specialties extends Widget_Base{

	/**
	 * Retrieve the widget name.
	*/
	public function get_name(){
		return 'narestaurant_unique_specialties';
	}

	/**
	 * Retrieve the widget title.
	*/
	public function get_title(){
		return esc_html__( 'Specialties', 'restaurant-cafe-addon-for-elementor' );
	}

	/**
	 * Retrieve the widget icon.
	*/
	public function get_icon() {
		return 'eicon-image-box';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	*/
	public function get_categories() {
		return ['narestaurant-unique-category'];
	}

	/**
	 * Register Restaurant & Cafe Addon for Elementor Specialties widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	*/
	protected function _register_controls(){

		$this->start_controls_section(
			'section_specialties',
			[
				'label' => __( 'Specialties Options', 'restaurant-cafe-addon-for-elementor' ),
			]
		);
		$this->add_control(
			'specialties_image',
			[
				'label' => esc_html__( 'Specialties Image', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::MEDIA,
				'frontend_available' => true,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'description' => esc_html__( 'Set your image.', 'restaurant-cafe-addon-for-elementor'),
			]
		);
		$this->add_control(
			'specialties_title',
			[
				'label' => esc_html__( 'Specialties Title', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Specialties', 'restaurant-cafe-addon-for-elementor' ),
				'placeholder' => esc_html__( 'Type title text here', 'restaurant-cafe-addon-for-elementor' ),
				'label_block' => true,
			]
		);
		$this->add_control(
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
		$this->add_control(
			'specialties_content',
			[
				'label' => esc_html__( 'Specialties Content', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Health care is the maintenance or improvement of health via the diagnosis, treatment, and prevention, injury etc.', 'restaurant-cafe-addon-for-elementor' ),
				'placeholder' => esc_html__( 'Type title text here', 'restaurant-cafe-addon-for-elementor' ),
				'label_block' => true,
			]
		);
		$repeater = new Repeater();
		$repeater->add_control(
			'list_text',
			[
				'label' => esc_html__( 'List Text', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Specialties', 'restaurant-cafe-addon-for-elementor' ),
				'placeholder' => esc_html__( 'Type title text here', 'restaurant-cafe-addon-for-elementor' ),
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
		$this->add_control(
			'listItems_groups',
			[
				'label' => esc_html__( 'List', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'list_text' => esc_html__( 'Specialties', 'restaurant-cafe-addon-for-elementor' ),
					],
				],
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ list_text }}}',
				'prevent_empty' => false,
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

		// Style
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
						'{{WRAPPER}} .narep-specialties-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'section_bg_color',
				[
					'label' => esc_html__( 'Background Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .narep-specialties-info' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'secn_border',
					'label' => esc_html__( 'Border', 'restaurant-cafe-addon-for-elementor' ),
					'selector' => '{{WRAPPER}} .narep-specialties-info',
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'section_box_shadow',
					'label' => esc_html__( 'Box Shadow', 'restaurant-cafe-addon-for-elementor' ),
					'selector' => '{{WRAPPER}} .narep-specialties-info',
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
						'{{WRAPPER}} .narep-specialties-info h4' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Typography', 'restaurant-cafe-addon-for-elementor' ),
					'name' => 'sastool_title_typography',
					'selector' => '{{WRAPPER}} .narep-specialties-info h4',
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
							'{{WRAPPER}} .narep-specialties-info h4, {{WRAPPER}} .narep-specialties-info h4 a' => 'color: {{VALUE}};',
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
							'{{WRAPPER}} .narep-specialties-info h4 a:hover' => 'color: {{VALUE}};',
						],
					]
				);
				$this->end_controls_tab();  // end:Hover tab
			$this->end_controls_tabs(); // end tabs
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
						'{{WRAPPER}} .narep-specialties-info p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Typography', 'restaurant-cafe-addon-for-elementor' ),
					'name' => 'sastool_content_typography',
					'selector' => '{{WRAPPER}} .narep-specialties-info p',
				]
			);
			$this->add_control(
				'content_color',
				[
					'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .narep-specialties-info p' => 'color: {{VALUE}};',
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
				'list_padding',
				[
					'label' => __( 'Padding', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .narep-bullet-list li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Typography', 'restaurant-cafe-addon-for-elementor' ),
					'name' => 'list_typography',
					'selector' => '{{WRAPPER}} .narep-bullet-list li',
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
							'{{WRAPPER}} .narep-bullet-list li, {{WRAPPER}} .narep-bullet-list li a' => 'color: {{VALUE}};',
						],
					]
				);
				$this->add_control(
					'icon_color',
					[
						'label' => esc_html__( 'Icon Color', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .narep-bullet-list li:before' => 'background-color: {{VALUE}};',
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
							'{{WRAPPER}} .narep-bullet-list li a:hover' => 'color: {{VALUE}};',
						],
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
		$specialties_image = !empty( $settings['specialties_image']['id'] ) ? $settings['specialties_image']['id'] : '';
		$image_url = wp_get_attachment_url( $specialties_image );
		$specialties_title = !empty( $settings['specialties_title'] ) ? $settings['specialties_title'] : '';
		$title_link = !empty( $settings['title_link']['url'] ) ? $settings['title_link']['url'] : '';
		$title_link_external = !empty( $settings['title_link']['is_external'] ) ? 'target="_blank"' : '';
		$title_link_nofollow = !empty( $settings['title_link']['nofollow'] ) ? 'rel="nofollow"' : '';
		$title_link_attr = !empty( $title_link ) ?  $title_link_external.' '.$title_link_nofollow : '';
		$specialties_content = !empty( $settings['specialties_content'] ) ? $settings['specialties_content'] : '';
		$toggle_align = !empty( $settings['toggle_align'] ) ? $settings['toggle_align'] : '';

		$listItems_groups = !empty( $settings['listItems_groups'] ) ? $settings['listItems_groups'] : '';

		$specialties_image = $image_url ? '<div class="narep-image"><img src="'.esc_url($image_url).'" alt="'.esc_attr($specialties_title).'"></div>' : '';
  	$title_link = !empty( $title_link ) ? '<a href="'.esc_url($title_link).'" '.$title_link_attr.'>'.esc_html($specialties_title).'</a>' : esc_html($specialties_title);
  	$title = !empty( $specialties_title ) ? '<h4 class="narep-specialties-title">'.$title_link.'</h4>' : '';
  	$content = !empty( $specialties_content ) ? '<p>'.$specialties_content.'</p>' : '';

		if ($toggle_align) {
			$f_cls = ' nich-order-1';
			$s_cls = ' nich-order-2';
		} else {
			$f_cls = '';
			$s_cls = '';
		}

		$output = '<div class="narep-specialties-item">
	              <div class="nich-row">
	                <div class="nich-col-md-12'.$s_cls.'">'.$specialties_image.'</div>
	                <div class="nich-col-md-12'.$f_cls.'">
	                  <div class="narep-specialties-info">
	                    '.$title.$content.'
	                    <ul class="narep-bullet-list">';
												if ( is_array( $listItems_groups ) && !empty( $listItems_groups ) ) {
												  foreach ( $listItems_groups as $each_list ) {
												  	$list_text = !empty( $each_list['list_text'] ) ? $each_list['list_text'] : '';
												  	$text_link = !empty( $each_list['text_link']['url'] ) ? $each_list['text_link']['url'] : '';
														$text_link_external = !empty( $each_list['text_link']['is_external'] ) ? 'target="_blank"' : '';
														$text_link_nofollow = !empty( $each_list['text_link']['nofollow'] ) ? 'rel="nofollow"' : '';
														$text_link_attr = !empty( $text_link ) ?  $text_link_external.' '.$text_link_nofollow : '';

												  	$text = $text_link ? '<li><a href="'.esc_url($text_link).'" '.$text_link_attr.'>'. esc_html($list_text) .'</a></li>' : '<li>'. esc_html($list_text) .'</li>';
				                  	$output .= $text;
					                }
					              }
          $output .= '</ul>
	                  </div>
	                </div>
	              </div>
	            </div>';
		echo $output;

	}

}
Plugin::instance()->widgets_manager->register_widget_type( new Restaurant_Elementor_Addon_Unique_Specialties() );

} // enable & disable
