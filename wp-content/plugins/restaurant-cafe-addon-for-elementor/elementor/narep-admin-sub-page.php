<?php
// Output on Admin Page
if ( ! function_exists( 'narep_admin_sub_page' ) ) {
  function narep_admin_sub_page() { ?>
    <?php 
      $rcafe_bw_settings  = get_option('rcafe_bw_settings') ? get_option('rcafe_bw_settings') : [];
      $rcafe_uw_settings  = get_option('rcafe_uw_settings') ? get_option('rcafe_uw_settings') : [];
      $rcafe_bw_toggle    = get_option('rcafe_bw_toggle') ? get_option('rcafe_bw_toggle') : 0;
      $rcafe_uw_toggle    = get_option('rcafe_uw_toggle') ? get_option('rcafe_uw_toggle') : 0;
    ?>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="//fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <div class="narep-admin-options narep-container">

      <div class="mb-4 mt-4">
        <h1>Welcome to the <strong>Restaurant &amp; Cafe Addon for Elementor</strong></h1>
        <p class="lead">Restaurant & Cafe Addon for Elementor covers all the must-needed elements for creating a perfect Restaurant website using Elementor Page Builder. 35+ Unique & Basic Elementor widget covers all of the Restaurant elements.</p>
      </div>

      <div class="narep-row">
        <div class="narep-col-8">
          <div class="narep-row align-items-center">
            <div class="narep-col-6">
              <div class="d-flex align-items-center narep-logo-wrapper">
                <img src="<?php echo NAREP_URL . 'assets/images/logo.png'; ?>" alt="logo" class="narep-logo">
                <span>
                  by <a href="https://nicheaddons.com/" target="_blank"><strong>Nichaddons</strong></a> / Version: <?php echo NAREP_VERSION; ?>
                </span>
              </div>
            </div>
            <div class="narep-col-6">
              <div class="d-flex justify-content-end">
                <div class="narep-search-widget-holder">
                  <svg class="narep-search-widget-icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" viewBox="0 0 20 20"><path d="M18.869 19.162l-5.943-6.484c1.339-1.401 2.075-3.233 2.075-5.178 0-2.003-0.78-3.887-2.197-5.303s-3.3-2.197-5.303-2.197-3.887 0.78-5.303 2.197-2.197 3.3-2.197 5.303 0.78 3.887 2.197 5.303 3.3 2.197 5.303 2.197c1.726 0 3.362-0.579 4.688-1.645l5.943 6.483c0.099 0.108 0.233 0.162 0.369 0.162 0.121 0 0.242-0.043 0.338-0.131 0.204-0.187 0.217-0.503 0.031-0.706zM1 7.5c0-3.584 2.916-6.5 6.5-6.5s6.5 2.916 6.5 6.5-2.916 6.5-6.5 6.5-6.5-2.916-6.5-6.5z"></path></svg>
                  <input class="narep-search-widget-field narep-input" value="" placeholder="Search widgets">
                </div>
              </div>
            </div>
          </div>

          <!-- Basic Widgets Area -->
          <div class="narep-widgets-section">
            <div class="narep-widgets-section-inner">
              <div class="narep-widgets-section-title-holder">
                <h3 class="narep-widgets-section-title"><?php esc_html_e('Basic Widgets', 'restaurant-cafe-addon-for-elementor'); ?></h3>
                <div class="narep-checkbox-toggle narep-field">
                  <h6 class="narep-checkbox-toggle-text"><?php esc_html_e('Activate All', 'restaurant-cafe-addon-for-elementor'); ?></h6>
                  <label class="switch narep-checkbox-toggle-label">
                    <input type="checkbox" <?php checked( $rcafe_bw_toggle, 1 ); ?> id="narep-checkbox-toggle-bw" value="1">
                    <span class="narep-checkbox-toggle-bw-slider slider round" data-ajax-url="<?php echo admin_url('admin-ajax.php'); ?>" data-nonce="<?php echo wp_create_nonce( 'rcafe-toggle-bw-nonce' ); ?>"></span>
                  </label>
                  <button 
                  class="button button-outline basic-submit-class rcafe-bw-settings-save" 
                  ><?php esc_html_e('Save', 'restaurant-cafe-addon-for-elementor'); ?></button>
                </div>
              </div>
              
              <form method="post" class="rcafe-bw-settings-form" data-ajax-url="<?php echo admin_url('admin-ajax.php'); ?>" data-nonce="<?php echo wp_create_nonce( 'rcafe-bw-nonce' ); ?>">
                <div class="narep-row">
                  <?php foreach (rcafe_basic_widgets_settings_init() as $id => $option) { ?>
                  <!-- Widgets start -->
                  <div class="narep-col-6 narep-widget-col" data-widget-name="<?php echo strtolower( $option['title'] ); ?>"> 
                    <div class="narep-widget-grid<?php if($option['is_premium']) { ?> narep-widget-premium<?php } ?>">
                      <div class="narep-widget-grid-inner">
                        <!-- Widget start -->
                        <div class="narep-widgets-item narep-col-sm-12 narep-col-md-6">
                          <div class="narep-widgets-item-top">
                            <h4 class="narep-widgets-title">
                              <span class="narep-widgets-title-inner">
                                <?php echo esc_html($option['title']); ?>
                                <?php if($option['is_premium']) { ?>
                                  <sup class="narep-widgets-premium-label"><?php esc_html_e('premium', 'restaurant-cafe-addon-for-elementor'); ?></sup>
                                <?php } ?>
                              </span>
                            </h4>
                            <div class="narep-checkbox-toggle narep-field">
                              <label class="switch">
                                <input type="checkbox" <?php checked( $rcafe_bw_settings['nbeds_' . $id], 1 ); ?> name="nbeds_<?php echo esc_attr($id); ?>" id="nbeds_<?php echo esc_attr($id); ?>-id" value="1">
                                <span class="slider round"></span>
                              </label>
                            </div>
                          </div>
                          <?php if($option['demo_url']) { ?>
                            <a href="<?php echo $option['demo_url']; ?>" target="_blank"><?php esc_html_e('Demo', 'restaurant-cafe-addon-for-elementor'); ?></a>
                          <?php } if($option['documentation_url']) { ?>
                            <a href="<?php echo $option['documentation_url']; ?>" target="_blank"><?php esc_html_e('Documentation', 'restaurant-cafe-addon-for-elementor'); ?></a>
                          <?php } if($option['video_url']) { ?>
                            <a href="<?php echo $option['video_url']; ?>" target="_blank"><?php esc_html_e('Video', 'restaurant-cafe-addon-for-elementor'); ?></a>
                          <?php } ?>
                        </div>                  
                      </div>  
                    </div>
                  </div><!-- Widgets end -->
                  <?php } ?> 
                </div>
              </form>
            </div>
          </div><!-- Basic Widgets Area End -->

          <!-- Unique Widgets Area -->
          <div class="narep-widgets-section">
            <div class="narep-widgets-section-inner">
              <div class="narep-widgets-section-title-holder">
                <h3 class="narep-widgets-section-title"><?php esc_html_e('Unique Widgets', 'restaurant-cafe-addon-for-elementor'); ?></h3>
                <div class="narep-checkbox-toggle narep-field">
                  <h6 class="narep-checkbox-toggle-text"><?php esc_html_e('Activate All', 'restaurant-cafe-addon-for-elementor'); ?></h6>
                  <label class="switch narep-checkbox-toggle-label">
                    <input type="checkbox" <?php checked( $rcafe_uw_toggle, 1 ); ?> id="narep-checkbox-toggle-uw" value="1">
                    <span class="narep-checkbox-toggle-uw-slider slider round" data-ajax-url="<?php echo admin_url('admin-ajax.php'); ?>" data-nonce="<?php echo wp_create_nonce( 'rcafe-toggle-uw-nonce' ); ?>"></span>
                  </label>
                  <button 
                  class="button button-outline basic-submit-class rcafe-uw-settings-save" 
                  ><?php esc_html_e('Save', 'restaurant-cafe-addon-for-elementor'); ?></button>
                </div>
              </div>
              
              <form method="post" class="rcafe-uw-settings-form" data-ajax-url="<?php echo admin_url('admin-ajax.php'); ?>" data-nonce="<?php echo wp_create_nonce( 'rcafe-uw-nonce' ); ?>">
                <div class="narep-row">
                  <?php foreach (rcafe_unique_widgets_settings_init() as $id => $option) { ?>
                  <!-- Widgets start -->
                  <div class="narep-col-6 narep-widget-col" data-widget-name="<?php echo strtolower( $option['title'] ); ?>"> 
                    <div class="narep-widget-grid <?php if($option['is_premium']) { ?>narep-widget-premium<?php } ?>">
                      <div class="narep-widget-grid-inner">
                        <!-- Widget start -->
                        <div class="narep-widgets-item narep-col-sm-12 narep-col-md-6">
                          <div class="narep-widgets-item-top">
                            <h4 class="narep-widgets-title">
                              <span class="narep-widgets-title-inner">
                                <?php echo esc_html($option['title']); ?>
                                <?php if($option['is_premium']) { ?>
                                  <sup class="narep-widgets-premium-label"><?php esc_html_e('premium', 'restaurant-cafe-addon-for-elementor'); ?></sup>
                                <?php } ?>
                              </span>
                            </h4>
                            <div class="narep-checkbox-toggle narep-field">
                              <?php if(rcafe_fs()->is_free_plan() && $option['is_premium']) { 
                                $plan_class = 'free-plan'; 
                              } else { 
                                $plan_class = 'paid-plan'; 
                              } ?>
                              <img class="img-toggle <?php echo $plan_class; ?>" src="<?php echo NAREP_URL . 'assets/images/toggle.png'; ?>" alt="toggle">
                              <label class="switch main-toggle <?php echo $plan_class; ?>">
                                <input type="checkbox" <?php checked( $rcafe_uw_settings['nbeds_' . $id], 1 ); ?> name="nbeds_<?php echo esc_attr($id); ?>" id="nbeds_<?php echo esc_attr($id); ?>-id" value="1">
                                <span class="slider round"></span>
                              </label>
                            </div>
                          </div>
                          <?php if($option['demo_url']) { ?>
                            <a href="<?php echo $option['demo_url']; ?>" target="_blank"><?php esc_html_e('Demo', 'restaurant-cafe-addon-for-elementor'); ?></a>
                          <?php } if($option['documentation_url']) { ?>
                            <a href="<?php echo $option['documentation_url']; ?>" target="_blank"><?php esc_html_e('Documentation', 'restaurant-cafe-addon-for-elementor'); ?></a>
                          <?php } if($option['video_url']) { ?>
                            <a href="<?php echo $option['video_url']; ?>" target="_blank"><?php esc_html_e('Video', 'restaurant-cafe-addon-for-elementor'); ?></a>
                          <?php } if(rcafe_fs()->is_free_plan() && $option['is_premium']) { ?>
                            <a href="<?php echo admin_url('admin.php?page=narep_admin_page-pricing'); ?>" class="narep-update-pro" target="_blank"><?php esc_html_e('Upgrade', 'restaurant-cafe-addon-for-elementor'); ?></a>
                          <?php } ?>
                        </div>
                      </div>  
                    </div>
                  </div><!-- Widgets end -->
                  <?php } ?> 
                </div>
              </form>
            </div>
          </div><!-- Unique Widgets Area End -->

        </div>
        <!-- Advertisements start -->
        <div class="narep-col-4">
          <div class="nichads-wrapper ms-3">
            <div class="single-nichads mb-4">
              <a href="//nicheaddons.com">
                <img src="//nicheaddons.com/wp-content/uploads/2023/07/420x250-nichbase.jpg" alt="nichbase">
              </a>            
            </div>
            <div class="narep-row">
              <div class="narep-col-6">
                <div class="narep-info-box">
                  <a href="//nicheaddons.com/demos/restaurant/" target="_blank">
                    <span class="ti-blackboard"></span>
                    <span>Live Demo</span>
                  </a>
                </div>
              </div>
              <div class="narep-col-6">
                <div class="narep-info-box">
                  <a href="//wordpress.org/plugins/restaurant-cafe-addon-for-elementor/" target="_blank">
                    <span class="ti-world"></span>
                    <span>Plugins Page</span>
                  </a>
                </div>
              </div>
              <div class="narep-col-6">
                <div class="narep-info-box">
                  <a href="//nicheaddons.com/docs/restaurant-cafe-addon-basic-elements/" target="_blank">
                    <span class="ti-book"></span>
                    <span>Documentation</span>
                  </a>
                </div>
              </div>
              <div class="narep-col-6">
                <div class="narep-info-box">
                  <a href="<?php echo admin_url('admin.php?page=narep_admin_page-contact') ?>" target="_blank">
                    <span class="ti-headphone-alt"></span>
                    <span>Support</span>
                  </a>
                </div>
              </div>
            </div>
            <div class="single-nichads mb-4">
              <a href="//nicheaddons.com/plugins/restaurant-addon/" target="_blank">
                <img src="//nicheaddons.com/wp-content/uploads/2023/07/420x680-restaurant-pro.jpg" alt="restaurant-pro">
              </a>               
            </div>
            <div class="single-nichads mb-4">
              <a href="//nicheaddons.com/themes/nichebase/" target="_blank">
                <img src="//nicheaddons.com/wp-content/uploads/2023/07/420x680-nichbase-2.jpg" alt="nichbase">
              </a>               
            </div>
            <div class="single-nichads mb-4">
              <a href="//nicheaddons.com/plugin/" target="_blank">
                <img src="//nicheaddons.com/wp-content/uploads/2023/07/420x680-other-plugins.jpg" alt="other-plugins">
              </a>               
            </div>
          </div>
        </div><!-- Advertisements end -->
      </div>
    </div>
    <?php
  }
}
