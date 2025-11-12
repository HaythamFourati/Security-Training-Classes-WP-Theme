<?php
/**
 * Template part for rendering filtered class products
 *
 * @package Security_Training_Classes
 */

// Get the filter term from the args or set a default
$filter_term = isset($args['filter_term']) ? $args['filter_term'] : '';

// Define the section ID based on the filter term
$section_id = !empty($filter_term) ? 'filtered-classes-' . sanitize_title($filter_term) : 'filtered-classes';
?>

<!-- Filtered Classes Section -->
<section id="<?php echo $section_id; ?>" class="py-20 bg-white">
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
            
            // If filter term is provided, check if calendar name or description contains the term
            if (!empty($filter_term)) {
              $name_match = stripos($calendar['name'], $filter_term) !== false;
              $desc_match = isset($calendar['description']) ? stripos($calendar['description'], $filter_term) !== false : false;
              
              // Only include calendars that match the filter term
              if (!$name_match && !$desc_match) {
                continue;
              }
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
          
          if (!empty($available_classes)) {
            echo '<div id="filtered-products-grid" class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">';
            
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
            echo '<p class="text-center">No ' . esc_html(strtolower($filter_term)) . ' classes available at this time.</p>';
          }

          // Pagination container if needed for larger filtered lists
          if (!empty($available_classes) && count($available_classes) > 6) {
            echo '<div id="filtered-products-pagination" class="flex justify-center items-center space-x-4 mt-12"></div>';
          }
          
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
