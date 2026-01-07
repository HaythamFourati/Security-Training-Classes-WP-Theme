<?php
/**
 * Template part for displaying the Upcoming Classes content (AJAX version)
 * This is the content-only version without the wrapper, for AJAX loading
 */

// Use cached API data for better performance
$available_classes = get_ghl_calendars_with_slots_cached();

if ($available_classes === false) {
  echo '<p class="text-center text-red-500">API configuration is incomplete or unavailable. Please check Settings -> GHL API.</p>';
} elseif (!empty($available_classes)) {
  // Category configuration
  $category_keywords = array(
    'spo' => array('spo', 'special police'),
    'firearms' => array('hql', 'certification', 'permit'),
    'wear-carry' => array('wear', 'carry'),
    'guard' => array('guard', 'security officer')
  );
  
  echo '<div id="class-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 md:gap-4">';

  foreach ($available_classes as $class) {
    $calendar_info = $class['calendar_info'];
    $calendar_id = $class['productId'];
    
    $lower_title = strtolower($class['courseSchedule']['title']);
    $matched_categories = array();
    
    foreach ($category_keywords as $category_name => $keywords) {
      foreach ($keywords as $keyword) {
        if (strpos($lower_title, $keyword) !== false) {
          $matched_categories[] = $category_name;
          break;
        }
      }
    }
    
    if (empty($matched_categories)) {
      $matched_categories[] = 'other';
    }
    
    $category = implode(' ', array_unique($matched_categories));
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
  echo '<div id="class-pagination" class="flex justify-center items-center space-x-4 mt-12"></div>';

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
  echo '<p class="text-center text-white">No upcoming classes available at this time.</p>';
}
?>
