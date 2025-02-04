<?php

/*
Plugin Name: Restaurant & Cafe Addon for Elementor
Plugin URI: https://nicheaddons.com/demos/restaurant
Description: Restaurant & Cafe Addon for Elementor covers all the must-needed elements for creating a perfect Restaurant website using Elementor Page Builder. 50+ Unique & Basic Elementor widget covers all of the Restaurant elements.
Author: NicheAddons
Author URI: https://nicheaddons.com/
Version: 1.6.1
Text Domain: restaurant-cafe-addon-for-elementor
*/
include_once ABSPATH . 'wp-admin/includes/plugin.php';
// Pro Codes
/* PLUGIN SELF PATH */
define( 'NAREP_VERSION', '1.6.1' );
define( 'NAREP_URL', plugins_url( '/', __FILE__ ) );
if ( !function_exists( 'rcafe_fs' ) ) {
    // Create a helper function for easy SDK access.
    function rcafe_fs() {
        global $rcafe_fs;
        if ( !isset( $rcafe_fs ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/freemius/start.php';
            $rcafe_fs = fs_dynamic_init( array(
                'id'             => '5887',
                'slug'           => 'restaurant-cafe-addon-for-elementor',
                'premium_slug'   => 'restaurant-cafe-addon-for-elementor-pro',
                'type'           => 'plugin',
                'public_key'     => 'pk_f065a2f0490e8e5d5d1afd5670134',
                'is_premium'     => false,
                'premium_suffix' => 'Pro',
                'has_addons'     => false,
                'has_paid_plans' => true,
                'trial'          => array(
                    'days'               => 7,
                    'is_require_payment' => true,
                ),
                'menu'           => array(
                    'slug'           => 'narep_admin_page',
                    'override_exact' => true,
                    'support'        => false,
                    'parent'         => array(
                        'slug' => 'narep_admin_page',
                    ),
                ),
                'is_live'        => true,
            ) );
        }
        return $rcafe_fs;
    }

    // Init Freemius.
    rcafe_fs();
    // Signal that SDK was initiated.
    do_action( 'rcafe_fs_loaded' );
    function rcafe_fs_settings_url() {
        return admin_url( 'admin.php?page=narep_admin_page' );
    }

    rcafe_fs()->add_filter( 'connect_url', 'rcafe_fs_settings_url' );
    rcafe_fs()->add_filter( 'after_skip_url', 'rcafe_fs_settings_url' );
    rcafe_fs()->add_filter( 'after_connect_url', 'rcafe_fs_settings_url' );
    rcafe_fs()->add_filter( 'after_pending_connect_url', 'rcafe_fs_settings_url' );
}
/**
 * Enqueue Files for BackEnd
 */
if ( !function_exists( 'narep_admin_scripts_styles' ) ) {
    function narep_admin_scripts_styles(  $hook  ) {
        if ( 'toplevel_page_narep_admin_page' == $hook ) {
            wp_enqueue_style(
                'linea',
                plugins_url( '/', __FILE__ ) . 'assets/css/themify-icons.min.css',
                array(),
                '1.0.0',
                'all'
            );
        }
        wp_enqueue_style( 'narep-admin-styles', plugins_url( '/', __FILE__ ) . 'assets/css/admin-styles.css', true );
        wp_enqueue_script(
            'repeatable-fields',
            plugins_url( '/', __FILE__ ) . 'assets/js/repeatable-fields.js',
            array('jquery'),
            '1.5.0',
            true
        );
        wp_enqueue_script(
            'narep-admin-script',
            plugins_url( '/', __FILE__ ) . 'assets/js/admin-scripts.js',
            array('jquery'),
            '1.1',
            true
        );
    }

    add_action( 'admin_enqueue_scripts', 'narep_admin_scripts_styles' );
}
// Admin Pages
require_once plugin_dir_path( __FILE__ ) . '/elementor/narep-admin-functions.php';
require_once plugin_dir_path( __FILE__ ) . '/elementor/narep-admin-page.php';
require_once plugin_dir_path( __FILE__ ) . '/elementor/narep-admin-sub-page.php';
require_once plugin_dir_path( __FILE__ ) . '/elementor/narep-admin-basic-fields.php';
require_once plugin_dir_path( __FILE__ ) . '/elementor/narep-admin-unique-fields.php';
if ( !function_exists( 'narep_admin_menu' ) ) {
    add_action( 'admin_menu', 'narep_admin_menu' );
    function narep_admin_menu() {
        add_menu_page(
            'Restaurant & Cafe Addon for Elementor',
            'Restaurant Addon',
            'manage_options',
            'narep_admin_page',
            'narep_admin_sub_page',
            NAREP_URL . 'assets/images/icon.png',
            80
        );
        // add_submenu_page(
        //     'narep_admin_page',
        //     'Enable & Disable',
        //     'Enable & Disable',
        //     'manage_options',
        //     'narep_admin_sub_page',
        //     'narep_admin_sub_page'
        // );
    }

}
// ABSPATH
if ( !function_exists( 'narestaurant_block_direct_access' ) ) {
    function narestaurant_block_direct_access() {
        if ( !defined( 'ABSPATH' ) ) {
            exit( 'Forbidden' );
        }
    }

}
// Initial File
// Only for free users
if ( rcafe_fs()->is_free_plan() ) {
    if ( is_plugin_active( 'elementor/elementor.php' ) && is_plugin_active( 'restaurant-cafe-addon-for-elementor/restaurant-cafe-addon-for-elementor.php' ) ) {
        if ( file_exists( plugin_dir_path( __FILE__ ) . '/elementor/em-setup.php' ) ) {
            require_once plugin_dir_path( __FILE__ ) . '/elementor/em-setup.php';
        }
    }
}
// is_premium
require_once plugin_dir_path( __FILE__ ) . '/elementor/em-setup.php';
// Plugin language
if ( !function_exists( 'narestaurant_plugin_language_setup' ) ) {
    function narestaurant_plugin_language_setup() {
        load_plugin_textdomain( 'restaurant-cafe-addon-for-elementor', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
    }

    add_action( 'init', 'narestaurant_plugin_language_setup' );
}
// Check if Elementor installed and activated
if ( !function_exists( 'narestaurant_load_plugin' ) ) {
    function narestaurant_load_plugin() {
        if ( !did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', 'admin_notice_missing_main_plugin' );
            return;
        }
    }

    add_action( 'plugins_loaded', 'narestaurant_load_plugin' );
}
// Warning when the site doesn't have Elementor installed or activated.
if ( !function_exists( 'admin_notice_missing_main_plugin' ) ) {
    function admin_notice_missing_main_plugin() {
        if ( isset( $_GET['activate'] ) ) {
            unset($_GET['activate']);
        }
        $message = sprintf( 
            /* translators: 1: Plugin name 2: Elementor */
            esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'restaurant-cafe-addon-for-elementor' ),
            '<strong>' . esc_html__( 'Restaurant & Cafe Addon for Elementor', 'restaurant-cafe-addon-for-elementor' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'restaurant-cafe-addon-for-elementor' ) . '</strong>'
         );
        printf( '<div class="notice notice-error is-dismissible"><p>%1$s</p></div>', $message );
    }

}
// Both Free and Pro activated
if ( is_plugin_active( 'restaurant-cafe-addon-for-elementor/restaurant-cafe-addon-for-elementor.php' ) && is_plugin_active( 'restaurant-cafe-addon-for-elementor-pro/restaurant-cafe-addon-for-elementor.php' ) ) {
    add_action( 'admin_notices', 'admin_notice_deactivate_free' );
}
// Warning when the site have Both Free and Pro activated.
if ( !function_exists( 'admin_notice_deactivate_free' ) ) {
    function admin_notice_deactivate_free() {
        if ( isset( $_GET['activate'] ) ) {
            unset($_GET['activate']);
        }
        $message = sprintf( 
            /* translators: 1: Plugin name */
            esc_html__( 'Please deactivate the free version of "%1$s".', 'restaurant-cafe-addon-for-elementor' ),
            '<strong>' . esc_html__( 'Restaurant & Cafe Addon for Elementor', 'restaurant-cafe-addon-for-elementor' ) . '</strong>'
         );
        printf( '<div class="notice notice-error is-dismissible"><p>%1$s</p></div>', $message );
    }

}
// Enable & Dissable Notice
add_action( 'admin_notices', 'admin_notice_enable_dissable' );
if ( !function_exists( 'admin_notice_enable_dissable' ) ) {
    function admin_notice_enable_dissable() {
        if ( isset( $_GET['settings-updated'] ) ) {
            $message = sprintf( esc_html__( 'Widgets Settings Saved.', 'restaurant-cafe-addon-for-elementor' ) );
            printf( '<div class="notice notice-success is-dismissible"><p>%1$s</p></div>', $message );
        }
    }

}
// Enqueue Files for Elementor Editor
if ( is_plugin_active( 'elementor/elementor.php' ) ) {
    // Css Enqueue
    add_action( 'elementor/editor/before_enqueue_scripts', function () {
        wp_enqueue_style(
            'narestaurant-ele-editor-linea',
            plugins_url( '/', __FILE__ ) . 'assets/css/linea.min.css',
            [],
            '1.0.0'
        );
        wp_enqueue_style(
            'narestaurant-ele-editor-themify',
            plugins_url( '/', __FILE__ ) . 'assets/css/themify-icons.min.css',
            [],
            '1.0.0'
        );
        wp_enqueue_style(
            'narestaurant-ele-editor-icofont',
            plugins_url( '/', __FILE__ ) . 'assets/css/icofont.min.css',
            [],
            '1.0.1'
        );
    } );
    // Js Enqueue
    add_action( 'elementor/frontend/after_enqueue_scripts', function () {
        wp_enqueue_script(
            'narestaurant-chartjs',
            plugins_url( '/', __FILE__ ) . 'assets/js/Chart.min.js',
            array('jquery'),
            '2.9.3',
            true
        );
    } );
}
// Enqueue Files for FrontEnd
if ( !function_exists( 'narestaurant_scripts_styles' ) ) {
    function narestaurant_scripts_styles() {
        // Styles
        wp_enqueue_style(
            'niche-frame',
            plugins_url( '/', __FILE__ ) . 'assets/css/niche-frame.css',
            array(),
            '1.0',
            'all'
        );
        wp_enqueue_style(
            'font-awesome',
            plugins_url( '/', __FILE__ ) . 'assets/css/font-awesome.min.css',
            array(),
            '4.7.0',
            'all'
        );
        wp_enqueue_style(
            'animate',
            plugins_url( '/', __FILE__ ) . 'assets/css/animate.min.css',
            array(),
            '3.7.2',
            'all'
        );
        wp_enqueue_style(
            'themify-icons',
            plugins_url( '/', __FILE__ ) . 'assets/css/themify-icons.min.css',
            array(),
            '1.0.0',
            'all'
        );
        wp_enqueue_style(
            'linea',
            plugins_url( '/', __FILE__ ) . 'assets/css/linea.min.css',
            array(),
            '1.0.0',
            'all'
        );
        wp_enqueue_style(
            'icofont',
            plugins_url( '/', __FILE__ ) . 'assets/css/icofont.min.css',
            array(),
            '1.0.1',
            'all'
        );
        wp_enqueue_style(
            'magnific-popup',
            plugins_url( '/', __FILE__ ) . 'assets/css/magnific-popup.min.css',
            array(),
            '1.0',
            'all'
        );
        wp_enqueue_style(
            'flickity',
            plugins_url( '/', __FILE__ ) . 'assets/css/flickity.min.css',
            array(),
            '2.2.1',
            'all'
        );
        wp_enqueue_style(
            'owl-carousel',
            plugins_url( '/', __FILE__ ) . 'assets/css/owl.carousel.min.css',
            array(),
            '2.3.4',
            'all'
        );
        wp_enqueue_style(
            'slick-theme',
            plugins_url( '/', __FILE__ ) . 'assets/css/slick-theme.min.css',
            array(),
            '1.0',
            'all'
        );
        wp_enqueue_style(
            'slick',
            plugins_url( '/', __FILE__ ) . 'assets/css/slick.min.css',
            array(),
            '1.0',
            'all'
        );
        wp_enqueue_style(
            'juxtapose',
            plugins_url( '/', __FILE__ ) . 'assets/css/juxtapose.css',
            array(),
            '1.2.1',
            'all'
        );
        wp_enqueue_style(
            'timepicker',
            plugins_url( '/', __FILE__ ) . 'assets/css/jquery.timepicker.min.css',
            array(),
            '1.0',
            'all'
        );
        wp_enqueue_style(
            'datepicker',
            plugins_url( '/', __FILE__ ) . 'assets/css/bootstrap-datepicker.min.css',
            array(),
            '1.9.0',
            'all'
        );
        wp_enqueue_style(
            'multiscroll',
            plugins_url( '/', __FILE__ ) . 'assets/css/jquery.multiscroll.min.css',
            array(),
            '0.2.2',
            'all'
        );
        wp_enqueue_style(
            'narestaurant-styles',
            plugins_url( '/', __FILE__ ) . 'assets/css/styles.css',
            array(),
            '1.4.1',
            'all'
        );
        wp_enqueue_style(
            'narestaurant-responsive',
            plugins_url( '/', __FILE__ ) . 'assets/css/responsive.css',
            array(),
            '1.3',
            'all'
        );
        // Scripts
        wp_enqueue_script(
            'waypoints',
            plugins_url( '/', __FILE__ ) . 'assets/js/jquery.waypoints.min.js',
            array('jquery'),
            '4.0.1',
            true
        );
        wp_enqueue_script(
            'imagesloaded',
            plugins_url( '/', __FILE__ ) . 'assets/js/imagesloaded.pkgd.min.js',
            array('jquery'),
            '4.1.4',
            true
        );
        wp_enqueue_script(
            'magnific-popup',
            plugins_url( '/', __FILE__ ) . 'assets/js/jquery.magnific-popup.min.js',
            array('jquery'),
            '1.1.0',
            true
        );
        wp_enqueue_script(
            'juxtapose',
            plugins_url( '/', __FILE__ ) . 'assets/js/juxtapose.js',
            array('jquery'),
            '1.2.1',
            true
        );
        wp_enqueue_script(
            'helium',
            plugins_url( '/', __FILE__ ) . 'assets/js/helium.parallax.js',
            array('jquery'),
            '2.2',
            true
        );
        wp_enqueue_script(
            'typed',
            plugins_url( '/', __FILE__ ) . 'assets/js/typed.min.js',
            array('jquery'),
            '2.0.11',
            true
        );
        wp_enqueue_script(
            'flickity',
            plugins_url( '/', __FILE__ ) . 'assets/js/flickity.pkgd.min.js',
            array('jquery'),
            '2.2.1',
            true
        );
        wp_enqueue_script(
            'owl-carousel',
            plugins_url( '/', __FILE__ ) . 'assets/js/owl.carousel.min.js',
            array('jquery'),
            '2.3.4',
            true
        );
        wp_enqueue_script(
            'slick',
            plugins_url( '/', __FILE__ ) . 'assets/js/slick.min.js',
            array('jquery'),
            '1.9.0',
            true
        );
        wp_enqueue_script(
            'matchheight',
            plugins_url( '/', __FILE__ ) . 'assets/js/jquery.matchHeight.min.js',
            array('jquery'),
            '0.7.2',
            true
        );
        wp_enqueue_script(
            'isotope',
            plugins_url( '/', __FILE__ ) . 'assets/js/isotope.min.js',
            array('jquery'),
            '3.0.6',
            true
        );
        wp_enqueue_script(
            'scrollax',
            plugins_url( '/', __FILE__ ) . 'assets/js/scrollax.min.js',
            array('jquery'),
            '1.0.0',
            true
        );
        wp_enqueue_script(
            'counterup',
            plugins_url( '/', __FILE__ ) . 'assets/js/jquery.counterup.min.js',
            array('jquery'),
            '1.0',
            true
        );
        wp_enqueue_script(
            'easing',
            plugins_url( '/', __FILE__ ) . 'assets/js/jquery.easing.min.js',
            array('jquery'),
            '1.4.1',
            true
        );
        wp_enqueue_script(
            'timepicker',
            plugins_url( '/', __FILE__ ) . 'assets/js/jquery.timepicker.min.js',
            array('jquery'),
            '1.0',
            true
        );
        wp_enqueue_script(
            'datepicker',
            plugins_url( '/', __FILE__ ) . 'assets/js/bootstrap-datepicker.min.js',
            array('jquery'),
            '1.10.0',
            false
        );
        wp_enqueue_script(
            'multiscroll',
            plugins_url( '/', __FILE__ ) . 'assets/js/jquery.multiscroll.min.js',
            array('jquery'),
            '1.0',
            true
        );
        wp_enqueue_script(
            'packery-mode',
            plugins_url( '/', __FILE__ ) . 'assets/js/packery-mode.pkgd.min.js',
            array('jquery'),
            '2.1.2',
            true
        );
        wp_enqueue_script(
            'narestaurant-scripts',
            plugins_url( '/', __FILE__ ) . 'assets/js/scripts.js',
            array('jquery'),
            '1.4',
            true
        );
    }

    add_action( 'wp_enqueue_scripts', 'narestaurant_scripts_styles' );
}