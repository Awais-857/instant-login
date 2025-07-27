<?php
/**
 * Instant Login - Core Functionality
 * 
 * Handles the main operations of the Instant Login plugin including:
 * - Shortcode registration
 * - AJAX login handling
 * - Asset management
 * - Settings page configuration
 * 
 * @package Instant_Login
 */

if (!defined('ABSPATH')) exit;

class Instant_Login {

    /**
     * Class constructor
     * 
     * Initializes plugin functionality by registering hooks.
     */
    public function __construct() {
        // Register shortcode for login form
        add_shortcode('instant_login_form', [$this, 'render_login_form']);
        
        // Handle AJAX login for both authenticated and non-authenticated users
        add_action('wp_ajax_instant_login', [$this, 'handle_login']);
        add_action('wp_ajax_nopriv_instant_login', [$this, 'handle_login']);
        
        // Enqueue CSS and JavaScript assets
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
        
        // Add settings page to admin menu
        add_action('admin_menu', [$this, 'add_settings_page']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    /**
     * Add settings page to WordPress admin menu
     */
    public function add_settings_page() {
        add_options_page(
            'Instant Login Settings',
            'Instant Login',
            'manage_options',
            'instant-login-settings',
            [$this, 'render_settings_page']
        );
    }

    /**
     * Register plugin settings
     */
    public function register_settings() {
        register_setting('instant_login_settings', 'instant_login_redirect_url');
    }

    /**
     * Render settings page HTML
     */
    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1>Instant Login Settings</h1>
            <form method="post" action="options.php">
                <?php settings_fields('instant_login_settings'); ?>
                <table class="form-table">
                    <tr>
                        <th scope="row">Redirect URL</th>
                        <td>
                            <input type="url" name="instant_login_redirect_url" 
                                   value="<?php echo esc_url(get_option('instant_login_redirect_url')); ?>" 
                                   class="regular-text">
                            <p class="description">Leave blank to show success message instead of redirecting</p>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }

    /**
     * Render login form HTML
     * 
     * @return string HTML content for login form
     */
    public function render_login_form() {
        ob_start();
        include plugin_dir_path(__FILE__) . '../templates/custom-login-template.php';
        return ob_get_clean();
    }

    /**
     * Handle AJAX login requests
     * 
     * Processes login credentials and returns JSON response.
     * Verifies nonce for security.
     */
    public function handle_login() {
        // Verify nonce for security
        check_ajax_referer('instant-login-nonce', 'security');
        
        // Prepare login credentials
        $credentials = [
            'user_login'    => sanitize_email($_POST['email']),
            'user_password' => sanitize_text_field($_POST['password']),
            'remember'      => true
        ];
        
        // Get redirect URL from options
        $redirect_url = get_option('instant_login_redirect_url', '');
        
        // Attempt user login
        $user = wp_signon($credentials, false);
        
        if (is_wp_error($user)) {
            // Send error response for invalid credentials
            wp_send_json_error('Incorrect Email or password!');
        } else {
            if (!empty($redirect_url)) {
                // Send success response with redirect URL
                wp_send_json_success(['redirect' => esc_url($redirect_url)]);
            } else {
                // Send success message
                wp_send_json_success('Login Successful!');
            }
        }
    }

    /**
     * Enqueue plugin assets
     * 
     * Loads CSS and JavaScript files required for the plugin.
     * Localizes script variables for AJAX requests.
     */
    public function enqueue_assets() {
        // Enqueue stylesheet
        wp_enqueue_style(
            'instant-login-css',
            plugins_url('assets/css/style.css', dirname(__FILE__))
        );
        
        // Enqueue JavaScript with jQuery dependency
        wp_enqueue_script(
            'instant-login-js',
            plugins_url('assets/js/script.js', dirname(__FILE__)),
            ['jquery'],
            null,
            true
        );
        
        // Localize script variables for AJAX
        wp_localize_script('instant-login-js', 'instant_login_vars', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('instant-login-nonce')
        ]);
    }
}