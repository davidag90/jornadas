<?php

/**
 * @package Bootscore Child
 *
 * @version 6.0.0
 */


// Exit if accessed directly
defined('ABSPATH') || exit;


/**
 * Enqueue scripts and styles
 */
add_action('wp_enqueue_scripts', 'bootscore_child_enqueue_styles');
function bootscore_child_enqueue_styles() {

  // Compiled main.css
  $modified_bootscoreChildCss = date('YmdHi', filemtime(get_stylesheet_directory() . '/assets/css/main.css'));
  wp_enqueue_style('main', get_stylesheet_directory_uri() . '/assets/css/main.css', array('parent-style'), $modified_bootscoreChildCss);

  // style.css
  wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');

  // Send home URL to environment params JS file
  wp_enqueue_script('env', get_stylesheet_directory_uri() . '/assets/js/env.js', array(), false, false);
  wp_localize_script('env', 'envParams', array(
    'HOME_URL' => esc_url(home_url()) . '/'
  ));

  if (is_page('inscripciones')) {
    wp_enqueue_script('inscripcion', get_stylesheet_directory_uri() . '/assets/js/inscripcion.js', array('env'), null, true);
  }
}

// Add custom shortcodes for custom post type showing
add_action('after_setup_theme', 'include_custom_shortcodes');

function include_custom_shortcodes() {
  require_once(__DIR__ . '/inc/shortcodes.php');
}

/* Empty cart before adding any new product to prevent buying multiple items
since its no allowed buy the site owner */
function single_item_cart($new_item, $product_id, $quantity) {
  if (!WC()->cart->is_empty()) {
    WC()->cart->empty_cart();
  }

  return $new_item;
}

add_filter('woocommerce_add_to_cart_validation', 'single_item_cart', 20, 3);

// Disable AJAX Cart
function register_ajax_cart() {
}

add_action('after_setup_theme', 'register_ajax_cart');

// Customizes checkout place order button to adapt to Bootstrap standards
function wc_custom_order_button_html($html) {
  $html = str_replace('id="place_order"', '', $html);
  $html = str_replace('class="button alt"', 'class="btn btn-warning d-block w-100"', $html);

  return $html;
}

add_filter('woocommerce_order_button_html', 'wc_custom_order_button_html');
