<?php

// Save Admin Page Options Basic
function rcafe_bw_settings_save_func(){
  if(wp_verify_nonce( $_POST['nonce'], 'rcafe-bw-nonce' ) && current_user_can( 'manage_options' ) ) {
    $updated_value = [];
    if(isset($_POST['data']) && !empty($_POST['data'])) {
      foreach ($_POST['data'] as $option) {
        $updated_value[$option['name']] = $option['value'];
      }
      update_option('rcafe_bw_settings', $updated_value);      
    } else {
      update_option('rcafe_bw_settings', '');    
    }
  }
  die();
}
add_action( 'wp_ajax_rcafe_bw_settings_save', 'rcafe_bw_settings_save_func' );

function rctl_bw_toggle_submit_func(){
  if(wp_verify_nonce( $_POST['nonce'], 'rcafe-toggle-bw-nonce' ) && current_user_can( 'manage_options' )) {
    update_option('rcafe_bw_toggle', $_POST['data']);
  }
  die();
}
add_action( 'wp_ajax_rctl_bw_toggle_submit', 'rctl_bw_toggle_submit_func' );

// Save Admin Page Options Unique
function rcafe_uw_settings_save_func(){
  if(wp_verify_nonce( $_POST['nonce'], 'rcafe-uw-nonce' ) && current_user_can( 'manage_options' ) ) {
    $updated_value = [];
    if(isset($_POST['data']) && !empty($_POST['data'])) {
      foreach ($_POST['data'] as $option) {
        $updated_value[$option['name']] = $option['value'];
      }
      update_option('rcafe_uw_settings', $updated_value);      
    } else {
      update_option('rcafe_uw_settings', '');    
    }
  }
  die();
}
add_action( 'wp_ajax_rcafe_uw_settings_save', 'rcafe_uw_settings_save_func' );

function rctl_uw_toggle_submit_func(){
  if(wp_verify_nonce( $_POST['nonce'], 'rcafe-toggle-uw-nonce' ) && current_user_can( 'manage_options' ) ) {
    update_option('rcafe_uw_toggle', $_POST['data']);
  }
  die();
}
add_action( 'wp_ajax_rctl_uw_toggle_submit', 'rctl_uw_toggle_submit_func' );