<?php
/**
 * Plugin Name: Instant Login
 * Plugin URI: https://github.com/Awais-857/instant-login
 * Description: Provides a customizable login page with AJAX functionality and redirect options.
 * Version: 1.0
 * Author: Awais Iqbal
 * Author URI: https://github.com/Awais-857
 * License: MIT
 * Text Domain: instant-login
 * 
 * @package Instant_Login
 */

defined('ABSPATH') || exit;

// Define plugin path constant
define('INSTANT_LOGIN_PATH', plugin_dir_path(__FILE__));

/**
 * Create login page on plugin activation
 * 
 * Generates a 'Login' page with the plugin shortcode if it doesn't exist.
 */
register_activation_hook(__FILE__, 'instant_login_create_page');

function instant_login_create_page() {
    $page = array(
        'post_title'    => 'Login',
        'post_content'  => '[instant_login_form]',
        'post_status'   => 'publish',
        'post_type'     => 'page',
        'post_name'     => 'login'
    );

    // Create page only if it doesn't already exist
    if (!get_page_by_path('login')) {
        wp_insert_post($page);
    }
}

// Load the core functionality class
require_once INSTANT_LOGIN_PATH . 'includes/class-instant-login.php';

// Initialize the plugin
add_action('plugins_loaded', function() {
    new Instant_Login();
});