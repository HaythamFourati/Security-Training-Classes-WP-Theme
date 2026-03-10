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

// Add defer attribute to theme scripts for better performance
function add_defer_to_scripts($tag, $handle, $src) {
  $defer_scripts = array('ourmainjs');
  
  if (in_array($handle, $defer_scripts)) {
    return str_replace(' src', ' defer src', $tag);
  }
  
  return $tag;
}
add_filter('script_loader_tag', 'add_defer_to_scripts', 10, 3);

/**
 * GHL API Caching Functions
 * Cache API responses to reduce load times and API calls
 */
function get_ghl_calendars_with_slots_cached() {
  $cache_key = 'ghl_calendars_with_slots';
  $cached_data = get_transient($cache_key);
  
  // Return cached data if available
  if ($cached_data !== false) {
    return $cached_data;
  }
  
  // Get API credentials
  $base_url = get_option('ghl_base_url');
  $bearer_token = get_option('ghl_bearer_token');
  $location_id = get_option('ghl_location_id');
  $api_version = get_option('ghl_api_version');
  
  if (empty($base_url) || empty($bearer_token) || empty($location_id) || empty($api_version)) {
    return false;
  }
  
  $headers = array(
    'Authorization' => 'Bearer ' . $bearer_token,
    'Version' => $api_version,
    'Content-Type' => 'application/json'
  );
  
  // STEP 1: Fetch all calendars first (single request)
  $calendars_url = $base_url . "/calendars/?locationId=" . $location_id;
  $calendars_response = wp_remote_get($calendars_url, array('headers' => $headers));
  
  if (is_wp_error($calendars_response)) {
    return false;
  }
  
  $calendars_data = json_decode(wp_remote_retrieve_body($calendars_response), true);
  
  if (empty($calendars_data['calendars'])) {
    return false;
  }
  
  // Define 3 date ranges to cover 90 days (GHL API max is 31 days per request)
  $now = new DateTime();
  $date_ranges = array(
    array(
      'start' => $now->getTimestamp() * 1000,
      'end' => (new DateTime('+30 days'))->getTimestamp() * 1000
    ),
    array(
      'start' => (new DateTime('+31 days'))->getTimestamp() * 1000,
      'end' => (new DateTime('+60 days'))->getTimestamp() * 1000
    ),
    array(
      'start' => (new DateTime('+61 days'))->getTimestamp() * 1000,
      'end' => (new DateTime('+90 days'))->getTimestamp() * 1000
    )
  );
  
  // STEP 2: Filter calendars and collect IDs for parallel requests
  $calendars_to_fetch = array();
  foreach ($calendars_data['calendars'] as $calendar) {
    // Skip inactive calendars
    if (!isset($calendar['isActive']) || $calendar['isActive'] !== true) {
      continue;
    }
    // Skip personal calendars
    if (stripos($calendar['name'], 'personal calendar') !== false) {
      continue;
    }
    $calendars_to_fetch[$calendar['id']] = $calendar;
  }
  
  if (empty($calendars_to_fetch)) {
    return array();
  }
  
  // STEP 3: Fetch all slots for all calendars across all 3 date ranges in PARALLEL
  // This makes all calendar×range API calls simultaneously for optimal performance
  $slots_responses = ghl_fetch_slots_parallel_multi_range($calendars_to_fetch, $base_url, $bearer_token, $api_version, $date_ranges);
  
  // STEP 4: Process the responses
  $available_classes = array();
  
  foreach ($calendars_to_fetch as $calendar_id => $calendar) {
    $slots_data = isset($slots_responses[$calendar_id]) ? $slots_responses[$calendar_id] : null;
    
    $upcoming_dates = array();
    $max_seats_available = 0;
    
    if (!empty($slots_data) && is_array($slots_data)) {
      $slots_to_process = array();
      
      // Handle different response formats from GHL free-slots API
      // Actual format: {"2026-01-10": {"slots": ["2026-01-10T08:30:00-05:00"]}, ...}
      if (isset($slots_data['slots'])) {
        $slots_to_process = $slots_data['slots'];
      } elseif (!empty(array_filter(array_keys($slots_data), function($k) { return preg_match('/^\d{4}-\d{2}-\d{2}$/', $k); }))) {
        // Format: {"2026-01-10": {"slots": ["2026-01-10T08:30:00-05:00"]}}
        foreach ($slots_data as $date_key => $day_data) {
          if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_key)) continue; // Skip non-date keys like traceId
          
          if (is_array($day_data)) {
            // Check if day_data has a 'slots' key
            $day_slots = isset($day_data['slots']) ? $day_data['slots'] : $day_data;
            foreach ($day_slots as $slot) {
              if (is_string($slot)) {
                // Slot is an ISO datetime string like "2026-01-10T08:30:00-05:00"
                $slots_to_process[] = array('datetime' => $slot);
              } elseif (is_array($slot)) {
                $slot['_date'] = $date_key;
                $slots_to_process[] = $slot;
              } elseif (is_numeric($slot)) {
                // Slot is a timestamp
                $slots_to_process[] = array('datetime' => $slot);
              }
            }
          }
        }
      } elseif (isset($slots_data[0])) {
        $slots_to_process = $slots_data;
      }
      
      $dates_with_slots = array();
      
      foreach ($slots_to_process as $slot) {
        $slot_time = null;
        
        // Check for full datetime string (most common GHL format)
        if (isset($slot['datetime'])) {
          $slot_time = $slot['datetime'];
        } elseif (isset($slot['startTime'])) {
          $slot_time = $slot['startTime'];
        } elseif (isset($slot['start'])) {
          $slot_time = $slot['start'];
        } elseif (isset($slot['_date'])) {
          $slot_time = $slot['_date'];
        }
        
        // Track max seats
        if (isset($slot['availableSlots']) && $slot['availableSlots'] > $max_seats_available) {
          $max_seats_available = $slot['availableSlots'];
        } elseif (isset($slot['available']) && $slot['available'] > $max_seats_available) {
          $max_seats_available = $slot['available'];
        }
        
        if ($slot_time) {
          if (is_numeric($slot_time)) {
            $date_obj = new DateTime();
            $date_obj->setTimestamp($slot_time / 1000);
          } else {
            // ISO datetime string like "2026-01-10T08:30:00-05:00"
            $date_obj = new DateTime($slot_time);
          }
          
          if ($date_obj > new DateTime()) {
            $date_key = $date_obj->format('Y-m-d');
            $time_formatted = $date_obj->format('g:i A');
            
            if (!isset($dates_with_slots[$date_key])) {
              $dates_with_slots[$date_key] = array(
                'date_obj' => $date_obj,
                'time_slots' => array()
              );
            }
            $dates_with_slots[$date_key]['time_slots'][] = $time_formatted;
          }
        }
      }
      
      foreach ($dates_with_slots as $date_key => $date_info) {
        $upcoming_dates[] = array(
          'date' => $date_info['date_obj']->format('M j, Y'),
          'time_slots' => array_unique($date_info['time_slots'])
        );
      }
      
      usort($upcoming_dates, function($a, $b) {
        return strtotime($a['date']) - strtotime($b['date']);
      });
    }
    
    // Only include classes that have upcoming dates in the 90-day window
    if (!empty($upcoming_dates)) {
      $meeting_location = '';
      if (!empty($calendar['teamMembers'][0]['meetingLocation'])) {
        $meeting_location = $calendar['teamMembers'][0]['meetingLocation'];
      }
      
      $available_classes[] = array(
        'eventId' => $calendar_id,
        'productId' => $calendar_id,
        'courseSchedule' => array('title' => $calendar['name']),
        'numSeatsAvailable' => $max_seats_available > 0 ? $max_seats_available : (isset($calendar['appoinmentPerSlot']) ? $calendar['appoinmentPerSlot'] : 20),
        'calendar_info' => $calendar,
        'booking_url' => 'https://api.warriormarketinggroup.com/widget/bookings/' . (isset($calendar['widgetSlug']) ? $calendar['widgetSlug'] : ''),
        'upcoming_dates' => $upcoming_dates,
        'meeting_location' => $meeting_location
      );
    }
  }
  
  // Cache for 5 minutes
  set_transient($cache_key, $available_classes, 5 * MINUTE_IN_SECONDS);
  
  return $available_classes;
}

/**
 * Fetch slots for multiple calendars across multiple date ranges in PARALLEL
 * This fetches all calendar×range combinations simultaneously for maximum performance
 * 
 * @param array $calendars Array of calendars keyed by calendar_id
 * @param string $base_url GHL API base URL
 * @param string $bearer_token API bearer token
 * @param string $api_version API version
 * @param array $date_ranges Array of date ranges, each with 'start' and 'end' timestamps
 * @return array Results keyed by calendar_id with merged slot data from all ranges
 */
function ghl_fetch_slots_parallel_multi_range($calendars, $base_url, $bearer_token, $api_version, $date_ranges) {
  $multi_handle = curl_multi_init();
  $curl_handles = array();
  $results = array();
  
  // Create a curl handle for each calendar × date range combination
  foreach ($calendars as $calendar_id => $calendar) {
    foreach ($date_ranges as $range_index => $range) {
      $url = $base_url . "/calendars/" . $calendar_id . "/free-slots?startDate=" . $range['start'] . "&endDate=" . $range['end'];
      
      $ch = curl_init();
      curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array(
          'Authorization: Bearer ' . $bearer_token,
          'Version: ' . $api_version,
          'Content-Type: application/json'
        ),
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYPEER => true
      ));
      
      curl_multi_add_handle($multi_handle, $ch);
      // Store handle with unique key: calendar_id + range_index
      $curl_handles[$calendar_id . '_' . $range_index] = array(
        'handle' => $ch,
        'calendar_id' => $calendar_id,
        'range_index' => $range_index
      );
    }
  }
  
  // Execute all requests in parallel
  $running = null;
  do {
    curl_multi_exec($multi_handle, $running);
    curl_multi_select($multi_handle);
  } while ($running > 0);
  
  // Collect and merge results by calendar_id
  foreach ($curl_handles as $handle_data) {
    $ch = $handle_data['handle'];
    $calendar_id = $handle_data['calendar_id'];
    
    $response = curl_multi_getcontent($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if ($http_code === 200 && $response) {
      $range_data = json_decode($response, true);
      
      // Initialize calendar result if not exists
      if (!isset($results[$calendar_id])) {
        $results[$calendar_id] = array();
      }
      
      // Merge slot data from this range into calendar results
      if (!empty($range_data) && is_array($range_data)) {
        foreach ($range_data as $key => $value) {
          // Skip metadata keys like traceId
          if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $key)) {
            // This is a date key with slots
            if (!isset($results[$calendar_id][$key])) {
              $results[$calendar_id][$key] = $value;
            } else {
              // Merge slots if date already exists from another range
              if (isset($value['slots']) && isset($results[$calendar_id][$key]['slots'])) {
                $results[$calendar_id][$key]['slots'] = array_merge(
                  $results[$calendar_id][$key]['slots'],
                  $value['slots']
                );
              }
            }
          }
        }
      }
    }
    
    curl_multi_remove_handle($multi_handle, $ch);
    curl_close($ch);
  }
  
  curl_multi_close($multi_handle);
  
  return $results;
}

/**
 * Fetch slots for multiple calendars in PARALLEL using curl_multi
 * This dramatically reduces API fetch time from N*latency to ~1*latency
 * DEPRECATED: Use ghl_fetch_slots_parallel_multi_range() for better performance with multiple date ranges
 */
function ghl_fetch_slots_parallel($calendars, $base_url, $bearer_token, $api_version, $start_timestamp, $end_timestamp) {
  $multi_handle = curl_multi_init();
  $curl_handles = array();
  $results = array();
  
  // Create a curl handle for each calendar
  foreach ($calendars as $calendar_id => $calendar) {
    $url = $base_url . "/calendars/" . $calendar_id . "/free-slots?startDate=" . $start_timestamp . "&endDate=" . $end_timestamp;
    
    $ch = curl_init();
    curl_setopt_array($ch, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer ' . $bearer_token,
        'Version: ' . $api_version,
        'Content-Type: application/json'
      ),
      CURLOPT_TIMEOUT => 30,
      CURLOPT_SSL_VERIFYPEER => true
    ));
    
    curl_multi_add_handle($multi_handle, $ch);
    $curl_handles[$calendar_id] = $ch;
  }
  
  // Execute all requests in parallel
  $running = null;
  do {
    curl_multi_exec($multi_handle, $running);
    curl_multi_select($multi_handle);
  } while ($running > 0);
  
  // Collect results
  foreach ($curl_handles as $calendar_id => $ch) {
    $response = curl_multi_getcontent($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if ($http_code === 200 && $response) {
      $results[$calendar_id] = json_decode($response, true);
    } else {
      $results[$calendar_id] = null;
    }
    
    curl_multi_remove_handle($multi_handle, $ch);
    curl_close($ch);
  }
  
  curl_multi_close($multi_handle);
  
  return $results;
}

// Clear cache when needed (can be called manually or via admin)
function clear_ghl_cache() {
  delete_transient('ghl_calendars_with_slots');
}

// Add admin bar button to clear cache
function add_clear_cache_admin_bar($wp_admin_bar) {
  if (!current_user_can('manage_options')) {
    return;
  }
  
  $wp_admin_bar->add_node(array(
    'id' => 'clear-ghl-cache',
    'title' => 'Clear GHL Cache',
    'href' => add_query_arg('clear_ghl_cache', '1'),
  ));
}
add_action('admin_bar_menu', 'add_clear_cache_admin_bar', 100);

// Handle cache clear request
function handle_clear_ghl_cache() {
  if (isset($_GET['clear_ghl_cache']) && current_user_can('manage_options')) {
    clear_ghl_cache();
    wp_redirect(remove_query_arg('clear_ghl_cache'));
    exit;
  }
}
add_action('init', 'handle_clear_ghl_cache');

/**
 * AJAX Endpoints for async loading of GHL data
 */

// Register AJAX handlers
add_action('wp_ajax_load_upcoming_classes', 'ajax_load_upcoming_classes');
add_action('wp_ajax_nopriv_load_upcoming_classes', 'ajax_load_upcoming_classes');

add_action('wp_ajax_load_ghl_calendar', 'ajax_load_ghl_calendar');
add_action('wp_ajax_nopriv_load_ghl_calendar', 'ajax_load_ghl_calendar');

// AJAX handler for upcoming classes
function ajax_load_upcoming_classes() {
  ob_start();
  get_template_part('template-parts/upcoming-classes-content');
  $html = ob_get_clean();
  
  wp_send_json_success(array('html' => $html));
}

// AJAX handler for calendar
function ajax_load_ghl_calendar() {
  ob_start();
  get_template_part('template-parts/ghl-calendar');
  $html = ob_get_clean();
  
  wp_send_json_success(array('html' => $html));
}

// Pass AJAX URL to frontend
function enqueue_ajax_scripts() {
  wp_localize_script('ourmainjs', 'ghlAjax', array(
    'ajaxUrl' => admin_url('admin-ajax.php'),
    'nonce' => wp_create_nonce('ghl_ajax_nonce')
  ));
}
add_action('wp_enqueue_scripts', 'enqueue_ajax_scripts');

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
    $base_url = get_option('ghl_base_url', '');
    printf('<input type="url" id="ghl_base_url" name="ghl_base_url" value="%s" class="regular-text" placeholder="https://services.leadconnectorhq.com" />', esc_attr($base_url));
}

function ghl_bearer_token_field_html() {
    $bearer_token = get_option('ghl_bearer_token', '');
    printf('<input type="password" id="ghl_bearer_token" name="ghl_bearer_token" value="%s" class="regular-text" />', esc_attr($bearer_token));
    echo '<p class="description">Enter your Bearer Token (without "Bearer " prefix)</p>';
}

function ghl_location_id_field_html() {
    $location_id = get_option('ghl_location_id', '');
    printf('<input type="text" id="ghl_location_id" name="ghl_location_id" value="%s" class="regular-text" />', esc_attr($location_id));
}

function ghl_api_version_field_html() {
    $api_version = get_option('ghl_api_version', '');
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
        
    </div>
    <?php
}