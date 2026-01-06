<?php
/**
 * Template part for displaying the Upcoming Classes section
 */
?>

<!-- Upcoming Classes Section -->
<div id="upcoming-classes" class="text-navy pb-8 md:p-12">
  <h2 class="text-4xl text-white mb-6 text-center font-instrument-serif">Our Upcoming Classes</h2>
  
  <!-- Filter Section with Enhanced Visibility -->
  <div class="mb-8">
    <div class="text-center mb-4">
      <p class="text-2xl font-bold text-white mb-2">👇 SELECT A CATEGORY BELOW 👇</p>
      <p class="text-lg text-orange-200">Click on any button to filter classes by type</p>
    </div>
    <div class="flex justify-center flex-wrap gap-3" id="class-filters">
      <button class="px-8 py-4 rounded-lg font-bold text-lg bg-safety-orange text-white cursor-pointer shadow-lg hover:shadow-xl hover:brightness-110 transform hover:scale-105 transition-all flex items-center gap-2" data-filter="all">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
        All Classes
      </button>
      <button class="px-8 py-4 rounded-lg font-bold text-lg bg-white text-navy border-4 border-navy cursor-pointer shadow-lg hover:shadow-xl hover:bg-safety-orange hover:text-white hover:border-safety-orange transform hover:scale-105 transition-all flex items-center gap-2" data-filter="spo">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" /></svg>
        SPO Training
      </button>
      <button class="px-8 py-4 rounded-lg font-bold text-lg bg-white text-navy border-4 border-navy cursor-pointer shadow-lg hover:shadow-xl hover:bg-safety-orange hover:text-white hover:border-safety-orange transform hover:scale-105 transition-all flex items-center gap-2" data-filter="firearms">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
        Firearms Certification
      </button>
      <button class="px-8 py-4 rounded-lg font-bold text-lg bg-white text-navy border-4 border-navy cursor-pointer shadow-lg hover:shadow-xl hover:bg-safety-orange hover:text-white hover:border-safety-orange transform hover:scale-105 transition-all flex items-center gap-2" data-filter="wear-carry">
        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 539.5 539.5"><path d="m189.188 257.814 10.607 10.607-13.667 13.667-10.607-10.607z"/><path d="m406.798 108.07 23.326-23.325-55.99-55.989-24.577 68.693-151.87 151.867 10.607 10.607 67.703-67.702 65.928 65.926-65.438 65.436-.76.761-.516.942c-9.301 16.995-11.158 31.23-9.563 42.625-5.178-1.603-8.831-4.387-12.61-7.283-6.271-4.806-14.076-10.787-27.191-7.509-6.501 1.625-11.738 4.12-16.36 6.321-9.851 4.693-14.806 7.052-25.801-.826-14.766-11.019-22.768-38.177-23.769-50.314l18.543-18.542-10.607-10.607-22.959 22.96-.074 2.998c-.072 2.931.371 7.339 1.393 12.566-10.64 11.568-31.049 17.146-31.26 17.203a7.5 7.5 0 0 0 1.255 14.719l43.52 3.897c3.573 5.864 7.85 11.242 12.892 15.481 11.987 45.055 37.208 76.983 56.433 95.95 21.234 20.95 46.646 37.554 67.974 44.415l4.361 1.403L395.93 416.2l-18.955.611a94.18 94.18 0 0 1-3.044.048c-26.274 0-68.353-10.224-85.895-33.386 25.337-3.443 45.093-17.545 54.06-39.19 8.058-19.454 5.023-41.302-7.513-57.581l28.556-28.556-35.579-35.576 96.868-96.87-17.63-17.63zM145.93 337.198a70.666 70.666 0 0 0 4.688-3.354c.45 1.294.926 2.595 1.433 3.901l-6.121-.547zm213.891 93.898-62.468 62.468c-32.44-12.305-84.244-51.872-106.214-115.305 9.839 1.839 17.64-1.866 24.799-5.275 4.181-1.992 8.503-4.051 13.548-5.312 5.798-1.452 8.237.117 14.429 4.861 5.798 4.444 13.531 10.342 26.813 11.54a53.068 53.068 0 0 0 2.101 3.75c16.356 26.61 55.946 40.066 86.992 43.273zm-31.585-92.552c-7.386 17.831-24.786 29.003-47.121 30.565-2.493-10.594-.251-22.545 6.754-35.694l.185-.185c1.468 2.535 3.342 4.832 5.571 6.709 4.367 3.677 9.773 5.559 15.718 5.559 2.8 0 5.722-.418 8.707-1.263l-4.082-14.434c-4.517 1.276-8.11.827-10.683-1.338-2.087-1.757-3.297-4.447-3.673-6.792l24.261-24.261c8.438 11.913 10.184 27.083 4.363 41.134zm52.042-282.433 5.309 5.308-11.224 11.224 5.915-16.532zm-63.326 155.852-30.348-30.348 109.589-109.59 12.718 12.72-18.023 18.022v-.001l-62.29 62.29 10.607 10.607 56.987-56.986 7.022 7.022-86.262 86.264z"/><path d="M256.887 398.854a23.272 23.272 0 0 0-16.562 6.859c-9.132 9.132-9.132 23.991 0 33.123a23.27 23.27 0 0 0 16.562 6.859h.001a23.27 23.27 0 0 0 16.56-6.858c4.424-4.424 6.859-10.306 6.859-16.563s-2.437-12.139-6.859-16.561a23.272 23.272 0 0 0-16.561-6.859zm5.953 29.376a8.361 8.361 0 0 1-5.952 2.466 8.363 8.363 0 0 1-5.955-2.467c-3.284-3.283-3.284-8.625 0-11.908 1.59-1.591 3.705-2.467 5.954-2.467s4.363.876 5.954 2.467a8.366 8.366 0 0 1 2.466 5.954c0 2.25-.876 4.366-2.467 5.955zM300.324 463.924a10.56 10.56 0 0 0 7.516-3.114c4.14-4.144 4.139-10.884-.005-15.027a10.56 10.56 0 0 0-7.512-3.109 10.547 10.547 0 0 0-7.51 3.109 10.555 10.555 0 0 0-3.115 7.515 10.56 10.56 0 0 0 3.115 7.518 10.563 10.563 0 0 0 7.511 3.108zm-3.091-13.721c.813-.813 1.94-1.279 3.091-1.279s2.277.466 3.094 1.281a4.41 4.41 0 0 1 1.28 3.094c0 1.152-.468 2.28-1.278 3.09a4.406 4.406 0 0 1-3.097 1.284 4.413 4.413 0 0 1-3.093-1.281 4.382 4.382 0 0 1 .003-6.189zM216.968 327.783l13.243-13.242 20.005 20.005 76.399-76.398-50.618-50.617-76.399 76.397 20.006 20.006-13.243 13.242 10.607 10.607zm33.248-14.45-9.399-9.399 55.186-55.186 9.399 9.399-55.186 55.186zm-29.405-29.405 55.186-55.185 9.398 9.398-55.186 55.185-9.398-9.398zM318.954 195.92l-10.607-10.608 12.75-12.749 10.606 10.607z"/></svg>
        Wear and Carry
      </button>
      <button class="px-8 py-4 rounded-lg font-bold text-lg bg-white text-navy border-4 border-navy cursor-pointer shadow-lg hover:shadow-xl hover:bg-safety-orange hover:text-white hover:border-safety-orange transform hover:scale-105 transition-all flex items-center gap-2" data-filter="guard">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg>
        Security Guard
      </button>
    </div>
  </div>
  <?php
  $base_url = get_option('ghl_base_url');
  $bearer_token = get_option('ghl_bearer_token');
  $location_id = get_option('ghl_location_id');
  $api_version = get_option('ghl_api_version');

  if (empty($base_url) || empty($bearer_token) || empty($location_id) || empty($api_version)) {
    echo '<p class="text-center text-red-500">API configuration is incomplete. Please set all fields in Settings -> GHL API.</p>';
  } else {
    // Set the timezone to avoid warnings
    date_default_timezone_set('UTC');
    $startTime = date('Y-m-d');
    $endTime = date('Y-m-d', strtotime('+30 days'));

    // Prepare headers for Go High Level API
    $headers = array(
      'Authorization' => 'Bearer ' . $bearer_token,
      'Version' => $api_version,
      'Content-Type' => 'application/json'
    );

    // 1. Fetch all calendars
    $calendars_url = $base_url . "/calendars/?locationId=" . $location_id;
    $calendars_response = wp_remote_get($calendars_url, array('headers' => $headers));

    $available_classes = array();
    
    if (!is_wp_error($calendars_response)) {
      $calendars_data = json_decode(wp_remote_retrieve_body($calendars_response), true);
      
      
      if (!empty($calendars_data['calendars'])) {
        // Define date range for fetching slots (next 30 days - GHL API max is 31 days)
        $start_date = new DateTime();
        $end_date = new DateTime('+30 days');
        $start_timestamp = $start_date->getTimestamp() * 1000; // GHL uses milliseconds
        $end_timestamp = $end_date->getTimestamp() * 1000;
        
        
        // Process each calendar - ONE CARD PER CALENDAR
        foreach ($calendars_data['calendars'] as $calendar) {
          $calendar_id = $calendar['id'];
          
          // Check if calendar is active
          if (!isset($calendar['isActive']) || $calendar['isActive'] !== true) {
            continue;
          }
          
          // Skip personal calendars
          if (stripos($calendar['name'], 'personal calendar') !== false) {
            continue;
          }
          
          // Fetch free slots for this calendar from GHL API
          $slots_url = $base_url . "/calendars/" . $calendar_id . "/free-slots?startDate=" . $start_timestamp . "&endDate=" . $end_timestamp;
          $slots_response = wp_remote_get($slots_url, array('headers' => $headers));
          
          
          // Collect all future availability dates for this calendar
          $upcoming_dates = array();
          
          if (!is_wp_error($slots_response)) {
            $slots_data = json_decode(wp_remote_retrieve_body($slots_response), true);
            
            // Process slots - handle different GHL response formats
            if (!empty($slots_data) && is_array($slots_data)) {
              $slots_to_process = array();
              
              // Format 1: {slots: [...]}
              if (isset($slots_data['slots'])) {
                $slots_to_process = $slots_data['slots'];
              }
              // Format 2: Keyed by date {"2026-01-15": [{...}], ...}
              elseif (!empty(array_filter(array_keys($slots_data), function($k) { return preg_match('/^\d{4}-\d{2}-\d{2}$/', $k); }))) {
                foreach ($slots_data as $date_key => $day_slots) {
                  if (is_array($day_slots)) {
                    foreach ($day_slots as $slot) {
                      $slot['_date'] = $date_key;
                      $slots_to_process[] = $slot;
                    }
                  }
                }
              }
              // Format 3: Direct array [{...}, {...}]
              elseif (isset($slots_data[0])) {
                $slots_to_process = $slots_data;
              }
              
              // Group slots by date and track max available seats
              $dates_with_slots = array();
              $max_seats_available = 0;
              foreach ($slots_to_process as $slot) {
                $slot_time = null;
                
                // Try different slot time formats
                if (isset($slot['startTime'])) {
                  $slot_time = $slot['startTime'];
                } elseif (isset($slot['start'])) {
                  $slot_time = $slot['start'];
                } elseif (isset($slot['_date'])) {
                  $slot_time = $slot['_date'];
                }
                
                // Track available seats - find the highest from any slot
                if (isset($slot['availableSlots']) && $slot['availableSlots'] > $max_seats_available) {
                  $max_seats_available = $slot['availableSlots'];
                } elseif (isset($slot['available']) && $slot['available'] > $max_seats_available) {
                  $max_seats_available = $slot['available'];
                }
                
                if ($slot_time) {
                  // Handle timestamp (milliseconds) or ISO date string
                  if (is_numeric($slot_time)) {
                    $date_obj = new DateTime();
                    $date_obj->setTimestamp($slot_time / 1000);
                  } else {
                    $date_obj = new DateTime($slot_time);
                  }
                  
                  // Only include future dates
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
              
              // Convert to upcoming_dates format
              foreach ($dates_with_slots as $date_key => $date_info) {
                $upcoming_dates[] = array(
                  'date' => $date_info['date_obj']->format('M j, Y'),
                  'time_slots' => array_unique($date_info['time_slots'])
                );
              }
              
              // Sort by date
              usort($upcoming_dates, function($a, $b) {
                return strtotime($a['date']) - strtotime($b['date']);
              });
            }
          }
          
          // Only create a class card if there are upcoming dates
          if (!empty($upcoming_dates)) {
            // Get meeting location from team members if available
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
      }
    }

    if (!empty($available_classes)) {
          // ============================================
          // CATEGORY CONFIGURATION - Easy to Edit
          // ============================================
          // Add or remove keywords for each category here
          $category_keywords = array(
            'spo' => array('spo', 'special police'),
            'firearms' => array('hql', 'certification', 'permit'),
            'wear-carry' => array('wear', 'carry'),
            'guard' => array('guard', 'security officer')
          );
          // ============================================
          
          echo '<div id="class-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 md:gap-4">';

          foreach ($available_classes as $class) {
            $calendar_info = $class['calendar_info'];
            $calendar_id = $class['productId'];
            
            $lower_title = strtolower($class['courseSchedule']['title']);
            $matched_categories = array();
            
            // Check each category's keywords
            foreach ($category_keywords as $category_name => $keywords) {
              foreach ($keywords as $keyword) {
                if (strpos($lower_title, $keyword) !== false) {
                  $matched_categories[] = $category_name;
                  break; // Found a match for this category, move to next category
                }
              }
            }
            
            // If no categories matched, set to 'other'
            if (empty($matched_categories)) {
              $matched_categories[] = 'other';
            }
            
            // Remove duplicates and join all categories with space for CSS classes
            $category = implode(' ', array_unique($matched_categories));

            // Clean up HTML description for display
            $description = isset($calendar_info['description']) ? wp_strip_all_tags($calendar_info['description']) : 'Professional training class available for booking.';
            
            $class_data_arg = [
              'eventId' => $class['eventId'],
              'title' => $class['courseSchedule']['title'],
              'description' => $description,
              'thumbnail' => !empty($calendar_info['calendarCoverImage']) ? $calendar_info['calendarCoverImage'] : get_template_directory_uri() . '/images/default-class-cover.svg',
              'seats' => $class['numSeatsAvailable'],
              'booking_url' => isset($class['booking_url']) ? $class['booking_url'] : "#",
              'category' => $category,
              'upcoming_dates' => $class['upcoming_dates'],
              'meeting_location' => $class['meeting_location']
            ];

            get_template_part('template-parts/class-card', null, ['class_data' => $class_data_arg]);
          }

          echo '</div>';

          // Pagination container
          echo '<div id="class-pagination" class="flex justify-center items-center space-x-4 mt-12"></div>';

      // Render the modals outside of the main grid
      if (!empty($available_classes)) {
        foreach ($available_classes as $class) {
          $calendar_info = $class['calendar_info'];

          $class_data_arg = [
            'eventId' => $class['eventId'],
            'title' => $class['courseSchedule']['title'],
            'description' => isset($calendar_info['description']) ? $calendar_info['description'] : 'Professional training class available for booking.',
            'booking_url' => isset($class['booking_url']) ? $class['booking_url'] : "#",
            'upcoming_dates' => $class['upcoming_dates'],
            'meeting_location' => $class['meeting_location'],
            'seats' => $class['numSeatsAvailable']
          ];

          get_template_part('template-parts/class-modal', null, ['class_data' => $class_data_arg]);
        }
      }
    } else {
      echo '<p class="text-center">No upcoming classes available at this time.</p>';
    }
  }
  ?>
</div>
