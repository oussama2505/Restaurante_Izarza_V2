<?php

// Basic widgets options
if ( ! function_exists( 'rcafe_basic_widgets_settings_init' ) ) {
  function rcafe_basic_widgets_settings_init() {
    $narep_basic_widgets = [];
    $narep_basic_widgets['about_me'] = array(
      'title' => __( 'About Me', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/about-me-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-basic-elements/about-me/',
      'video_url' => 'https://www.youtube.com/watch?v=3gdawxxCM4g',
      'is_premium' => '',
    );
    $narep_basic_widgets['about_us'] = array(
      'title' => __( 'About Us', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/about-us-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-basic-elements/about-us/',
      'video_url' => '#0',
      'is_premium' => '',
    );
    $narep_basic_widgets['blog'] = array(
      'title' => __( 'Blog', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/blog-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-basic-elements/blog/',
      'video_url' => 'https://www.youtube.com/watch?v=10wK6r9POCg',
      'is_premium' => '',
    );
    $narep_basic_widgets['restaurant_button'] = array(
      'title' => __( 'Restaurant Button', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => '',
      'documentation_url' => '',
      'video_url' => '',
      'is_premium' => '',
    );
    $narep_basic_widgets['chart'] = array(
      'title' => __( 'Chart', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/chart-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-basic-elements/chart/',
      'video_url' => 'https://www.youtube.com/watch?v=jiM8vzUjd7w',
      'is_premium' => '',
    );
    $narep_basic_widgets['contact'] = array(
      'title' => __( 'Contact', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/contact-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-basic-elements/contact-details/',
      'video_url' => '',
      'is_premium' => '',
    );
    $narep_basic_widgets['gallery'] = array(
      'title' => __( 'Gallery', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/gallery-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-basic-elements/gallery/',
      'video_url' => '',
      'is_premium' => '',
    );
    $narep_basic_widgets['get_apps'] = array(
      'title' => __( 'Get Apps', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/get-apps-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-basic-elements/get-apps/',
      'video_url' => 'https://www.youtube.com/watch?v=-Z-tatGgOY0',
      'is_premium' => '',
    );
    $narep_basic_widgets['history'] = array(
      'title' => __( 'History', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/history-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-basic-elements/history/',
      'video_url' => 'https://www.youtube.com/watch?v=C9ilSEKq76g',
      'is_premium' => '',
    );
    $narep_basic_widgets['image_compare'] = array(
      'title' => __( 'Image Compare', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/image-compare-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-basic-elements/image-compare/',
      'video_url' => 'https://www.youtube.com/watch?v=6h4u-7bNzzI',
      'is_premium' => '',
    );
    $narep_basic_widgets['process'] = array(
      'title' => __( 'Process', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/process-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-basic-elements/process/',
      'video_url' => '',
      'is_premium' => '',
    );
    $narep_basic_widgets['section_title'] = array(
      'title' => __( 'Section Title', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => '',
      'documentation_url' => '',
      'video_url' => '',
      'is_premium' => '',
    );
    $narep_basic_widgets['separator'] = array(
      'title' => __( 'Separator', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/separator-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-basic-elements/separator/',
      'video_url' => '',
      'is_premium' => '',
    );
    $narep_basic_widgets['services'] = array(
      'title' => __( 'Services', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/service-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-basic-elements/services/',
      'video_url' => '',
      'is_premium' => '',
    );
    $narep_basic_widgets['slider'] = array(
      'title' => __( 'Slider', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/slider-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-basic-elements/slider/',
      'video_url' => 'https://www.youtube.com/watch?v=5flNe5UZuYY',
      'is_premium' => '',
    );
    $narep_basic_widgets['subscribe_contact'] = array(
      'title' => __( 'Subscribe / Contact', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/subscribe-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-basic-elements/subscribe/',
      'video_url' => 'https://www.youtube.com/watch?v=jHfFx9WlXck',
      'is_premium' => '',
    );
    $narep_basic_widgets['table'] = array(
      'title' => __( 'Table', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/table-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-basic-elements/table/',
      'video_url' => '',
      'is_premium' => '',
    );
    $narep_basic_widgets['team_single'] = array(
      'title' => __( 'Team Single', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/team-single-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-basic-elements/team/',
      'video_url' => 'https://www.youtube.com/watch?v=IX3o50X2e90',
      'is_premium' => '',
    );
    $narep_basic_widgets['team'] = array(
      'title' => __( 'Team', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/team-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-basic-elements/team-single/',
      'video_url' => 'https://www.youtube.com/watch?v=Kq_kL-Vomcc',
      'is_premium' => '',
    );
    $narep_basic_widgets['testimonials'] = array(
      'title' => __( 'Testimonials', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/testimonials-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-basic-elements/testimonial/',
      'video_url' => '',
      'is_premium' => '',
    );
    $narep_basic_widgets['typewriter'] = array(
      'title' => __( 'Typewriter', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/typewriter-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-basic-elements/typewriter/',
      'video_url' => '',
      'is_premium' => '',
    );
    $narep_basic_widgets['video'] = array(
      'title' => __( 'Video', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/video-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-basic-elements/video/',
      'video_url' => '',
      'is_premium' => '',
    );

    return $narep_basic_widgets;
  }
}