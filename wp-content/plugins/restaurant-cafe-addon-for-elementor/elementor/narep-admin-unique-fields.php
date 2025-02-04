<?php
// Unique widgets options
if ( ! function_exists( 'rcafe_unique_widgets_settings_init' ) ) {
  function rcafe_unique_widgets_settings_init() {
    $narep_unique_widgets = [];
    $narep_unique_widgets['benefits'] = array(
      'title' => __( 'Benefits', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/benefits-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-unique-elements/benefits/',
      'video_url' => '',
      'is_premium' => true,
    );
    $narep_unique_widgets['branches'] = array(
      'title' => __( 'Branches', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/branches-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-unique-elements/branches/',
      'video_url' => 'https://www.youtube.com/watch?v=HR0xfQuKLaI',
      'is_premium' => '',
    );
    $narep_unique_widgets['branch_slider'] = array(
      'title' => __( 'Branch Slider', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/branch-slider-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-unique-elements/branch-slider/',
      'video_url' => '',
      'is_premium' => true,
    );
    $narep_unique_widgets['chefs_recipe'] = array(
      'title' => __( 'Chefs Recipe', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/chefs-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-unique-elements/chefs-recipe/',
      'video_url' => 'https://www.youtube.com/watch?v=P0iVd6ZH-J4',
      'is_premium' => '',
    );
    $narep_unique_widgets['food_menu'] = array(
      'title' => __( 'Food Menu', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/product-food-menu/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-unique-elements/food-menu/',
      'video_url' => 'https://www.youtube.com/watch?v=ClCtpD7k4WM',
      'is_premium' => '',
    );
    $narep_unique_widgets['food_tab'] = array(
      'title' => __( 'Food Tab', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/food-tab-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-unique-elements/food-tab/',
      'video_url' => 'https://www.youtube.com/watch?v=iJZgmuoYVrc',
      'is_premium' => '',
    );
    $narep_unique_widgets['food_item'] = array(
      'title' => __( 'Food Item', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/food-item-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-unique-elements/food-item/',
      'video_url' => 'https://www.youtube.com/watch?v=hY5txWV6pe0',
      'is_premium' => '',
    );
    $narep_unique_widgets['gift_card'] = array(
      'title' => __( 'Gift Card', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/gift-card-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-unique-elements/gift-card/',
      'video_url' => '',
      'is_premium' => true,
    );
    $narep_unique_widgets['ingredients'] = array(
      'title' => __( 'Ingredients', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/ingredients-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-unique-elements/ingredients/',
      'video_url' => 'https://www.youtube.com/watch?v=00tUEnRfLJI',
      'is_premium' => '',
    );
    $narep_unique_widgets['image_parallax'] = array(
      'title' => __( 'Image Parallax', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/image-parallax-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-unique-elements/image-parallax/',
      'video_url' => 'https://www.youtube.com/watch?v=tuHBtRQqhOw',
      'is_premium' => true,
    );
    $narep_unique_widgets['layered_image'] = array(
      'title' => __( 'Layered Image', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/layered-image-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-unique-elements/layered-image/',
      'video_url' => '',
      'is_premium' => true,
    );
    $narep_unique_widgets['offers'] = array(
      'title' => __( 'Offers', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/offers-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-unique-elements/offers/',
      'video_url' => 'https://www.youtube.com/watch?v=yxjh-b3NUeY',
      'is_premium' => '',
    );
    $narep_unique_widgets['open_table'] = array(
      'title' => __( 'Open Table', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/open-table-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-unique-elements/open-table/',
      'video_url' => '',
      'is_premium' => true,
    );
    $narep_unique_widgets['particular_recipe'] = array(
      'title' => __( 'Particular Recipe', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/particular-recipe-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-unique-elements/particular-recipe/',
      'video_url' => '',
      'is_premium' => true,
    );
    $narep_unique_widgets['pricing'] = array(
      'title' => __( 'Pricing', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-unique-elements/pricing/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-unique-elements/pricing/',
      'video_url' => 'https://www.youtube.com/watch?v=1NvWZ9zyRyQ',
      'is_premium' => '',
    );
    $narep_unique_widgets['pricing_content'] = array(
      'title' => __( 'Pricing Content', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/pricing-element/',
      'documentation_url' => '',
      'video_url' => '',
      'is_premium' => '',
    );
    $narep_unique_widgets['pricing_tab'] = array(
      'title' => __( 'Pricing Tab', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/pricing-tab-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-unique-elements/pricing-tab/',
      'video_url' => '',
      'is_premium' => true,
    );
    $narep_unique_widgets['products_addon_menu'] = array(
      'title' => __( 'Products Addon Menu', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/product-addon-menu/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-unique-elements/addon-menu/',
      'video_url' => '',
      'is_premium' => '',
    );
    $narep_unique_widgets['products_filter'] = array(
      'title' => __( 'Products Filter', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/products-filter/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-unique-elements/products-filter/',
      'video_url' => '',
      'is_premium' => true,
    );
    $narep_unique_widgets['products_food_item'] = array(
      'title' => __( 'Products Food Item', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/product-food-item/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-unique-elements/product-food-item/',
      'video_url' => 'https://www.youtube.com/watch?v=hY5txWV6pe0',
      'is_premium' => true,
    );
    $narep_unique_widgets['products_food_menu'] = array(
      'title' => __( 'Products Food Menu', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/product-food-menu/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-unique-elements/product-food-menu/',
      'video_url' => 'https://www.youtube.com/watch?v=ClCtpD7k4WM',
      'is_premium' => true,
    );
    $narep_unique_widgets['food_banner'] = array(
      'title' => __( 'Food Banner', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/food-banner/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-unique-elements/food-banner/',
      'video_url' => 'https://www.youtube.com/watch?v=DLEiqEgKFSg',
      'is_premium' => true,
    );
    $narep_unique_widgets['restaurants'] = array(
      'title' => __( 'Restaurants', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/restaurants-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-unique-elements/restaurants/',
      'video_url' => '',
      'is_premium' => '',
    );
    $narep_unique_widgets['rooms'] = array(
      'title' => __( 'Rooms', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/rooms-slider-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-unique-elements/rooms/',
      'video_url' => 'https://www.youtube.com/watch?v=Yv5vXoYuqa0',
      'is_premium' => true,
    );
    $narep_unique_widgets['specialties'] = array(
      'title' => __( 'Specialties', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/specialties-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-unique-elements/specialties/',
      'video_url' => '',
      'is_premium' => '',
    );
    $narep_unique_widgets['stats'] = array(
      'title' => __( 'Stats', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/stats-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-unique-elements/stats/',
      'video_url' => '',
      'is_premium' => '',
    );
    $narep_unique_widgets['tab'] = array(
      'title' => __( 'Tab', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/food-tab-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-unique-elements/tab/',
      'video_url' => 'https://www.youtube.com/watch?v=iJZgmuoYVrc',
      'is_premium' => true,
    );
    $narep_unique_widgets['valuable_box'] = array(
      'title' => __( 'Valuable Box', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/valuable-box-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-unique-elements/valuable-box/',
      'video_url' => '',
      'is_premium' => '',
    );
    $narep_unique_widgets['working_hours'] = array(
      'title' => __( 'Working Hours', 'restaurant-cafe-addon-for-elementor' ),
      'demo_url' => 'https://nicheaddons.com/demos/restaurant/elements/working-hours-element/',
      'documentation_url' => 'https://nicheaddons.com/docs/restaurant-cafe-addon-unique-elements/working-hours/',
      'video_url' => 'https://www.youtube.com/watch?v=vurp2_ckac0',
      'is_premium' => '',
    );

    return $narep_unique_widgets;
  }
}