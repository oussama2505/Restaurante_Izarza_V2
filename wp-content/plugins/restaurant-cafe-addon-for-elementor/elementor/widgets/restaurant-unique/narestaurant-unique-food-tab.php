<?php
/*
 * Elementor Restaurant & Cafe Addon for Elementor Food Tab Widget
 * Author & Copyright: NicheAddon
*/

namespace Elementor;

if (!isset(get_option( 'rcafe_uw_settings' )['nbeds_food_tab'])) { // enable & disable

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Restaurant_Elementor_Addon_Unique_FoodTab extends Widget_Base{

	/**
	 * Retrieve the widget name.
	*/
	public function get_name(){
		return 'narestaurant_unique_foodtab';
	}

	/**
	 * Retrieve the widget title.
	*/
	public function get_title(){
		return esc_html__( 'Food Tab', 'restaurant-cafe-addon-for-elementor' );
	}

	/**
	 * Retrieve the widget icon.
	*/
	public function get_icon() {
		return 'eicon-tabs';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	*/
	public function get_categories() {
		return ['narestaurant-unique-category'];
	}

	/**
	 * Register Restaurant & Cafe Addon for Elementor Food Tab widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	*/
	protected function _register_controls(){

		$this->start_controls_section(
			'section_foodtab',
			[
				'label' => __( 'Food Tab Options', 'restaurant-cafe-addon-for-elementor' ),
			]
		);
		$this->add_control(
			'fod_tab_title',
			[
				'label' => esc_html__( 'Food Tab Title', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Tasty and Crunchy', 'restaurant-cafe-addon-for-elementor' ),
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
		$repeater = new Repeater();
		$repeater->add_control(
			'tab_id',
			[
				'label' => esc_html__( 'Tab ID', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter Tab ID', 'restaurant-cafe-addon-for-elementor' ),
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'fod_tab_image',
			[
				'label' => esc_html__( 'Food Tab Image', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::MEDIA,
				'frontend_available' => true,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'description' => esc_html__( 'Set your image.', 'restaurant-cafe-addon-for-elementor'),
			]
		);
		$repeater->add_control(
			'list_icon',
			[
				'label' => esc_html__( 'List Icon', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::ICON,
				'options' => NAREP_Controls_Helper_Output::get_include_icons(),
				'frontend_available' => true,
				'default' => 'icofont-chicken',
			]
		);
		$repeater->add_control(
			'list_text',
			[
				'label' => esc_html__( 'List Title', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Chicken Tagliatelle', 'restaurant-cafe-addon-for-elementor' ),
				'placeholder' => esc_html__( 'Type title text here', 'restaurant-cafe-addon-for-elementor' ),
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
		$this->add_control(
			'listItems_groups',
			[
				'label' => esc_html__( 'Food List', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::REPEATER,
				'default' => [
					[
						'list_text' => esc_html__( 'Chicken Tagliatelle', 'restaurant-cafe-addon-for-elementor' ),
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

		// Count
			$this->start_controls_section(
				'section_count_style',
				[
					'label' => esc_html__( 'Count', 'restaurant-cafe-addon-for-elementor' ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'count_padding',
				[
					'label' => __( 'Padding', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px' ],
					'selectors' => [
						'{{WRAPPER}} .narep-fod-tab-info h2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Typography', 'restaurant-cafe-addon-for-elementor' ),
					'name' => 'sastool_count_typography',
					'selector' => '{{WRAPPER}} .narep-fod-tab-info h2',
				]
			);
			$this->add_control(
				'count_color',
				[
					'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .narep-fod-tab-info h2' => 'color: {{VALUE}};',
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
						'{{WRAPPER}} .narep-fod-tab-info h3' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Typography', 'restaurant-cafe-addon-for-elementor' ),
					'name' => 'sastool_title_typography',
					'selector' => '{{WRAPPER}} .narep-fod-tab-info h3',
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
							'{{WRAPPER}} .narep-fod-tab-info h3, {{WRAPPER}} .narep-fod-tab-info h3 a' => 'color: {{VALUE}};',
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
							'{{WRAPPER}} .narep-fod-tab-info h3 a:hover' => 'color: {{VALUE}};',
						],
					]
				);
				$this->end_controls_tab();  // end:Hover tab
			$this->end_controls_tabs(); // end tabs
			$this->end_controls_section();// end: Section

		// List
			$this->start_controls_section(
				'section_box_style',
				[
					'label' => esc_html__( 'List', 'restaurant-cafe-addon-for-elementor' ),
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
						'{{WRAPPER}} .narep-fod-tab-info-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'section_bg_color',
				[
					'label' => esc_html__( 'Background Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .narep-fod-tab-info-item' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'section_line_color',
				[
					'label' => esc_html__( 'Line Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .narep-fod-tab-info-item:after' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'secn_border',
					'label' => esc_html__( 'Border', 'restaurant-cafe-addon-for-elementor' ),
					'selector' => '{{WRAPPER}} .narep-fod-tab-info-item',
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'section_box_shadow',
					'label' => esc_html__( 'Box Shadow', 'restaurant-cafe-addon-for-elementor' ),
					'selector' => '{{WRAPPER}} .narep-fod-tab-info-item',
				]
			);
			$this->end_controls_section();// end: Section

		// List Title
			$this->start_controls_section(
				'section_list_style',
				[
					'label' => esc_html__( 'List Title', 'restaurant-cafe-addon-for-elementor' ),
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
						'{{WRAPPER}} .narep-fod-tab-item-info h4' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Typography', 'restaurant-cafe-addon-for-elementor' ),
					'name' => 'list_typography',
					'selector' => '{{WRAPPER}} .narep-fod-tab-item-info h4',
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
							'{{WRAPPER}} .narep-fod-tab-item-info h4, {{WRAPPER}} .narep-fod-tab-item-info h4 a' => 'color: {{VALUE}};',
						],
					]
				);
				$this->add_control(
					'icon_color',
					[
						'label' => esc_html__( 'Icon Color', 'restaurant-cafe-addon-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .narep-fod-tab-info-item i' => 'color: {{VALUE}};',
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
							'{{WRAPPER}} .narep-fod-tab-item-info h4 a:hover' => 'color: {{VALUE}};',
						],
					]
				);
				$this->end_controls_tab();  // end:Hover tab
			$this->end_controls_tabs(); // end tabs
			$this->end_controls_section();// end: Section

		// List Content
			$this->start_controls_section(
				'section_content_style',
				[
					'label' => esc_html__( 'List Content', 'restaurant-cafe-addon-for-elementor' ),
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
						'{{WRAPPER}} .narep-fod-tab-info p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label' => esc_html__( 'Typography', 'restaurant-cafe-addon-for-elementor' ),
					'name' => 'sastool_content_typography',
					'selector' => '{{WRAPPER}} .narep-fod-tab-info p',
				]
			);
			$this->add_control(
				'content_color',
				[
					'label' => esc_html__( 'Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .narep-fod-tab-info p' => 'color: {{VALUE}};',
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
		$fod_tab_title = !empty( $settings['fod_tab_title'] ) ? $settings['fod_tab_title'] : '';
		$title_link = !empty( $settings['title_link']['url'] ) ? $settings['title_link']['url'] : '';
		$title_link_external = !empty( $settings['title_link']['is_external'] ) ? 'target="_blank"' : '';
		$title_link_nofollow = !empty( $settings['title_link']['nofollow'] ) ? 'rel="nofollow"' : '';
		$title_link_attr = !empty( $title_link ) ?  $title_link_external.' '.$title_link_nofollow : '';
		$toggle_align = !empty( $settings['toggle_align'] ) ? $settings['toggle_align'] : '';

		$listItems_groups = !empty( $settings['listItems_groups'] ) ? $settings['listItems_groups'] : '';

  	$title_link = !empty( $title_link ) ? '<a href="'.esc_url($title_link).'" '.$title_link_attr.'>'.esc_html($fod_tab_title).'</a>' : esc_html($fod_tab_title);
  	$title = !empty( $fod_tab_title ) ? '<h3 class="narep-fod-tab-title">'.$title_link.'</h3>' : '';

		if ($toggle_align) {
			$f_cls = ' nich-order-1';
			$s_cls = ' nich-order-2';
			$toggle_cls = ' toggle-align';
		} else {
			$f_cls = '';
			$s_cls = '';
			$toggle_cls = '';
		}

		$output = '<div class="narep-fod-tab-item'.$toggle_cls.'">
			          <div class="nich-row nich-align-items-center">
			            <div class="nich-col-lg-6'.$s_cls.'"><div class="narep-tab-food">';
									$key = 1;
			            foreach ( $listItems_groups as $each_list ) {
										$tab_id = !empty( $each_list['tab_id'] ) ? $each_list['tab_id'] : '';
										$fod_tab_image = !empty( $each_list['fod_tab_image']['id'] ) ? $each_list['fod_tab_image']['id'] : '';
										$image_url = wp_get_attachment_url( $fod_tab_image );
								  	$list_text = !empty( $each_list['list_text'] ) ? $each_list['list_text'] : '';

										$active_cls = ( $key == 1 ) ? ' active' : '';
										$id = $tab_id ? sanitize_title($tab_id) : sanitize_title($list_text);
										$fod_tab_image = $image_url ? '<div class="narep-image"><img src="'.esc_url($image_url).'" alt="'.esc_attr($list_text).'"></div>' : '';

                  	$output .= '<div class="narep-tab-img'.$active_cls.'" id="narep-'.$key.$id.'">'.$fod_tab_image.'</div>';
									$key++;
	                }
			            $output .= '</div></div>
			            <div class="nich-col-lg-6'.$f_cls.'">
			              <div class="narep-fod-tab-info">
			                <div class="narep-fod-tab-main-title"><div class="narep-tab-food narep-food-num">';
											$key = 1;
					            foreach ( $listItems_groups as $each_list ) {
												$tab_id = !empty( $each_list['tab_id'] ) ? $each_list['tab_id'] : '';
								  			$list_text = !empty( $each_list['list_text'] ) ? $each_list['list_text'] : '';
												$active_cls = ( $key == 1 ) ? ' active' : '';
												$id = $tab_id ? sanitize_title($tab_id) : sanitize_title($list_text);
												if ($key >= 10) {
													$count = $key;
												} else {
													$count = '0'.$key;
												}
		                  	$output .= '<div class="narep-tab-img'.$active_cls.'" id="narep-'.$key.$id.'"><h2 class="narep-fod-tab-counter">'.$count.'</h2></div>';
											$key++;
			                }
					            $output .= '</div>'.$title.'</div>
			                <div class="narep-food-tab">';
												if ( is_array( $listItems_groups ) && !empty( $listItems_groups ) ) {
	      									$key = 1;
												  foreach ( $listItems_groups as $each_list ) {
														$tab_id = !empty( $each_list['tab_id'] ) ? $each_list['tab_id'] : '';
												  	$list_icon = !empty( $each_list['list_icon'] ) ? $each_list['list_icon'] : '';
												  	$list_text = !empty( $each_list['list_text'] ) ? $each_list['list_text'] : '';
												  	$list_content = !empty( $each_list['list_content'] ) ? $each_list['list_content'] : '';

  													$list_title = !empty( $list_text ) ? '<h4 class="narep-fod-tab-info-title">'.$list_text.'</h4>' : '';
  													$list_content = !empty( $list_content ) ? '<p>'.$list_content.'</p>' : '';
  													$list_icon = $list_icon ? '<div class="narep-icon"><i class="'.esc_attr($list_icon).'"></i></div>' : '';
														$active_cls = ( $key == 1 ) ? ' class="active"' : '';
														$id = $tab_id ? sanitize_title($tab_id) : sanitize_title($list_text);

				                  	$output .= '<a href="#narep-'.$key.$id.'"'.$active_cls.'>
					                  							<div class="narep-fod-tab-info-item">
													                  '.$list_icon.'
													                  <div class="narep-fod-tab-item-info">
													                    '.$list_title.$list_content.'
													                  </div>
													                </div>
												                </a>';
													$key++;
					                }
					              }
        	$output .= '</div>
      							</div>
			            </div>
			          </div>
			        </div>';
		echo $output;

	}

}
Plugin::instance()->widgets_manager->register_widget_type( new Restaurant_Elementor_Addon_Unique_FoodTab() );

} // enable & disable
