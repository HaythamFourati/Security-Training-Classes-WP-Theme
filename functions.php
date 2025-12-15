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
    global $phone_number, $email, $address, $working_hours;
    $phone_number = '(443) 702-7891';
    $email = 'info@securitytrainingclasses.com';
    $address = '8585 Fort Smallwood Rd, Pasadena, MD 21122, United States';
    $working_hours = array(
        'monday_friday' => '9 AM–5 PM',
        'saturday' => '9 AM–4 PM',
        'sunday' => '9 AM–3 PM'
    );
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
 * Go High Level API Settings Page
 */

// 1. Add the menu page
function ghl_api_settings_menu() {
    add_options_page(
        'Go High Level API Settings',
        'GHL API',
        'manage_options',
        'ghl-api-settings',
        'ghl_api_settings_page_html'
    );
}
add_action('admin_menu', 'ghl_api_settings_menu');

// 2. Register settings and fields
function ghl_api_settings_init() {
    register_setting('ghl_api', 'ghl_base_url');
    register_setting('ghl_api', 'ghl_bearer_token');
    register_setting('ghl_api', 'ghl_location_id');
    register_setting('ghl_api', 'ghl_api_version');

    add_settings_section(
        'ghl_api_section',
        'API Configuration',
        'ghl_api_section_callback',
        'ghl_api'
    );

    add_settings_field(
        'ghl_base_url_field',
        'Base GET URL',
        'ghl_base_url_field_html',
        'ghl_api',
        'ghl_api_section'
    );

    add_settings_field(
        'ghl_bearer_token_field',
        'Bearer Token',
        'ghl_bearer_token_field_html',
        'ghl_api',
        'ghl_api_section'
    );

    add_settings_field(
        'ghl_location_id_field',
        'Location ID',
        'ghl_location_id_field_html',
        'ghl_api',
        'ghl_api_section'
    );

    add_settings_field(
        'ghl_api_version_field',
        'API Version',
        'ghl_api_version_field_html',
        'ghl_api',
        'ghl_api_section'
    );
}
add_action('admin_init', 'ghl_api_settings_init');

// 3. Callbacks to render the HTML
function ghl_api_section_callback() {
    echo '<p>Enter your Go High Level API configuration below.</p>';
}

function ghl_base_url_field_html() {
    $base_url = get_option('ghl_base_url', 'https://services.leadconnectorhq.com');
    printf('<input type="url" id="ghl_base_url" name="ghl_base_url" value="%s" class="regular-text" placeholder="https://services.leadconnectorhq.com" />', esc_attr($base_url));
}

function ghl_bearer_token_field_html() {
    $bearer_token = get_option('ghl_bearer_token', 'pit-103947b1-b439-4fa1-aebe-8f466f64a2b0');
    printf('<input type="password" id="ghl_bearer_token" name="ghl_bearer_token" value="%s" class="regular-text" placeholder="pit-103947b1-b439-4fa1-aebe-8f466f64a2b0" />', esc_attr($bearer_token));
    echo '<p class="description">Enter your Bearer Token (without "Bearer " prefix)</p>';
}

function ghl_location_id_field_html() {
    $location_id = get_option('ghl_location_id', '9Ys3MLT8cAMGAsVD72yV');
    printf('<input type="text" id="ghl_location_id" name="ghl_location_id" value="%s" class="regular-text" placeholder="9Ys3MLT8cAMGAsVD72yV" />', esc_attr($location_id));
}

function ghl_api_version_field_html() {
    $api_version = get_option('ghl_api_version', '2021-04-15');
    printf('<input type="text" id="ghl_api_version" name="ghl_api_version" value="%s" class="regular-text" placeholder="2021-04-15" />', esc_attr($api_version));
}

// 4. The main settings page HTML
function ghl_api_settings_page_html() {
    if (!current_user_can('manage_options')) {
        return;
    }
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('ghl_api');
            do_settings_sections('ghl_api');
            submit_button('Save Settings');
            ?>
        </form>
        
        <div style="margin-top: 20px; padding: 15px; background: #f1f1f1; border-left: 4px solid #0073aa;">
            <h3>API Configuration Reference:</h3>
            <ul>
                <li><strong>Base GET URL:</strong> https://services.leadconnectorhq.com</li>
                <li><strong>Bearer Token:</strong> pit-103947b1-b439-4fa1-aebe-8f466f64a2b0</li>
                <li><strong>Location ID:</strong> 9Ys3MLT8cAMGAsVD72yV</li>
                <li><strong>API Version:</strong> 2021-04-15</li>
            </ul>
        </div>
    </div>
    <?php
}