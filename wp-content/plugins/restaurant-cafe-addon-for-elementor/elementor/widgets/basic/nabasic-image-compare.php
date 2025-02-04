<?php
/*
 * Elementor Restaurant & Cafe Addon for Elementor Image Compare Widget
 * Author & Copyright: NicheAddon
*/

namespace Elementor;

if (!isset(get_option( 'rcafe_bw_settings' )['nbeds_image_compare'])) { // enable & disable

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Restaurant_Elementor_Addon_ImageCompare extends Widget_Base{

	/**
	 * Retrieve the widget name.
	*/
	public function get_name(){
		return 'narestaurant_basic_image_compare';
	}

	/**
	 * Retrieve the widget title.
	*/
	public function get_title(){
		return esc_html__( 'Image Compare', 'restaurant-cafe-addon-for-elementor' );
	}

	/**
	 * Retrieve the widget icon.
	*/
	public function get_icon() {
		return 'eicon-h-align-stretch';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	*/
	public function get_categories() {
		return ['narestaurant-basic-category'];
	}

	/**
	 * Register Restaurant & Cafe Addon for Elementor Image Compare widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	*/
	protected function _register_controls(){

		$this->start_controls_section(
			'section_list',
			[
				'label' => esc_html__( 'Image Compare Options', 'restaurant-cafe-addon-for-elementor' ),
			]
		);
		$this->add_control(
			'compare_style',
			[
				'label' => __( 'Image Compare Style', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'vertical' => esc_html__( 'Vertical', 'restaurant-cafe-addon-for-elementor' ),
					'horizontal' => esc_html__( 'Horizontal', 'restaurant-cafe-addon-for-elementor' ),
				],
				'default' => 'vertical',
			]
		);
		$this->add_control(
			'starting_position',
			[
				'label' => esc_html__( 'Starting Position', 'restaurant-cafe-addon-for-elementor' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 100,
				'step' => 1,
				'default' => 50,
				'description' => esc_html__( 'Set the starting position.', 'restaurant-cafe-addon-for-elementor' ),
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
		$this->start_controls_tabs( 'compare_images' );
			$this->start_controls_tab(
				'bimage',
				[
					'label' => esc_html__( 'Before', 'restaurant-cafe-addon-for-elementor' ),
				]
			);
			$this->add_control(
				'before_image',
				[
					'label' => esc_html__( 'Before Image', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::MEDIA,
					'frontend_available' => true,
					'default' => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'description' => esc_html__( 'Set your image.', 'restaurant-cafe-addon-for-elementor'),
				]
			);
			$this->add_control(
				'before_title',
				[
					'label' => esc_html__( 'Image Title', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::TEXT,
					'label_block' => true,
					'condition' => [
						'need_title' => 'true',
					],
				]
			);
			$this->end_controls_tab();  // end:Normal tab
			$this->start_controls_tab(
				'aimage',
				[
					'label' => esc_html__( 'After', 'restaurant-cafe-addon-for-elementor' ),
				]
			);
			$this->add_control(
				'after_image',
				[
					'label' => esc_html__( 'After Image', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::MEDIA,
					'frontend_available' => true,
					'default' => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'description' => esc_html__( 'Set your image.', 'restaurant-cafe-addon-for-elementor'),
				]
			);
			$this->add_control(
				'after_title',
				[
					'label' => esc_html__( 'Image Title', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::TEXT,
					'label_block' => true,
					'condition' => [
						'need_title' => 'true',
					],
				]
			);
			$this->end_controls_tab();  // end:Hover tab
		$this->end_controls_tabs(); // end tabs
		$this->end_controls_section();// end: Section

		// Icon
		$this->start_controls_section(
			'section_control_style',
			[
				'label' => esc_html__( 'Controls Style', 'restaurant-cafe-addon-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->start_controls_tabs( 'icon_style' );
			$this->start_controls_tab(
				'ico_normal',
				[
					'label' => esc_html__( 'Normal', 'restaurant-cafe-addon-for-elementor' ),
				]
			);
			$this->add_control(
				'licon_color',
				[
					'label' => esc_html__( 'Left/Top Icon Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} div.jx-arrow.jx-left' => 'border-color: transparent {{VALUE}} transparent transparent;',
						'{{WRAPPER}} .vertical div.jx-arrow.jx-left' => 'border-color: transparent transparent {{VALUE}} transparent;',
					],
				]
			);
			$this->add_control(
				'ricon_color',
				[
					'label' => esc_html__( 'Right/Bottom Icon Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} div.jx-arrow.jx-right' => 'border-color: transparent transparent transparent {{VALUE}};',
						'{{WRAPPER}} .vertical div.jx-arrow.jx-right' => 'border-color: {{VALUE}} transparent transparent transparent;',
					],
				]
			);
			$this->add_control(
				'line_bgcolor',
				[
					'label' => esc_html__( 'Line Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} div.jx-control' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'sline_bgcolor',
				[
					'label' => esc_html__( 'Small Line Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} div.jx-controller' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();  // end:Normal tab
			$this->start_controls_tab(
				'ico_hover',
				[
					'label' => esc_html__( 'Hover', 'restaurant-cafe-addon-for-elementor' ),
				]
			);
			$this->add_control(
				'licon_hover_color',
				[
					'label' => esc_html__( 'Left/Top Icon Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} div.jx-handle:hover div.jx-arrow.jx-left, {{WRAPPER}} div.jx-handle:active div.jx-arrow.jx-left' => 'border-color: transparent {{VALUE}} transparent transparent;',
						'{{WRAPPER}} .vertical div.jx-handle:hover div.jx-arrow.jx-left, {{WRAPPER}} .vertical div.jx-handle:active div.jx-arrow.jx-left' => 'border-color: transparent transparent {{VALUE}} transparent;',
					],
				]
			);
			$this->add_control(
				'ricon_hover_color',
				[
					'label' => esc_html__( 'Right/Bottom Icon Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} div.jx-handle:hover div.jx-arrow.jx-right, {{WRAPPER}} div.jx-handle:active div.jx-arrow.jx-right' => 'border-color: transparent transparent transparent {{VALUE}};',
						'{{WRAPPER}} .vertical div.jx-handle:hover div.jx-arrow.jx-right, {{WRAPPER}} .vertical div.jx-handle:active div.jx-arrow.jx-right' => 'border-color: {{VALUE}} transparent transparent transparent;',
					],
				]
			);
			$this->add_control(
				'line_hover_bgcolor',
				[
					'label' => esc_html__( 'Line Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} div.jx-handle:hover div.jx-control' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'sline_hover_bgcolor',
				[
					'label' => esc_html__( 'Small Line Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} div.jx-handle:hover div.jx-controller' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();  // end:Hover tab
		$this->end_controls_tabs(); // end tabs
		$this->end_controls_section();// end: Section

	}

	/**
	 * Render Image Compare widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	*/
	protected function render() {
	    $settings = $this->get_settings_for_display();
	    $compare_style = !empty($settings['compare_style']) ? $settings['compare_style'] : '';
	    $starting_position = !empty($settings['starting_position']) ? $settings['starting_position'] : '';
	    $need_title = !empty($settings['need_title']) ? $settings['need_title'] : '';
	    $title = $need_title ? 'true' : 'false';
	    
	    $before_image = !empty($settings['before_image']['id']) ? $settings['before_image']['id'] : '';
	    $before_url = wp_get_attachment_url($before_image);
	    $before_title = $settings['before_title'] ? $settings['before_title'] : '';
	    
	    $after_image = !empty($settings['after_image']['id']) ? $settings['after_image']['id'] : '';
	    $after_url = wp_get_attachment_url($after_image);
	    $after_title = $settings['after_title'] ? $settings['after_title'] : '';
	    
	    $compare_id = uniqid();
	    $id = rand(999, 9999);
	    $unique_class = 'compare-' . esc_attr($compare_id) . '-' . esc_attr($id);
	    ?>
	    
	    <div class="narep-compare-wrap">
	        <div class="narep-compare <?php echo esc_attr($unique_class); ?>"
	            data-before-url="<?php echo esc_url($before_url); ?>"
	            data-before-title="<?php echo esc_attr($before_title); ?>"
	            data-after-url="<?php echo esc_url($after_url); ?>"
	            data-after-title="<?php echo esc_attr($after_title); ?>"
	            data-show-labels="<?php echo esc_attr($title); ?>"
	            data-starting-position="<?php echo esc_attr($starting_position); ?>"
	            data-compare-style="<?php echo esc_attr($compare_style); ?>">
	        </div>
	    </div>
	    <?php
	}

}
Plugin::instance()->widgets_manager->register_widget_type( new Restaurant_Elementor_Addon_ImageCompare() );

} // enable & disable
