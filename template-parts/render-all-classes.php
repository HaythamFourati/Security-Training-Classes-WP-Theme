<?php
/**
 * Template part for rendering all available class products
 *
 * @package Security_Training_Classes
 */
?>

<!-- All Classes Section -->
<section id="all-classes" class="py-20 bg-white">
  <div class="container mx-auto px-4">
    <?php
    $base_url = get_option('ghl_base_url');
    $bearer_token = get_option('ghl_bearer_token');
    $location_id = get_option('ghl_location_id');
    $api_version = get_option('ghl_api_version');

    if (empty($base_url) || empty($bearer_token) || empty($location_id) || empty($api_version)) {
      echo '<p class="text-center text-red-500">API configuration is incomplete. Please set all fields in Settings -> GHL API.</p>';
    } else {
      // Prepare headers for Go High Level API
      $headers = array(
        'Authorization' => 'Bearer ' . $bearer_token,
        'Version' => $api_version,
        'Content-Type' => 'application/json'
      );

      // Fetch all calendars
      $calendars_url = $base_url . "/calendars/?locationId=" . $location_id;
      $calendars_response = wp_remote_get($calendars_url, array('headers' => $headers));

      if (is_wp_error($calendars_response)) {
        echo '<p class="text-center text-red-500">Failed to load class data. Please try again later.</p>';
      } else {
        $calendars_data = json_decode(wp_remote_retrieve_body($calendars_response), true);
        
        $available_classes = array();

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
          
          if (!empty($available_classes)) {
            echo '<div id="products-grid" class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">';

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
            
            // Render the modals
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
          } else {
            echo '<p class="text-center">No classes available at this time.</p>';
          }

          echo '</div>';

          // Pagination container if needed
          echo '<div id="products-pagination" class="flex justify-center items-center space-x-4 mt-12"></div>';
          
          // Make sure the modals are properly initialized
          echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
              // Initialize modal open functionality
              document.querySelectorAll("[data-modal-target]").forEach(function(button) {
                button.addEventListener("click", function() {
                  const modalId = this.getAttribute("data-modal-target");
                  const modal = document.querySelector(modalId);
                  if (modal) {
                    modal.classList.replace("hidden", "flex");
                    document.body.classList.add("overflow-hidden");
                  }
                });
              });
              
              // Initialize modal close functionality
              document.querySelectorAll("[data-modal-close]").forEach(function(button) {
                button.addEventListener("click", function() {
                  const modalId = this.getAttribute("data-modal-close");
                  const modal = document.querySelector(modalId);
                  if (modal) {
                    modal.classList.replace("flex", "hidden");
                    document.body.classList.remove("overflow-hidden");
                  }
                });
              });
              
              // Close modal when clicking on overlay
              document.querySelectorAll(".class-modal").forEach(function(modal) {
                modal.addEventListener("click", function(e) {
                  if (e.target === this) {
                    this.classList.replace("flex", "hidden");
                    document.body.classList.remove("overflow-hidden");
                  }
                });
              });
            });
          </script>';
        } else {
          echo '<p class="text-center">No classes available at this time.</p>';
        }
      }
    }
    ?>
  </div>
</section>
