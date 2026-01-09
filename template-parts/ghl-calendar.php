<?php
/**
 * Template part for displaying Go High Level Calendar
 * Uses parallel API calls for faster loading
 * 
 * @package Security_Training_Classes
 */

// Get GHL API credentials
$base_url = get_option('ghl_base_url');
$bearer_token = get_option('ghl_bearer_token');
$location_id = get_option('ghl_location_id');
$api_version = get_option('ghl_api_version');

if (!empty($base_url) && !empty($bearer_token) && !empty($location_id)) {
  // Prepare headers
  $headers = array(
    'Authorization' => 'Bearer ' . $bearer_token,
    'Version' => $api_version,
    'Content-Type' => 'application/json'
  );

  // STEP 1: Fetch ALL calendars from GHL (single request)
  $calendars_url = $base_url . "/calendars/?locationId=" . $location_id;
  $calendars_response = wp_remote_get($calendars_url, array('headers' => $headers));

  if (!is_wp_error($calendars_response)) {
    $calendars_data = json_decode(wp_remote_retrieve_body($calendars_response), true);
    
    // Collect all upcoming events from ALL calendars
    $all_events = array();
    
    if (!empty($calendars_data['calendars'])) {
      // Define date range for fetching slots (next 30 days - GHL API max is 31 days)
      $start_date = new DateTime();
      $end_date = new DateTime('+30 days');
      $start_timestamp = $start_date->getTimestamp() * 1000;
      $end_timestamp = $end_date->getTimestamp() * 1000;
      
      // STEP 2: Filter calendars and prepare for parallel fetch
      $calendars_to_fetch = array();
      foreach ($calendars_data['calendars'] as $calendar) {
        if (!isset($calendar['isActive']) || $calendar['isActive'] !== true) {
          continue;
        }
        if (stripos($calendar['name'], 'personal calendar') !== false) {
          continue;
        }
        $calendars_to_fetch[$calendar['id']] = $calendar;
      }
      
      // STEP 3: Fetch all slots in PARALLEL
      $slots_responses = array();
      if (!empty($calendars_to_fetch) && function_exists('ghl_fetch_slots_parallel')) {
        $slots_responses = ghl_fetch_slots_parallel($calendars_to_fetch, $base_url, $bearer_token, $api_version, $start_timestamp, $end_timestamp);
      }
      
      // STEP 4: Process the responses
      foreach ($calendars_to_fetch as $calendar_id => $calendar) {
        $calendar_name = $calendar['name'];
        $widget_slug = isset($calendar['widgetSlug']) ? $calendar['widgetSlug'] : '';
        $slots_data = isset($slots_responses[$calendar_id]) ? $slots_responses[$calendar_id] : null;
        
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
                $day_slots = isset($day_data['slots']) ? $day_data['slots'] : $day_data;
                foreach ($day_slots as $slot) {
                  if (is_string($slot)) {
                    // Slot is an ISO datetime string like "2026-01-10T08:30:00-05:00"
                    $slots_to_process[] = array('datetime' => $slot);
                  } elseif (is_array($slot)) {
                    $slot['_date'] = $date_key;
                    $slots_to_process[] = $slot;
                  } elseif (is_numeric($slot)) {
                    $slots_to_process[] = array('datetime' => $slot);
                  }
                }
              }
            }
          } elseif (isset($slots_data[0])) {
            $slots_to_process = $slots_data;
          }
          
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
            
            if ($slot_time) {
              if (is_numeric($slot_time)) {
                $date_obj = new DateTime();
                $date_obj->setTimestamp($slot_time / 1000);
              } else {
                // ISO datetime string like "2026-01-10T08:30:00-05:00"
                $date_obj = new DateTime($slot_time);
              }
              $time_formatted = $date_obj->format('g:i A');
              
              if ($date_obj > new DateTime()) {
                $all_events[] = array(
                  'date' => $date_obj,
                  'date_formatted' => $date_obj->format('M j, Y'),
                  'day_name' => $date_obj->format('l'),
                  'calendar_name' => $calendar_name,
                  'time_slots' => array($time_formatted),
                  'booking_url' => !empty($widget_slug) ? 'https://api.warriormarketinggroup.com/widget/bookings/' . $widget_slug : '#'
                );
              }
            }
          }
        }
      }
      
      // Sort ALL events by date (chronological order)
      usort($all_events, function($a, $b) {
        return $a['date'] <=> $b['date'];
      });
      
      // Display calendar view
      if (!empty($all_events)) {
        // Group events by date for calendar display
        $events_by_date = array();
        $available_months = array();
        
        foreach ($all_events as $event) {
          $date_key = $event['date']->format('Y-m-d');
          $month_key = $event['date']->format('Y-m');
          
          if (!isset($events_by_date[$date_key])) {
            $events_by_date[$date_key] = array();
          }
          $events_by_date[$date_key][] = $event;
          
          // Track available months
          if (!in_array($month_key, $available_months)) {
            $available_months[] = $month_key;
          }
        }
        
        sort($available_months);
        
        // Get current month or first event month
        $current_date = new DateTime();
        $display_month = clone $current_date;
        
        // Calendar navigation and display
        echo '<div class="calendar-view" id="ghl-calendar-view">';
        
        // Month selector
        echo '<div class="flex items-center justify-between mb-6 pb-4 border-b-2 border-safety-orange">';
        echo '<button id="prev-month" class="text-navy hover:text-safety-orange transition-colors p-2 cursor-pointer">';
        echo '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>';
        echo '</button>';
        
        echo '<select id="month-selector" class="text-xl font-bold text-navy bg-transparent border-none focus:outline-none cursor-pointer">';
        foreach ($available_months as $month) {
          $month_date = new DateTime($month . '-01');
          $selected = ($month === $display_month->format('Y-m')) ? 'selected' : '';
          echo '<option value="' . $month . '" ' . $selected . '>' . $month_date->format('F Y') . '</option>';
        }
        echo '</select>';
        
        echo '<button id="next-month" class="text-navy hover:text-safety-orange transition-colors p-2 cursor-pointer">';
        echo '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>';
        echo '</button>';
        echo '</div>';
        
        // Day headers
        echo '<div class="grid grid-cols-7 gap-1 mb-2">';
        $days = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
        foreach ($days as $day) {
          echo '<div class="text-center font-bold text-navy text-sm py-2">' . $day . '</div>';
        }
        echo '</div>';
        
        // Calendar grid container
        echo '<div id="calendar-grid-container">';
        
        // Function to render a month
        $render_month = function($month_str, $events_by_date) {
          $display_month = new DateTime($month_str . '-01');
          
          echo '<div class="calendar-month-grid grid grid-cols-7 gap-1" data-month="' . $month_str . '">';
          
          // Get first day of month and number of days
          $first_day = new DateTime($display_month->format('Y-m-01'));
          $start_weekday = (int)$first_day->format('w');
          $days_in_month = (int)$display_month->format('t');
          
          // Empty cells before month starts
          for ($i = 0; $i < $start_weekday; $i++) {
            echo '<div class="bg-gray-50 rounded p-1.5 h-20"></div>';
          }
          
          // Days of the month
          for ($day = 1; $day <= $days_in_month; $day++) {
            $current_day = new DateTime($display_month->format('Y-m-') . sprintf('%02d', $day));
            $date_key = $current_day->format('Y-m-d');
            $is_today = $current_day->format('Y-m-d') === (new DateTime())->format('Y-m-d');
            $has_events = isset($events_by_date[$date_key]);
            
            // Day cell - reduced height
            $cell_class = 'bg-white border rounded p-1.5 h-20 relative';
            if ($is_today) {
              $cell_class .= ' border-safety-orange border-2';
            } else {
              $cell_class .= ' border-gray-200';
            }
            
            echo '<div class="' . $cell_class . '">';
            
            // Day number
            $day_class = 'text-xs font-semibold mb-0.5';
            if ($is_today) {
              $day_class .= ' text-safety-orange';
            } else {
              $day_class .= ' text-navy';
            }
            echo '<div class="' . $day_class . '">' . $day . '</div>';
            
            // Events for this day
            if ($has_events) {
              $event_count = count($events_by_date[$date_key]);
              $display_count = min($event_count, 2); // Show max 2 events
              
              echo '<div class="space-y-0.5">';
              for ($i = 0; $i < $display_count; $i++) {
                $event = $events_by_date[$date_key][$i];
                echo '<a href="' . esc_url($event['booking_url']) . '" target="_blank" class="block bg-safety-orange text-white text-[10px] px-1 py-0.5 rounded hover:bg-opacity-90 transition-colors">';
                echo '<div class="font-semibold truncate">' . esc_html($event['calendar_name']) . '</div>';
                echo '</a>';
              }
              
              // Show "+X more" with tooltip if there are more events
              if ($event_count > 2) {
                echo '<div class="relative event-tooltip-trigger">';
                echo '<div class="text-[9px] text-steel-gray font-semibold cursor-pointer hover:text-safety-orange transition-colors">+' . ($event_count - 2) . ' more</div>';
                
                // Tooltip with remaining events
                echo '<div class="event-tooltip absolute left-0 top-full mt-1 bg-white border-2 border-safety-orange rounded shadow-lg p-2 z-50 min-w-[150px]" style="display: none;">';
                echo '<div class="space-y-1">';
                for ($i = 2; $i < $event_count; $i++) {
                  $event = $events_by_date[$date_key][$i];
                  echo '<a href="' . esc_url($event['booking_url']) . '" target="_blank" class="block bg-safety-orange text-white text-[10px] px-2 py-1 rounded hover:bg-opacity-90 transition-colors">';
                  echo '<div class="font-semibold">' . esc_html($event['calendar_name']) . '</div>';
                  if (!empty($event['time_slots'])) {
                    echo '<div class="text-[9px] opacity-90">' . esc_html($event['time_slots'][0]) . '</div>';
                  }
                  echo '</a>';
                }
                echo '</div>';
                echo '</div>';
                
                echo '</div>';
              }
              echo '</div>';
            }
            
            echo '</div>';
          }
          
          // Fill remaining cells
          $total_cells = $start_weekday + $days_in_month;
          $remaining_cells = (7 - ($total_cells % 7)) % 7;
          for ($i = 0; $i < $remaining_cells; $i++) {
            echo '<div class="bg-gray-50 rounded p-1.5 h-20"></div>';
          }
          
          echo '</div>';
        };
        
        // Render all months (hidden by default except current)
        foreach ($available_months as $month) {
          $is_current = ($month === $display_month->format('Y-m'));
          echo '<div class="month-container ' . ($is_current ? '' : 'hidden') . '" data-month="' . $month . '">';
          $render_month($month, $events_by_date);
          echo '</div>';
        }
        
        echo '</div>'; // Close calendar-grid-container
        
        // JavaScript for month navigation and tooltip
        echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
          const monthSelector = document.getElementById("month-selector");
          const prevBtn = document.getElementById("prev-month");
          const nextBtn = document.getElementById("next-month");
          const monthContainers = document.querySelectorAll(".month-container");
          
          function showMonth(monthStr) {
            monthContainers.forEach(container => {
              if (container.dataset.month === monthStr) {
                container.classList.remove("hidden");
              } else {
                container.classList.add("hidden");
              }
            });
          }
          
          monthSelector.addEventListener("change", function() {
            showMonth(this.value);
          });
          
          prevBtn.addEventListener("click", function() {
            const currentIndex = monthSelector.selectedIndex;
            if (currentIndex > 0) {
              monthSelector.selectedIndex = currentIndex - 1;
              monthSelector.dispatchEvent(new Event("change"));
            }
          });
          
          nextBtn.addEventListener("click", function() {
            const currentIndex = monthSelector.selectedIndex;
            if (currentIndex < monthSelector.options.length - 1) {
              monthSelector.selectedIndex = currentIndex + 1;
              monthSelector.dispatchEvent(new Event("change"));
            }
          });
          
          // Tooltip functionality - manual toggle for better compatibility
          document.querySelectorAll(".event-tooltip-trigger").forEach(trigger => {
            const tooltip = trigger.querySelector(".event-tooltip");
            
            trigger.addEventListener("mouseenter", function() {
              if (tooltip) {
                tooltip.style.display = "block";
              }
            });
            
            trigger.addEventListener("mouseleave", function() {
              if (tooltip) {
                tooltip.style.display = "none";
              }
            });
          });
        });
        </script>';
        
        echo '</div>'; // Close calendar-view
      } else {
        echo '<p class="text-center text-steel-gray py-12">No upcoming classes scheduled at this time.</p>';
      }
    } else {
      echo '<p class="text-center text-steel-gray py-12">No calendars available.</p>';
    }
  } else {
    echo '<p class="text-center text-red-500 py-12">Unable to load calendar data. Please try again later.</p>';
  }
} else {
  echo '<p class="text-center text-red-500 py-12">Calendar configuration is incomplete. Please configure GHL API settings.</p>';
}
?>
