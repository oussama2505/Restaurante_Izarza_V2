<?php
/*
 * All Elementor Init
 * Author & Copyright: NicheAddon
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( !class_exists('Restaurant_Elementor_Addon_Core_Elementor_init') ){
	class Restaurant_Elementor_Addon_Core_Elementor_init{

		/*
		 * Minimum Elementor Version
		*/
		const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

		/*
		 * Minimum PHP Version
		*/
		const MINIMUM_PHP_VERSION = '5.6';

    /*
	   * Instance
	  */
		private static $instance;

		/*
		 * Main Restaurant & Cafe Addon for Elementor plugin Class Constructor
		*/
		public function __construct(){
			add_action( 'plugins_loaded', [ $this, 'init' ] );

			// Js Enqueue
			add_action( 'elementor/frontend/after_enqueue_scripts', function() {
				wp_enqueue_script( 'narestaurant-elementor', plugins_url( '/', __FILE__ ) . '/js/narestaurant-elementor.js', [ 'jquery' ], false, true );
			} );

			add_action( 'elementor/editor/before_enqueue_scripts', function() {
				wp_enqueue_style( 'narestaurant-elementor', plugins_url( '/', __FILE__ ) . '/css/narestaurant-elementor.css' );
			} );

		}

		/**
		 * Add a new dashboard widget.
		 */
		function dashboard_widget() {
			wp_add_dashboard_widget( 'nichaddons_dashboard_widget', 'Nichaddons News', [ $this, 'dashboard_widget_ouput' ] );
		}


		/**
		 * Output the contents of the dashboard widget
		 */
		function dashboard_widget_ouput( $post, $callback_args ) {
			?>
			<div class="nichaddons-dashboard-widget">
				<div class="nichaddons-dw-header">
					<div class="nichaddons-dw-logo">
						<a href="//nicheaddons.com/?utm_source=dash&amp;utm_medium=wp&amp;utm_campaign=widget">
							<img src="//nicheaddons.com/wp-content/uploads/2023/07/NicheAddons-Logo-SM.png" alt="Nicheaddons" height="32">
							Nicheaddons		
						</a>
					</div>
					<div class="nichaddons-dw-market-link">
						<a href="//nicheaddons.com/plugin/?utm_source=dash&amp;utm_medium=wp&amp;utm_campaign=widget">
							<span aria-hidden="true" class="dashicons dashicons-external"></span>
							<?php esc_html_e( 'Check all plugins', 'restaurant-cafe-addon-for-elementor' ); ?>
						</a>
					</div>
				</div>

				<div class="nichaddons-dw-sticky-item nichaddons-dw-box">
					<div class="nichaddons-dw-sticky-item-image">
						<a href="//nicheaddons.com/?utm_source=dash&amp;utm_medium=wp&amp;utm_campaign=widget" target="_blank">
							<img src="//nicheaddons.com/wp-content/uploads/2023/07/560x315-dashboard.jpg" alt="nichebase">
						</a>
					</div>
					<div class="nichaddons-dw-sticky-item-text">
						<h3><?php esc_html_e( 'Unlock the potential of NicheAddon’s Themes and Plugins to create your website rapidly and at zero cost. With a remarkable user base of over 20,000+ active websites, our expertise is undeniable.', 'restaurant-cafe-addon-for-elementor' ); ?></h3>
						<p><a href="//nicheaddons.com/?utm_source=dash&amp;utm_medium=wp&amp;utm_campaign=widget" target="_blank"><?php esc_html_e( 'Checkout Our Themes & Plugins', 'restaurant-cafe-addon-for-elementor' ); ?></a></p>
					</div>
				</div>

				<div class="nichaddons-dw-support nichaddons-dw-box">
					<h2><?php esc_html_e( 'Restaurant Addon Support', 'restaurant-cafe-addon-for-elementor' ); ?></h2>
					<p><?php esc_html_e( 'Our support team is always there to help you out with any questions or issues you may come across.', 'restaurant-cafe-addon-for-elementor' ); ?></p>
					<div class="nichaddons-dw-support-links">
						<div class="nichaddons-dw-support-row">
							<div class="nichaddons-dw-support-cell">
								<a href="//nicheaddons.com/docs/restaurant-cafe-addon-basic-elements/" target="_blank">
									<span aria-hidden="true" class="dashicons dashicons-external"></span>
									<?php esc_html_e( 'Basic Elements Doc', 'restaurant-cafe-addon-for-elementor' ); ?>
								</a>
							</div>
							<div class="nichaddons-dw-support-cell">
								<a href="//nicheaddons.com/docs/restaurant-cafe-addon-unique-elements/" target="_blank">
									<span aria-hidden="true" class="dashicons dashicons-external"></span>
									<?php esc_html_e( 'Unique Elements Doc', 'restaurant-cafe-addon-for-elementor' ); ?>
								</a>
							</div>
						</div>
						<div class="nichaddons-dw-support-row">
							<div class="nichaddons-dw-support-cell">
								<a href="//www.youtube.com/playlist?list=PLN8jAS2iQBQXYosU21wovpqj-xR_aT_Uz" target="_blank">
									<span aria-hidden="true" class="dashicons dashicons-external"></span>
									<?php esc_html_e( 'Video Tutorials', 'restaurant-cafe-addon-for-elementor' ); ?>
								</a>
							</div>
							<div class="nichaddons-dw-support-cell">
								<a href="<?php echo admin_url('admin.php?page=narep_admin_page-contact'); ?>" target="_blank">
									<span aria-hidden="true" class="dashicons dashicons-external"></span>
									<?php esc_html_e( 'Submit Ticket', 'restaurant-cafe-addon-for-elementor' ); ?>
								</a>
							</div>
						</div>
					</div>
				</div>

				<div class="nichaddons-dw-social nichaddons-dw-box">
					<div class="nichaddons-dw-social-inner">
						<a href="https://www.facebook.com/NicheAddons/" target="_blank">
							<span class="dashicons dashicons-facebook-alt"></span>
							Facebook
						</a>
						<a href="https://twitter.com/NicheAddons/" target="_blank">
							<span class="dashicons dashicons-twitter"></span>
							Twitter
						</a>
						<a href="https://www.youtube.com/channel/UCnrZdL-p547L3ee8cwuOJRQ" target="_blank">
							<span class="dashicons dashicons-youtube"></span>
							Youtube
						</a>
					</div>
				</div>								
			</div>
			<?php
		}		

		/*
		 * Class instance
		*/
		public static function getInstance(){
			if (null === self::$instance) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/*
		 * Initialize the plugin
		*/
		public function init() {

			// Check for required Elementor version
			if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
				add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
				return;
			}

			// Check for required PHP version
			if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
				add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
				return;
			}

			// elementor Custom Group Controls Include
			self::controls_helper();

			// elementor categories
			add_action( 'elementor/elements/categories_registered', [ $this, 'basic_widget_categories' ] );
			add_action( 'elementor/elements/categories_registered', [ $this, 'narestaurant_unique_widget_categories' ] );

			// Elementor Widgets Registered
			add_action( 'elementor/widgets/widgets_registered', [ $this, 'narestaurant_basic_widgets_registered' ] );
			add_action( 'elementor/widgets/widgets_registered', [ $this, 'narestaurant_unique_widgets_registered' ] );

			add_action( 'wp_dashboard_setup', [ $this, 'dashboard_widget' ] );
		}

		/*
		 * Admin notice
		 * Warning when the site doesn't have a minimum required Elementor version.
		*/
		public function admin_notice_minimum_elementor_version() {
			if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
			$message = sprintf(
				/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
				esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'restaurant-cafe-addon-for-elementor' ),
				'<strong>' . esc_html__( 'Restaurant & Cafe Addon for Elementor', 'restaurant-cafe-addon-for-elementor' ) . '</strong>',
				'<strong>' . esc_html__( 'Elementor', 'restaurant-cafe-addon-for-elementor' ) . '</strong>',
				 self::MINIMUM_ELEMENTOR_VERSION
			);
			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
		}

		/*
		 * Admin notice
		 * Warning when the site doesn't have a minimum required PHP version.
		*/
		public function admin_notice_minimum_php_version() {
			if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
			$message = sprintf(
				/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
				esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'restaurant-cafe-addon-for-elementor' ),
				'<strong>' . esc_html__( 'Restaurant & Cafe Addon for Elementor', 'restaurant-cafe-addon-for-elementor' ) . '</strong>',
				'<strong>' . esc_html__( 'PHP', 'restaurant-cafe-addon-for-elementor' ) . '</strong>',
				 self::MINIMUM_PHP_VERSION
			);
			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
		}

		/*
		 * Class Group Controls
		*/
		public static function controls_helper(){
			$group_controls = ['lib'];
			foreach($group_controls as $control){
				if ( file_exists( plugin_dir_path( __FILE__ ) . '/lib/'.$control.'.php' ) ){
					require_once( plugin_dir_path( __FILE__ ) . '/lib/'.$control.'.php' );
				}
			}
		}

		/*
		 * Widgets elements categories
		*/
		public function basic_widget_categories($elements_manager){
			$elements_manager->add_category(
				'narestaurant-basic-category',
				[
					'title' => __( 'Restaurant Basic Elements : By Niche Addons', 'restaurant-cafe-addon-for-elementor' ),
				]
			);
		}
		public function narestaurant_unique_widget_categories($elements_manager){
			$elements_manager->add_category(
				'narestaurant-unique-category',
				[
					'title' => __( 'Unique Restaurant Elements : By Niche Addons', 'restaurant-cafe-addon-for-elementor' ),
				]
			);
		}

		/*
		 * Widgets registered
		*/
		public function narestaurant_basic_widgets_registered(){
			// init widgets
			$basic_dir = plugin_dir_path( __FILE__ ) . '/widgets/basic/';
			// Open a directory, and read its contents
			if (is_dir($basic_dir)){
			  $basic_dh = opendir($basic_dir);
		    while (($basic_file = readdir($basic_dh)) !== false){
		    	if (!in_array(trim($basic_file), ['.', '..'])) {
						$basic_template_file = plugin_dir_path( __FILE__ ) . '/widgets/basic/'.$basic_file;
						if ( $basic_template_file && is_readable( $basic_template_file ) ) {
							include_once $basic_template_file;
						}
			    }
		    }
		    closedir($basic_dh);
			}
		}

		public function narestaurant_unique_widgets_registered(){
			// init widgets
			$unique_dir = plugin_dir_path( __FILE__ ) . '/widgets/restaurant-unique/';
			// Open a directory, and read its contents
			if (is_dir($unique_dir)){
			  $unique_dh = opendir($unique_dir);
		    while (($unique_file = readdir($unique_dh)) !== false){
		    	if (!in_array(trim($unique_file), ['.', '..'])) {
						$unique_template_file = plugin_dir_path( __FILE__ ) . '/widgets/restaurant-unique/'.$unique_file;
						if ( $unique_template_file && is_readable( $unique_template_file ) ) {
							include_once $unique_template_file;
						}
			    }
		    }
		    closedir($unique_dh);
			}
		}

	} //end class

	if (class_exists('Restaurant_Elementor_Addon_Core_Elementor_init')){
		Restaurant_Elementor_Addon_Core_Elementor_init::getInstance();
	}

}

if ( ! function_exists( 'narestaurant_elementor_default_typo_color_active' ) ) {
	function narestaurant_elementor_default_typo_color_active() {
		update_option( 'elementor_disable_color_schemes', 'yes' );
		update_option( 'elementor_disable_typography_schemes', 'yes' );
	}
	add_action( 'after_switch_theme', 'narestaurant_elementor_default_typo_color_active' );
}

if ( ! function_exists( 'narestaurant_elementor_default_typo_color_active_after' ) ) {
	function narestaurant_elementor_default_typo_color_active_after() {
		update_option( 'elementor_disable_color_schemes', 'yes' );
		update_option( 'elementor_disable_typography_schemes', 'yes' );
	}
	add_action( 'pt-ocdi/after_content_import_execution', 'narestaurant_elementor_default_typo_color_active_after' );
}

/* Add Featured Image support in event organizer */
add_post_type_support( 'tribe_organizer', 'thumbnail' );

/* Excerpt Length */
if ( ! class_exists( 'Restaurant_Elementor_Addon_Excerpt' ) ) {
	class Restaurant_Elementor_Addon_Excerpt {
	  public static $length = 55;
	  public static $types = array(
	    'short' => 25,
	    'regular' => 55,
	    'long' => 100
	  );
	  public static function length($new_length = 55) {
	    Restaurant_Elementor_Addon_Excerpt::$length = $new_length;
	    add_filter('excerpt_length', 'Restaurant_Elementor_Addon_Excerpt::new_length');
	    Restaurant_Elementor_Addon_Excerpt::output();
	  }
	  public static function new_length() {
	    if ( isset(Restaurant_Elementor_Addon_Excerpt::$types[Restaurant_Elementor_Addon_Excerpt::$length]) )
	      return Restaurant_Elementor_Addon_Excerpt::$types[Restaurant_Elementor_Addon_Excerpt::$length];
	    else
	      return Restaurant_Elementor_Addon_Excerpt::$length;
	  }
	  public static function output() {
	    the_excerpt();
	  }
	}
}

// Custom Excerpt Length
if ( ! function_exists( 'narestaurant_excerpt' ) ) {
  function narestaurant_excerpt($length = 55) {
    Restaurant_Elementor_Addon_Excerpt::length($length);
  }
}

if ( ! function_exists( 'narestaurant_new_excerpt_more' ) ) {
  function narestaurant_new_excerpt_more( $more ) {
    return '...';
  }
  add_filter('excerpt_more', 'narestaurant_new_excerpt_more');
}

if ( ! function_exists( 'narestaurant_paging_nav' ) ) {
  function narestaurant_paging_nav($numpages = '', $pagerange = '', $paged='') {

      if (empty($pagerange)) {
        $pagerange = 2;
      }
      if (empty($paged)) {
        $paged = 1;
      } else {
        $paged = $paged;
      }
      if ($numpages == '') {
        global $wp_query;
        $numpages = $wp_query->max_num_pages;
        if (!$numpages) {
          $numpages = 1;
        }
      }
      global $wp_query;
      $big = 999999999;
      if ($wp_query->max_num_pages != '1' ) { ?>
      <div class="narep-pagination">
        <?php echo paginate_links( array(
          'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
          'format' => '?paged=%#%',
          'prev_text' => '<i class="fa fa-angle-double-left" aria-hidden="true"></i>',
          'next_text' => '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
          'current' => $paged,
          'total' => $numpages,
          'type' => 'list'
        )); ?>
      </div>
    <?php }
  }
}

if ( ! function_exists( 'narestaurant_clean_string' ) ) {
	function narestaurant_clean_string($string) {
	  $string = str_replace(' ', '', $string);
	  return preg_replace('/[^\da-z ]/i', '', $string);
	}
}

/* Validate px entered in field */
if ( ! function_exists( 'narestaurant_core_check_px' ) ) {
  function narestaurant_core_check_px( $num ) {
    return ( is_numeric( $num ) ) ? $num . 'px' : $num;
  }
}

if ( class_exists( 'woocommerce' ) ) {
	/**
	 * Add quantity field
	 */
	function narestaurant_add_quantity_field() {

		/** @var WC_Product $product */
		$product = wc_get_product( get_the_ID() );

		if ( ! $product->is_sold_individually() && 'variable' != $product->get_type() && $product->is_purchasable() ) {
			woocommerce_quantity_input( array( 'min_value' => 1, 'max_value' => $product->backorders_allowed() ? '' : $product->get_stock_quantity() ) );
		}

	}
	add_action( 'narestaurant_woocommerce_after_shop_loop_item', 'narestaurant_add_quantity_field', 12 );

	/**
	 * Add required JavaScript.
	 */
	function narestaurant_quantity_add_to_cart_handler() {

		wc_enqueue_js( '
			$(".narep-food-menu-wrap").on("click", ".quantity input", function() {
				return false;
			});
			$(".narep-food-menu-wrap").on("change input", ".quantity .qty", function() {
				var add_to_cart_button = $(this).parents( ".narep-food-menu-item-wrap" ).find(".add_to_cart_button");
				// For AJAX add-to-cart actions
				add_to_cart_button.attr("data-quantity", $(this).val());
				// For non-AJAX add-to-cart actions
				add_to_cart_button.attr("href", "?add-to-cart=" + add_to_cart_button.attr("data-product_id") + "&quantity=" + $(this).val());
			});
			// Trigger on Enter press
			$(".narep-food-menu-wrap").on("keypress", ".quantity .qty", function(e) {
				if ((e.which||e.keyCode) === 13) {
					$( this ).parents(".narep-food-menu-item-wrap").find(".add_to_cart_button").trigger("click");
				}
			});
		' );

	}
	add_action( 'init', 'narestaurant_quantity_add_to_cart_handler' );
}