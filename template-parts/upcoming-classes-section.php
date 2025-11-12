<?php
/**
 * Template part for displaying the Upcoming Classes section
 */
?>

<!-- Upcoming Classes Section -->
<div id="upcoming-classes" class="text-navy pb-8 md:p-12">
  <h2 class="text-4xl text-white mb-6 text-center font-instrument-serif">Our Upcoming Classes</h2>
  <p class="text-center text-xl text-orange-200 mb-6">Please select a category from the filters below to view our upcoming classes.</p>
  <div class="flex justify-center flex-wrap gap-2 mb-12" id="class-filters">
    <button class="px-6 py-2 rounded font-semibold bg-navy text-white cursor-pointer" data-filter="all">All</button>
    <button class="px-6 py-2 rounded font-semibold bg-orange-50 text-navy border border-gray-300 cursor-pointer" data-filter="guard">Security Guard Training</button>
    <button class="px-6 py-2 rounded font-semibold bg-orange-50 text-navy border border-gray-300 cursor-pointer" data-filter="firearms">Firearms Certification</button>
    <button class="px-6 py-2 rounded font-semibold bg-orange-50 text-navy border border-gray-300 cursor-pointer" data-filter="spo">Special Police Officer (SPO) Training</button>
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
      
      // Debug: Log the actual calendars API response structure
      error_log('GHL Calendars API Response: ' . print_r($calendars_data, true));
      
      if (!empty($calendars_data['calendars'])) {
        // Process each calendar - ONE CARD PER CALENDAR
        foreach ($calendars_data['calendars'] as $calendar) {
          $calendar_id = $calendar['id'];
          
          // Check if calendar is active
          if (!isset($calendar['isActive']) || $calendar['isActive'] !== true) {
            continue;
          }
          
          // Skip calendars with no availabilities
          if (empty($calendar['availabilities'])) {
            continue;
          }
          
          // Collect all future availability dates for this calendar
          $upcoming_dates = array();
          foreach ($calendar['availabilities'] as $availability) {
            $class_date = $availability['date'];
            $date_obj = new DateTime($class_date);
            
            // Only include future dates
            if ($date_obj > new DateTime()) {
              // Get the time slots
              $time_slots = array();
              if (!empty($availability['hours'])) {
                foreach ($availability['hours'] as $hour) {
                  $open_hour = $hour['openHour'];
                  $open_minute = $hour['openMinute'];
                  $time_slots[] = sprintf('%d:%02d %s', 
                    ($open_hour > 12) ? $open_hour - 12 : ($open_hour == 0 ? 12 : $open_hour),
                    $open_minute,
                    ($open_hour >= 12) ? 'PM' : 'AM'
                  );
                }
              }
              
              $upcoming_dates[] = array(
                'date' => $date_obj->format('M j, Y'),
                'time_slots' => $time_slots
              );
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
              'numSeatsAvailable' => isset($calendar['appoinmentPerSlot']) ? $calendar['appoinmentPerSlot'] : 20,
              'calendar_info' => $calendar,
              'booking_url' => 'https://api.warriormarketinggroup.com/widget/bookings/' . $calendar['widgetSlug'],
              'upcoming_dates' => $upcoming_dates,
              'meeting_location' => $meeting_location
            );
          }
        }
      }
    }

    if (!empty($available_classes)) {
          echo '<div id="class-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 md:gap-4">';

          foreach ($available_classes as $class) {
            $calendar_info = $class['calendar_info'];
            $calendar_id = $class['productId'];
            
            $lower_title = strtolower($class['courseSchedule']['title']);
            $category = 'other';
            if (strpos($lower_title, 'guard') !== false || strpos($lower_title, 'security officer') !== false) $category = 'guard';
            elseif (strpos($lower_title, 'firearm') !== false || strpos($lower_title, 'handgun') !== false || strpos($lower_title, 'wear & carry') !== false || strpos($lower_title, 'hql') !== false) $category = 'firearms';
            elseif (strpos($lower_title, 'spo') !== false || strpos($lower_title, 'special police') !== false) $category = 'spo';

            // Clean up HTML description for display
            $description = isset($calendar_info['description']) ? wp_strip_all_tags($calendar_info['description']) : 'Professional training class available for booking.';
            
            $class_data_arg = [
              'eventId' => $class['eventId'],
              'title' => $class['courseSchedule']['title'],
              'description' => $description,
              'thumbnail' => isset($calendar_info['calendarCoverImage']) ? $calendar_info['calendarCoverImage'] : '',
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
