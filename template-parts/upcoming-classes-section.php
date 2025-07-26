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
  $apiKey = get_option('bookeo_api_key');
  $secretKey = get_option('bookeo_secret_key');

  if (empty($apiKey) || empty($secretKey)) {
    echo '<p class="text-center text-red-500">API keys are not configured. Please set them in Settings -> Bookeo API.</p>';
  } else {
    // Set the timezone to avoid warnings
    date_default_timezone_set('UTC');
    $startTime = date('Y-m-d\TH:i:s\Z');
    $endTime = date('Y-m-d\TH:i:s\Z', strtotime('+30 days'));

    // 1. Fetch available slots
    $slots_url = "https://api.bookeo.com/v2/availability/slots?startTime={$startTime}&endTime={$endTime}&apiKey={$apiKey}&secretKey={$secretKey}";
    $slots_response = wp_remote_get($slots_url);

    // 2. Fetch product details
    $products_url = "https://api.bookeo.com/v2/settings/products?apiKey={$apiKey}&secretKey={$secretKey}";
    $products_response = wp_remote_get($products_url);

    if (is_wp_error($slots_response) || is_wp_error($products_response)) {
      echo '<p class="text-center text-red-500">Failed to load class data. Please try again later.</p>';
    } else {
      $slots_data = json_decode(wp_remote_retrieve_body($slots_response), true);
      $products_data = json_decode(wp_remote_retrieve_body($products_response), true);

      // Create a lookup map for product details
      $products_map = [];
      if (!empty($products_data['data'])) {
        foreach ($products_data['data'] as $product) {
          $products_map[$product['productId']] = [
            'description' => $product['description'],
            'thumbnail' => !empty($product['images'][0]['url']) ? $product['images'][0]['url'] : ''
          ];
        }
      }

      if (!empty($slots_data['data'])) {
        $available_classes = array_filter($slots_data['data'], function($class) {
          return $class['numSeatsAvailable'] > 0;
        });

        if (!empty($available_classes)) {
          echo '<div id="class-grid" class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">';

          foreach ($available_classes as $class) {
            $productId = $class['productId'];
            $product_details = isset($products_map[$productId]) ? $products_map[$productId] : ['description' => '', 'thumbnail' => ''];
            
            $start_time_obj = new DateTime($class['startTime']);
            $lower_title = strtolower($class['courseSchedule']['title']);
            $category = 'other';
            if (strpos($lower_title, 'guard') !== false || strpos($lower_title, 'security officer') !== false) $category = 'guard';
            elseif (strpos($lower_title, 'firearm') !== false || strpos($lower_title, 'handgun') !== false || strpos($lower_title, 'wear & carry') !== false || strpos($lower_title, 'hql') !== false) $category = 'firearms';
            elseif (strpos($lower_title, 'spo') !== false || strpos($lower_title, 'special police') !== false) $category = 'spo';

            $class_data_arg = [
              'eventId' => $class['eventId'],
              'title' => $class['courseSchedule']['title'],
              'description' => $product_details['description'],
              'thumbnail' => $product_details['thumbnail'],
              'date' => $start_time_obj->format('F j, Y'),
              'start_time' => $start_time_obj->format('g:i A'),
              'seats' => $class['numSeatsAvailable'],
              'booking_url' => "https://bookeo.com/securitytrainingacademy?type={$productId}",
              'category' => $category
            ];

            get_template_part('template-parts/class-card', null, ['class_data' => $class_data_arg]);
          }

          echo '</div>';

          // Pagination container
          echo '<div id="class-pagination" class="flex justify-center items-center space-x-4 mt-12"></div>';

        } else {
          echo '<p class="text-center">No upcoming classes with available seats at this time.</p>';
        }
      } else {
        echo '<p class="text-center">No upcoming classes available at this time.</p>';
      }

      // Render the modals outside of the main grid
      if (!empty($available_classes)) {
        foreach ($available_classes as $class) {
          $productId = $class['productId'];
          $product_details = isset($products_map[$productId]) ? $products_map[$productId] : ['description' => '', 'thumbnail' => ''];

          $class_data_arg = [
            'eventId' => $class['eventId'],
            'title' => $class['courseSchedule']['title'],
            'description' => $product_details['description'],
            'booking_url' => "https://bookeo.com/securitytrainingacademy?type={$productId}",
          ];

          get_template_part('template-parts/class-modal', null, ['class_data' => $class_data_arg]);
        }
      }
    }
  }
  ?>
</div>
