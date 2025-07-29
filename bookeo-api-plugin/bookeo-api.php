<?php
/**
 * Plugin Name: Bookeo API
 * Plugin URI: https://securitytrainingclasses.com
 * Description: Display upcoming classes from Bookeo API with shortcode functionality. Based on Security Training Classes theme functionality.
 * Version: 1.0.0
 * Author: Haytham Fourati
 * License: GPL v2 or later
 * Text Domain: bookeo-api
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('BOOKEO_API_PLUGIN_URL', plugin_dir_url(__FILE__));
define('BOOKEO_API_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('BOOKEO_API_VERSION', '1.0.0');

class BookeoAPIPlugin {
    
    public function __construct() {
        add_action('init', array($this, 'init'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'admin_init'));
        add_shortcode('bookeo_classes', array($this, 'display_classes_shortcode'));
        
        // AJAX handlers
        add_action('wp_ajax_bookeo_get_classes', array($this, 'ajax_get_classes'));
        add_action('wp_ajax_nopriv_bookeo_get_classes', array($this, 'ajax_get_classes'));
    }
    
    public function init() {
        // Plugin initialization
        load_plugin_textdomain('bookeo-api', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }
    
    public function enqueue_scripts() {
        wp_enqueue_style('bookeo-api-style', BOOKEO_API_PLUGIN_URL . 'assets/bookeo-api.css', array(), BOOKEO_API_VERSION);
        wp_enqueue_script('bookeo-api-script', BOOKEO_API_PLUGIN_URL . 'assets/bookeo-api.js', array('jquery'), BOOKEO_API_VERSION, true);
        
        // Localize script for AJAX
        wp_localize_script('bookeo-api-script', 'bookeo_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('bookeo_nonce')
        ));
    }
    
    public function add_admin_menu() {
        add_options_page(
            'Bookeo API Settings',
            'Bookeo API',
            'manage_options',
            'bookeo-api-settings',
            array($this, 'admin_page')
        );
    }
    
    public function admin_init() {
        register_setting('bookeo_api_settings', 'bookeo_api_key');
        register_setting('bookeo_api_settings', 'bookeo_secret_key');
        register_setting('bookeo_api_settings', 'bookeo_classes_per_page');
        register_setting('bookeo_api_settings', 'bookeo_show_filters');
        register_setting('bookeo_api_settings', 'bookeo_show_pagination');
        
        add_settings_section(
            'bookeo_api_main',
            'API Configuration',
            array($this, 'settings_section_callback'),
            'bookeo-api-settings'
        );
        
        add_settings_field(
            'bookeo_api_key',
            'API Key',
            array($this, 'api_key_callback'),
            'bookeo-api-settings',
            'bookeo_api_main'
        );
        
        add_settings_field(
            'bookeo_secret_key',
            'Secret Key',
            array($this, 'secret_key_callback'),
            'bookeo-api-settings',
            'bookeo_api_main'
        );
        
        add_settings_field(
            'bookeo_classes_per_page',
            'Classes Per Page',
            array($this, 'classes_per_page_callback'),
            'bookeo-api-settings',
            'bookeo_api_main'
        );
        
        add_settings_field(
            'bookeo_show_filters',
            'Show Category Filters',
            array($this, 'show_filters_callback'),
            'bookeo-api-settings',
            'bookeo_api_main'
        );
        
        add_settings_field(
            'bookeo_show_pagination',
            'Show Pagination',
            array($this, 'show_pagination_callback'),
            'bookeo-api-settings',
            'bookeo_api_main'
        );
    }
    
    public function admin_page() {
        ?>
        <div class="wrap">
            <h1>Bookeo API Settings</h1>
            <div class="bookeo-admin-container">
                <div class="bookeo-settings-form">
                    <form method="post" action="options.php">
                        <?php
                        settings_fields('bookeo_api_settings');
                        do_settings_sections('bookeo-api-settings');
                        submit_button();
                        ?>
                    </form>
                </div>
                
                <div class="bookeo-shortcode-info">
                    <h2>How to Use</h2>
                    <div class="bookeo-info-card">
                        <h3>Basic Shortcode</h3>
                        <code>[bookeo_classes]</code>
                        <p>Displays all upcoming classes with default settings.</p>
                    </div>
                    
                    <div class="bookeo-info-card">
                        <h3>Shortcode with Parameters</h3>
                        <code>[bookeo_classes limit="6" category="security-guard" show_filters="false"]</code>
                        <p><strong>Available Parameters:</strong></p>
                        <ul>
                            <li><code>limit</code> - Number of classes to show (default: 12)</li>
                            <li><code>category</code> - Filter by category: security-guard, firearms, spo, nra, uscca, life-saving</li>
                            <li><code>show_filters</code> - Show category filters: true/false (default: true)</li>
                            <li><code>show_pagination</code> - Show pagination: true/false (default: true)</li>
                            <li><code>columns</code> - Number of columns: 1, 2, 3, 4 (default: 3)</li>
                        </ul>
                    </div>
                    
                    <div class="bookeo-info-card">
                        <h3>Test API Connection</h3>
                        <button type="button" id="test-api-connection" class="button button-secondary">Test Connection</button>
                        <div id="api-test-result"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <style>
        .bookeo-admin-container {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 30px;
            margin-top: 20px;
        }
        
        .bookeo-settings-form {
            background: #fff;
            padding: 20px;
            border: 1px solid #ccd0d4;
            box-shadow: 0 1px 1px rgba(0,0,0,.04);
        }
        
        .bookeo-shortcode-info {
            background: #fff;
            padding: 20px;
            border: 1px solid #ccd0d4;
            box-shadow: 0 1px 1px rgba(0,0,0,.04);
        }
        
        .bookeo-info-card {
            background: #f8f9fa;
            padding: 15px;
            margin: 15px 0;
            border-left: 4px solid #ff6600;
        }
        
        .bookeo-info-card h3 {
            margin-top: 0;
            color: #1a2a45;
        }
        
        .bookeo-info-card code {
            background: #1a2a45;
            color: #fff;
            padding: 8px 12px;
            border-radius: 4px;
            display: block;
            margin: 10px 0;
            font-family: 'Courier New', monospace;
        }
        
        .bookeo-info-card ul {
            margin: 10px 0;
            padding-left: 20px;
        }
        
        .bookeo-info-card li {
            margin: 5px 0;
        }
        
        #api-test-result {
            margin-top: 10px;
            padding: 10px;
            border-radius: 4px;
            display: none;
        }
        
        #api-test-result.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        #api-test-result.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        </style>
        
        <script>
        jQuery(document).ready(function($) {
            $('#test-api-connection').click(function() {
                var button = $(this);
                var result = $('#api-test-result');
                
                button.prop('disabled', true).text('Testing...');
                result.hide();
                
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'bookeo_test_connection',
                        nonce: '<?php echo wp_create_nonce('bookeo_test_nonce'); ?>'
                    },
                    success: function(response) {
                        if (response.success) {
                            result.removeClass('error').addClass('success')
                                  .html('<strong>Success!</strong> Connected to Bookeo API. Found ' + response.data.count + ' products.')
                                  .show();
                        } else {
                            result.removeClass('success').addClass('error')
                                  .html('<strong>Error:</strong> ' + response.data.message)
                                  .show();
                        }
                    },
                    error: function() {
                        result.removeClass('success').addClass('error')
                              .html('<strong>Error:</strong> Failed to test connection.')
                              .show();
                    },
                    complete: function() {
                        button.prop('disabled', false).text('Test Connection');
                    }
                });
            });
        });
        </script>
        <?php
    }
    
    public function settings_section_callback() {
        echo '<p>Enter your Bookeo API credentials below. You can find these in your Bookeo account settings.</p>';
    }
    
    public function api_key_callback() {
        $value = get_option('bookeo_api_key', '');
        echo '<input type="text" id="bookeo_api_key" name="bookeo_api_key" value="' . esc_attr($value) . '" class="regular-text" />';
        echo '<p class="description">Your Bookeo API Key</p>';
    }
    
    public function secret_key_callback() {
        $value = get_option('bookeo_secret_key', '');
        echo '<input type="password" id="bookeo_secret_key" name="bookeo_secret_key" value="' . esc_attr($value) . '" class="regular-text" />';
        echo '<p class="description">Your Bookeo Secret Key</p>';
    }
    
    public function classes_per_page_callback() {
        $value = get_option('bookeo_classes_per_page', '12');
        echo '<input type="number" id="bookeo_classes_per_page" name="bookeo_classes_per_page" value="' . esc_attr($value) . '" min="1" max="50" />';
        echo '<p class="description">Default number of classes to display per page</p>';
    }
    
    public function show_filters_callback() {
        $value = get_option('bookeo_show_filters', '1');
        echo '<input type="checkbox" id="bookeo_show_filters" name="bookeo_show_filters" value="1" ' . checked(1, $value, false) . ' />';
        echo '<label for="bookeo_show_filters">Show category filter buttons</label>';
    }
    
    public function show_pagination_callback() {
        $value = get_option('bookeo_show_pagination', '1');
        echo '<input type="checkbox" id="bookeo_show_pagination" name="bookeo_show_pagination" value="1" ' . checked(1, $value, false) . ' />';
        echo '<label for="bookeo_show_pagination">Show pagination controls</label>';
    }
    
    public function display_classes_shortcode($atts) {
        $atts = shortcode_atts(array(
            'limit' => get_option('bookeo_classes_per_page', '12'),
            'category' => '',
            'show_filters' => get_option('bookeo_show_filters', '1') ? 'true' : 'false',
            'show_pagination' => get_option('bookeo_show_pagination', '1') ? 'true' : 'false',
            'columns' => '3'
        ), $atts, 'bookeo_classes');
        
        $unique_id = 'bookeo-classes-' . uniqid();
        
        ob_start();
        ?>
        <div id="<?php echo esc_attr($unique_id); ?>" class="bookeo-classes-container" 
             data-limit="<?php echo esc_attr($atts['limit']); ?>"
             data-category="<?php echo esc_attr($atts['category']); ?>"
             data-show-filters="<?php echo esc_attr($atts['show_filters']); ?>"
             data-show-pagination="<?php echo esc_attr($atts['show_pagination']); ?>"
             data-columns="<?php echo esc_attr($atts['columns']); ?>">
            
            <?php if ($atts['show_filters'] === 'true'): ?>
            <div class="bookeo-filters">
                <button class="bookeo-filter-btn active" data-filter="all">All Classes</button>
                <button class="bookeo-filter-btn" data-filter="security-guard">Security Guard</button>
                <button class="bookeo-filter-btn" data-filter="firearms">Firearms</button>
                <button class="bookeo-filter-btn" data-filter="spo">Special Police</button>
                <button class="bookeo-filter-btn" data-filter="nra">NRA Classes</button>
                <button class="bookeo-filter-btn" data-filter="uscca">USCCA Classes</button>
                <button class="bookeo-filter-btn" data-filter="life-saving">Life Saving</button>
            </div>
            <?php endif; ?>
            
            <div class="bookeo-loading">
                <div class="bookeo-spinner"></div>
                <p>Loading classes...</p>
            </div>
            
            <div class="bookeo-classes-grid" style="display: none;"></div>
            
            <?php if ($atts['show_pagination'] === 'true'): ?>
            <div class="bookeo-pagination" style="display: none;"></div>
            <?php endif; ?>
            
            <div class="bookeo-error" style="display: none;">
                <p>Unable to load classes. Please check your API configuration.</p>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
    
    public function ajax_get_classes() {
        check_ajax_referer('bookeo_nonce', 'nonce');
        
        $page = intval($_POST['page'] ?? 1);
        $limit = intval($_POST['limit'] ?? 12);
        $category = sanitize_text_field($_POST['category'] ?? '');
        
        $classes = $this->fetch_bookeo_classes($category, $page, $limit);
        
        if (is_wp_error($classes)) {
            wp_send_json_error(array('message' => $classes->get_error_message()));
        }
        
        wp_send_json_success($classes);
    }
    
    private function fetch_bookeo_classes($category = '', $page = 1, $limit = 12) {
        $api_key = get_option('bookeo_api_key');
        $secret_key = get_option('bookeo_secret_key');
        
        if (empty($api_key) || empty($secret_key)) {
            return new WP_Error('missing_credentials', 'API credentials not configured');
        }
        
        $auth = base64_encode($api_key . ':' . $secret_key);
        
        $response = wp_remote_get('https://api.bookeo.com/v2/products', array(
            'headers' => array(
                'Authorization' => 'Basic ' . $auth,
                'Content-Type' => 'application/json'
            ),
            'timeout' => 30
        ));
        
        if (is_wp_error($response)) {
            return $response;
        }
        
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        
        if (!$data || !isset($data['data'])) {
            return new WP_Error('invalid_response', 'Invalid API response');
        }
        
        $classes = $data['data'];
        
        // Filter by category if specified
        if (!empty($category) && $category !== 'all') {
            $classes = array_filter($classes, function($class) use ($category) {
                return $this->get_class_category($class) === $category;
            });
        }
        
        // Filter only upcoming classes
        $classes = array_filter($classes, function($class) {
            return $this->is_upcoming_class($class);
        });
        
        $total = count($classes);
        $offset = ($page - 1) * $limit;
        $classes = array_slice($classes, $offset, $limit);
        
        return array(
            'classes' => $classes,
            'total' => $total,
            'page' => $page,
            'pages' => ceil($total / $limit)
        );
    }
    
    private function get_class_category($class) {
        $name = strtolower($class['name'] ?? '');
        
        if (strpos($name, 'security guard') !== false || strpos($name, 'guard') !== false) {
            return 'security-guard';
        } elseif (strpos($name, 'firearm') !== false || strpos($name, 'gun') !== false || strpos($name, 'pistol') !== false) {
            return 'firearms';
        } elseif (strpos($name, 'special police') !== false || strpos($name, 'spo') !== false) {
            return 'spo';
        } elseif (strpos($name, 'nra') !== false) {
            return 'nra';
        } elseif (strpos($name, 'uscca') !== false) {
            return 'uscca';
        } elseif (strpos($name, 'cpr') !== false || strpos($name, 'acls') !== false || strpos($name, 'pals') !== false) {
            return 'life-saving';
        }
        
        return 'other';
    }
    
    private function is_upcoming_class($class) {
        // This would need to be implemented based on Bookeo's API structure
        // For now, we'll assume all classes are upcoming
        return true;
    }
}

// AJAX handler for testing API connection
add_action('wp_ajax_bookeo_test_connection', 'bookeo_test_api_connection');
function bookeo_test_api_connection() {
    check_ajax_referer('bookeo_test_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_send_json_error(array('message' => 'Insufficient permissions'));
    }
    
    $api_key = get_option('bookeo_api_key');
    $secret_key = get_option('bookeo_secret_key');
    
    if (empty($api_key) || empty($secret_key)) {
        wp_send_json_error(array('message' => 'Please enter both API Key and Secret Key'));
    }
    
    $auth = base64_encode($api_key . ':' . $secret_key);
    
    $response = wp_remote_get('https://api.bookeo.com/v2/products', array(
        'headers' => array(
            'Authorization' => 'Basic ' . $auth,
            'Content-Type' => 'application/json'
        ),
        'timeout' => 15
    ));
    
    if (is_wp_error($response)) {
        wp_send_json_error(array('message' => $response->get_error_message()));
    }
    
    $code = wp_remote_retrieve_response_code($response);
    if ($code !== 200) {
        wp_send_json_error(array('message' => 'API returned status code: ' . $code));
    }
    
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    
    if (!$data || !isset($data['data'])) {
        wp_send_json_error(array('message' => 'Invalid API response format'));
    }
    
    wp_send_json_success(array('count' => count($data['data'])));
}

// Initialize the plugin
new BookeoAPIPlugin();
