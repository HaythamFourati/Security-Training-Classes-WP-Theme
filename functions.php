<?php

function boilerplate_load_assets() {
  $script_path = get_template_directory() . '/build/index.js';
  $script_asset_path = get_template_directory() . '/build/index.asset.php';
  $script_asset = file_exists($script_asset_path) ? require($script_asset_path) : array('dependencies' => array(), 'version' => filemtime($script_path));

  wp_enqueue_script(
    'ourmainjs', // Handle.
    get_template_directory_uri() . '/build/index.js',
    array_merge($script_asset['dependencies'], array('wp-element', 'react-jsx-runtime')),
    $script_asset['version'],
    true
  );
  wp_enqueue_style('ourmaincss', get_theme_file_uri('/build/index.css'));
}

add_action('wp_enqueue_scripts', 'boilerplate_load_assets');

function boilerplate_add_support() {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'boilerplate_add_support');

// Define global variables
function theme_globals() {
    global $phone_number, $email;
    $phone_number = '(443) 702-7891';
    $email = 'info@securitytrainingclasses.com';
}
add_action('after_setup_theme', 'theme_globals');

/**
 * Calculate reading time for blog posts
 */
function reading_time() {
    $content = get_post_field('post_content', get_the_ID());
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // Average reading speed is 200 words per minute
    return $reading_time;
}

/**
 * Bookeo API Settings Page
 */

// 1. Add the menu page
function bookeo_api_settings_menu() {
    add_options_page(
        'Bookeo API Settings',
        'Bookeo API',
        'manage_options',
        'bookeo-api-settings',
        'bookeo_api_settings_page_html'
    );
}
add_action('admin_menu', 'bookeo_api_settings_menu');

// 2. Register settings and fields
function bookeo_api_settings_init() {
    register_setting('bookeo_api', 'bookeo_api_key');
    register_setting('bookeo_api', 'bookeo_secret_key');

    add_settings_section(
        'bookeo_api_section',
        'API Credentials',
        'bookeo_api_section_callback',
        'bookeo_api'
    );

    add_settings_field(
        'bookeo_api_key_field',
        'API Key',
        'bookeo_api_key_field_html',
        'bookeo_api',
        'bookeo_api_section'
    );

    add_settings_field(
        'bookeo_secret_key_field',
        'Secret Key',
        'bookeo_secret_key_field_html',
        'bookeo_api',
        'bookeo_api_section'
    );
}
add_action('admin_init', 'bookeo_api_settings_init');

// 3. Callbacks to render the HTML
function bookeo_api_section_callback() {
    echo '<p>Enter your Bookeo API credentials below.</p>';
}

function bookeo_api_key_field_html() {
    $api_key = get_option('bookeo_api_key');
    printf('<input type="text" id="bookeo_api_key" name="bookeo_api_key" value="%s" class="regular-text" />', esc_attr($api_key));
}

function bookeo_secret_key_field_html() {
    $secret_key = get_option('bookeo_secret_key');
    printf('<input type="password" id="bookeo_secret_key" name="bookeo_secret_key" value="%s" class="regular-text" />', esc_attr($secret_key));
}

// 4. The main settings page HTML
function bookeo_api_settings_page_html() {
    if (!current_user_can('manage_options')) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('bookeo_api');
            do_settings_sections('bookeo_api');
            submit_button('Save Settings');
            ?>
        </form>
    </div>
    <?php
}