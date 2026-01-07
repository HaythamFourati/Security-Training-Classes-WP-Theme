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
    // Use cached API data for better performance
    $all_classes = get_ghl_calendars_with_slots_cached();
    
    if ($all_classes === false) {
      echo '<p class="text-center text-red-500">API configuration is incomplete or unavailable. Please check Settings -> GHL API.</p>';
    } else {
      // Filter classes by filter term if provided
      $available_classes = array();
      if (!empty($filter_term) && !empty($all_classes)) {
        foreach ($all_classes as $class) {
          $calendar_info = $class['calendar_info'];
          $name_match = stripos($class['courseSchedule']['title'], $filter_term) !== false;
          $desc_match = isset($calendar_info['description']) ? stripos($calendar_info['description'], $filter_term) !== false : false;
          
          if ($name_match || $desc_match) {
            $available_classes[] = $class;
          }
        }
      } else {
        $available_classes = $all_classes;
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
    }
    ?>
  </div>
</section>
