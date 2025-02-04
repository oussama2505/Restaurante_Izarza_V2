<?php
/*
 * Elementor Restaurant & Cafe Addon for Elementor Chart Widget
 * Author & Copyright: NicheAddon
*/

namespace Elementor;

if (!isset(get_option( 'rcafe_bw_settings' )['nbeds_chart'])) { // enable & disable

// Only for premium users
if ( rcafe_fs()->is_free_plan() ) {

	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	class Restaurant_Elementor_Addon_Chart extends Widget_Base{

		/**
		 * Retrieve the widget name.
		*/
		public function get_name(){
			return 'narestaurant_basic_chart';
		}

		/**
		 * Retrieve the widget title.
		*/
		public function get_title(){
			return esc_html__( 'Chart', 'restaurant-cafe-addon-for-elementor' );
		}

		/**
		 * Retrieve the widget icon.
		*/
		public function get_icon() {
			return 'eicon-integration';
		}

		/**
		 * Retrieve the list of categories the widget belongs to.
		*/
		public function get_categories() {
			return ['narestaurant-basic-category'];
		}

		/**
		 * Register Restaurant & Cafe Addon for Elementor Chart widget controls.
		 * Adds different input fields to allow the user to change and customize the widget settings.
		*/
		protected function _register_controls(){

			$this->start_controls_section(
				'section_chart',
				[
					'label' => __( 'Chart Global Options', 'restaurant-cafe-addon-for-elementor' ),
				]
			);

			// Common For All
			$this->add_control(
				'chart_type',
				[
					'label' => __( 'Chart Type', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'bar' => __( 'Bar', 'restaurant-cafe-addon-for-elementor' ),
						'pie' => __( 'PIE', 'restaurant-cafe-addon-for-elementor' ),
					],
					'default' => 'bar',
				]
			);
			$this->add_control(
				'opt_legend',
				[
					'label' => __( 'Show Legend?', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::SWITCHER,
					'default' => 'no',
					'label_on' => __( 'Yes', 'restaurant-cafe-addon-for-elementor' ),
					'label_off' => __( 'No', 'restaurant-cafe-addon-for-elementor' ),
				]
			);
			$this->add_control(
				'opt_legend_pos',
				[
					'label' => __( 'Legend Position', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'left' => __( 'Left', 'restaurant-cafe-addon-for-elementor' ),
						'right' => __( 'Right', 'restaurant-cafe-addon-for-elementor' ),
						'top' => __( 'Top', 'restaurant-cafe-addon-for-elementor' ),
						'bottom' => __( 'Bottom', 'restaurant-cafe-addon-for-elementor' ),
					],
					'default' => 'right',
					'condition' => [
						'opt_legend' => 'yes',
					],
				]
			);
			$this->add_control(
				'horizontal_bar',
				[
					'label' => __( 'Show Values in Horizontal Mode?', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::SWITCHER,
					'default' => 'no',
					'label_on' => __( 'Yes', 'restaurant-cafe-addon-for-elementor' ),
					'label_off' => __( 'No', 'restaurant-cafe-addon-for-elementor' ),
					'condition' => [
						'chart_type' => 'bar',
					],
				]
			);
			// Height
			$this->add_control(
				'n_wi_he',
				[
					'label' => __( 'Width & Height', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
	      'canvas_width',
	      [
	        'label' => __( 'Width', 'restaurant-cafe-addon-for-elementor' ),
	        'type' => Controls_Manager::SLIDER,
	        'range' => [
						'px' => [
							'min' => 300,
							'max' => 1000,
						],
					],
	        'selectors' => [
						'{{WRAPPER}} .narep-chart' => 'width: {{SIZE}}{{UNIT}};',
					],
	      ]
	    );
	    $this->add_control(
	      'canvas_height',
	      [
	        'label' => __( 'Height', 'restaurant-cafe-addon-for-elementor' ),
	        'type' => Controls_Manager::SLIDER,
	        'range' => [
						'px' => [
							'min' => 300,
							'max' => 1000,
						],
					],
					'default' => [
						'size' => 450,
					],
	        'selectors' => [
						'{{WRAPPER}} .narep-chart' => 'height: {{SIZE}}{{UNIT}};',
					],
	      ]
	    );
	    // Chart Values
	    $this->add_control(
				'n_ch_va',
				[
					'label' => __( 'Chart Values', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'x_values',
				[
					'label' => __( 'Chart X-Axis/Label Values', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::TEXTAREA,
					'default' => __( 'January; February; March; April; May; June', 'restaurant-cafe-addon-for-elementor' ),
					'placeholder' => __( 'January; February; ...', 'restaurant-cafe-addon-for-elementor' ),
					'condition' => [
	          'chart_type' => [ 'bar' ],
	        ],
				]
			);
			$this->add_control(
				'max_value',
				[
					'label' => __( 'Maximum Value', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::NUMBER,
					'default' => 100,
					'max' => 500,
					'step' => 1,
					'condition' => [
	          'chart_type' => [ 'bar' ],
	        ],
				]
			);
			$this->add_control(
				'min_value',
				[
					'label' => __( 'Minimum Value', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::NUMBER,
					'default' => 20,
					'max' => 500,
					'step' => 1,
					'condition' => [
	          'chart_type' => [ 'bar' ],
	        ],
				]
			);
			$this->add_control(
				'step_value',
				[
					'label' => __( 'Each Step Gap', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::NUMBER,
					'default' => 20,
					'max' => 500,
					'step' => 1,
					'condition' => [
	          'chart_type' => [ 'bar' ],
	        ],
				]
			);
			$this->add_control(
				'hidex_gridlines',
				[
					'label' => __( 'Hide X-Axis Grid Lines?', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::SWITCHER,
					'default' => 'no',
					'label_on' => __( 'Yes', 'restaurant-cafe-addon-for-elementor' ),
					'label_off' => __( 'No', 'restaurant-cafe-addon-for-elementor' ),
					'condition' => [
	          'chart_type' => [ 'bar' ],
	        ],
				]
			);
			$this->add_control(
				'hidey_gridlines',
				[
					'label' => __( 'Hide Y-Axis Grid Lines?', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::SWITCHER,
					'default' => 'no',
					'label_on' => __( 'Yes', 'restaurant-cafe-addon-for-elementor' ),
					'label_off' => __( 'No', 'restaurant-cafe-addon-for-elementor' ),
					'condition' => [
	          'chart_type' => [ 'bar' ],
	        ],
				]
			);

			$this->end_controls_section();// end: Section

			$this->start_controls_section(
				'section_chart_one',
				[
					'label' => __( 'Chart Item Values', 'restaurant-cafe-addon-for-elementor' ),
					'condition' => [
	          'chart_type' => [ 'bar' ],
	        ],
				]
			);

			$repeater = new Repeater();
			$repeater->add_control(
				'chart_title',
				[
					'label' => esc_html__( 'Title', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'Stocks', 'restaurant-cafe-addon-for-elementor' ),
					'placeholder' => esc_html__( 'Type title text here', 'restaurant-cafe-addon-for-elementor' ),
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'y_values',
				[
					'label' => esc_html__( 'Y Values', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::TEXT,
					'default' => __( '20; 30; 75; 40; 60; 45', 'restaurant-cafe-addon-for-elementor' ),
					'placeholder' => __( '20; 30; ...', 'restaurant-cafe-addon-for-elementor' ),
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'bg_color',
				[
					'label' => esc_html__( 'Background Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#8d6dc4',
				]
			);
			$repeater->add_control(
				'point_color',
				[
					'label' => esc_html__( 'Point Background Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#ffffff',
				]
			);
			$repeater->add_control(
				'border_color',
				[
					'label' => esc_html__( 'Border Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#00bfa5',
				]
			);
			$repeater->add_control(
				'point_border_color',
				[
					'label' => esc_html__( 'Point Border Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#00bfa5',
				]
			);
			// Size
			$repeater->add_control(
				'point_width',
				[
					'label' => esc_html__( 'Point Border Width', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::NUMBER,
					'default' => 2,
					'max' => 50,
					'step' => 1,
				]
			);
			$repeater->add_control(
				'border_width',
				[
					'label' => esc_html__( 'Border Width', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::NUMBER,
					'default' => 1,
					'max' => 50,
					'step' => 1,
				]
			);
			$repeater->add_control(
				'point_radius',
				[
					'label' => esc_html__( 'Point Radius', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::NUMBER,
					'default' => 4,
					'max' => 50,
					'step' => 1,
				]
			);
			$repeater->add_control(
				'point_hover_radius',
				[
					'label' => esc_html__( 'Point Hover Radius', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::NUMBER,
					'default' => 4,
					'max' => 50,
					'step' => 1,
				]
			);
			$this->add_control(
				'line_values',
				[
					'label' => esc_html__( 'Chart Items', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::REPEATER,
					'default' => [
						[
							'chart_title' => esc_html__( 'One', 'restaurant-cafe-addon-for-elementor' ),
							'y_values'    => __( '20; 90; 75; 40; 60; 33', 'restaurant-cafe-addon-for-elementor' ),
							'bg_color' 	  => 'rgba(234,67,53,0.5)',
							'border_color' => '#ea4335',
							'point_border_color' => '#ea4335',
						],
						[
							'chart_title' => esc_html__( 'Two', 'restaurant-cafe-addon-for-elementor' ),
							'y_values'    => __( '20; 50; 35; 80; 20; 95', 'restaurant-cafe-addon-for-elementor' ),
							'bg_color' 	  => 'rgba(66,133,244,0.5)',
							'border_color' => '#4285f4',
							'point_border_color' => '#4285f4',
						],
						[
							'chart_title' => esc_html__( 'Three', 'restaurant-cafe-addon-for-elementor' ),
							'y_values'    => __( '50; 20; 95; 60; 40; 20', 'restaurant-cafe-addon-for-elementor' ),
							'bg_color' 	  => 'rgba(251,188,5,0.5)',
							'border_color' => '#fbbc05',
							'point_border_color' => '#fbbc05',
						],
						[
							'chart_title' => esc_html__( 'Four', 'restaurant-cafe-addon-for-elementor' ),
							'y_values'    => __( '90; 70; 25; 90; 30; 50', 'restaurant-cafe-addon-for-elementor' ),
							'bg_color' 	  => 'rgba(52,168,83,0.5)',
							'border_color' => '#34a853',
							'point_border_color' => '#34a853',
						],
					],
					'fields' => $repeater->get_controls(),
					'title_field' => '{{{ chart_title }}}',
				]
			);

			$this->end_controls_section();// end: Section

			$this->start_controls_section(
				'section_chart_two',
				[
					'label' => __( 'Chart Item Values', 'restaurant-cafe-addon-for-elementor' ),
					'condition' => [
	          'chart_type' => [ 'pie' ],
	        ],
				]
			);

			$repeater_one = new Repeater();
			$repeater_one->add_control(
				'chart_title',
				[
					'label' => esc_html__( 'Title', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::TEXT,
					'default' => esc_html__( 'Red', 'restaurant-cafe-addon-for-elementor' ),
					'placeholder' => esc_html__( 'Type title text here', 'restaurant-cafe-addon-for-elementor' ),
					'label_block' => true,
				]
			);
			$repeater_one->add_control(
				'values',
				[
					'label' => esc_html__( 'Values', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::TEXT,
					'default' => __( '25', 'restaurant-cafe-addon-for-elementor' ),
					'placeholder' => __( '25', 'restaurant-cafe-addon-for-elementor' ),
					'label_block' => true,
				]
			);
			$repeater_one->add_control(
				'bg_color',
				[
					'label' => esc_html__( 'Background Color', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'default' => '#ea4335',
				]
			);

			$this->add_control(
				'circle_values',
				[
					'label' => esc_html__( 'Chart Items', 'restaurant-cafe-addon-for-elementor' ),
					'type' => Controls_Manager::REPEATER,
					'default' => [
						[
							'chart_title' => esc_html__( 'Red', 'restaurant-cafe-addon-for-elementor' ),
							'bg_color' => '#ea4335',
						],
						[
							'chart_title' => esc_html__( 'Blue', 'restaurant-cafe-addon-for-elementor' ),
							'bg_color' => '#4285f4',
						],
						[
							'chart_title' => esc_html__( 'Yellow', 'restaurant-cafe-addon-for-elementor' ),
							'bg_color' => '#fbbc05',
						],
						[
							'chart_title' => esc_html__( 'Green', 'restaurant-cafe-addon-for-elementor' ),
							'bg_color' => '#34a853',
						],
					],
					'fields' => $repeater_one->get_controls(),
					'title_field' => '{{{ chart_title }}}',
				]
			);

			$this->end_controls_section();// end: Section

		}
		/**
		 * Render Chart widget output on the frontend.
		 * Written in PHP and used to generate the final HTML.
		*/
		protected function render() {

            $settings = $this->get_settings_for_display();

            $chart_type = !empty( $settings['chart_type'] ) ? $settings['chart_type'] : '';
            $opt_legend = ( isset( $settings['opt_legend'] ) && ( 'yes' == $settings['opt_legend'] ) ) ? 'true' : 'false';
            $opt_legend_pos = !empty( $settings['opt_legend_pos'] ) ? $settings['opt_legend_pos'] : '';
            $horizontal_bar = ( isset( $settings['horizontal_bar'] ) && ( 'yes' == $settings['horizontal_bar'] ) ) ? 'true' : 'false';
            $x_values = !empty( $settings['x_values'] ) ? $settings['x_values'] : '';
            $max_value = !empty( $settings['max_value'] ) ? $settings['max_value'] : '';
            $min_value = !empty( $settings['min_value'] ) ? $settings['min_value'] : '';
            $hidex_gridlines = ( isset( $settings['hidex_gridlines'] ) && ( 'yes' == $settings['hidex_gridlines'] ) ) ? 'true' : 'false';
            $hidey_gridlines = ( isset( $settings['hidey_gridlines'] ) && ( 'yes' == $settings['hidey_gridlines'] ) ) ? 'true' : 'false';
            $step_value = !empty( $settings['step_value'] ) ? $settings['step_value'] : '';

            // Unique ID
            $chart_uniqid = uniqid( 'chart_' );

            // X Values
            $x_values = explode( ';', trim( $x_values, ';' ) );

            // Param Group Values
            $line_values = !empty( $settings['line_values'] ) ? $settings['line_values'] : [];
            $circle_values = !empty( $settings['circle_values'] ) ? $settings['circle_values'] : [];

            // Prepare data for JSON encoding
            $chart_data = [
                'type' => $chart_type,
                'labels' => $x_values,
                'datasets' => [],
                'options' => [
                    'legend' => [
                        'display' => $opt_legend,
                        'position' => $opt_legend_pos
                    ],
                    'horizontalBar' => $horizontal_bar,
                    'scales' => [
                        'yAxes' => [[
                            'ticks' => [
                                'max' => $max_value,
                                'min' => $min_value,
                                'stepSize' => $step_value
                            ],
                            'gridLines' => [
                                'display' => !$hidey_gridlines
                            ]
                        ]],
                        'xAxes' => [[
                            'gridLines' => [
                                'display' => !$hidex_gridlines
                            ]
                        ]]
                    ]
                ]
            ];

            if ($chart_type !== 'pie') {
                foreach ($line_values as $value) {
                    $chart_data['datasets'][] = [
                        'label' => isset($value['chart_title']) ? $value['chart_title'] : '',
                        'data' => explode(';', isset($value['y_values']) ? trim($value['y_values'], ';') : ''),
                        'borderColor' => $value['border_color'],
                        'pointBorderColor' => $value['point_border_color'],
                        'pointBackgroundColor' => $value['point_color'],
                        'backgroundColor' => $value['bg_color'],
                        'borderWidth' => isset($value['border_width']) ? $value['border_width'] : '1',
                        'pointBorderWidth' => isset($value['point_width']) ? $value['point_width'] : '2',
                        'pointRadius' => isset($value['point_radius']) ? $value['point_radius'] : '4',
                        'pointHoverRadius' => isset($value['point_hover_radius']) ? $value['point_hover_radius'] : '4',
                    ];
                }
            } else {
                $chart_data['datasets'][] = [
                    'data' => array_column($circle_values, 'values'),
                    'backgroundColor' => array_column($circle_values, 'bg_color'),
                    'borderWidth' => [4, 4, 4]
                ];
                $chart_data['labels'] = array_column($circle_values, 'chart_title');
            }

            // Encode the data for the data attribute
            $chart_data_json = json_encode($chart_data);

            // Output the canvas with data attribute
            echo '<div class="narep-chart"><canvas id="' . esc_attr($chart_uniqid) . '" data-chart=\'' . esc_attr($chart_data_json) . '\'></canvas></div>';			

		}
	}
	Plugin::instance()->widgets_manager->register_widget_type( new Restaurant_Elementor_Addon_Chart() );

} // is_free

} // enable & disable
