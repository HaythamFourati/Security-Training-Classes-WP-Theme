<?php
/**
 * Template Name: All Classes
 *
 * This template is used to display all available classes.
 *
 * @package Security_Training_Classes
 */

get_header();
?>

<main>
  <!-- Page Header -->
  <section class="bg-gradient-to-l from-[var(--color-navy)] to-blue-800 text-white py-20 -mt-32 pt-56">
    <div class="container mx-auto px-4 text-center">
      <h1 class="text-5xl md:text-6xl font-extrabold leading-tight mb-4">All Classes</h1>
      <p class="text-lg md:text-xl text-gray-300 mb-8">Browse our complete catalog of security training courses</p>
    </div>
  </section>

  <!-- Classes Section -->
  <section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
      <!-- Filter Buttons -->
      <div class="flex flex-wrap justify-center space-x-2 space-y-2 md:space-y-0 mb-12" id="class-filters">
        <button class="px-6 py-2 rounded font-semibold bg-navy text-white cursor-pointer" data-filter="all">All</button>
        <button class="px-6 py-2 rounded font-semibold bg-white text-navy border border-gray-300 cursor-pointer" data-filter="guard">Security Guard Training</button>
        <button class="px-6 py-2 rounded font-semibold bg-white text-navy border border-gray-300 cursor-pointer" data-filter="firearms">Firearms Certification</button>
        <button class="px-6 py-2 rounded font-semibold bg-white text-navy border border-gray-300 cursor-pointer" data-filter="spo">Special Police Officer (SPO) Training</button>
        <button class="px-6 py-2 rounded font-semibold bg-white text-navy border border-gray-300 cursor-pointer" data-filter="nra">NRA Classes</button>
        <button class="px-6 py-2 rounded font-semibold bg-white text-navy border border-gray-300 cursor-pointer" data-filter="uscca">USCCA Classes</button>
        <button class="px-6 py-2 rounded font-semibold bg-white text-navy border border-gray-300 cursor-pointer" data-filter="lifesaving">Life Saving Courses</button>
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
        $endTime = date('Y-m-d\TH:i:s\Z', strtotime('+90 days')); // Show classes for next 90 days

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
                
                // Determine category based on title keywords
                $category = 'other';
                if (strpos($lower_title, 'guard') !== false || strpos($lower_title, 'security officer') !== false) {
                  $category = 'guard';
                } elseif (strpos($lower_title, 'firearm') !== false || strpos($lower_title, 'handgun') !== false || 
                          strpos($lower_title, 'wear & carry') !== false || strpos($lower_title, 'hql') !== false) {
                  $category = 'firearms';
                } elseif (strpos($lower_title, 'spo') !== false || strpos($lower_title, 'special police') !== false) {
                  $category = 'spo';
                } elseif (strpos($lower_title, 'nra') !== false) {
                  $category = 'nra';
                } elseif (strpos($lower_title, 'uscca') !== false) {
                  $category = 'uscca';
                } elseif (strpos($lower_title, 'cpr') !== false || strpos($lower_title, 'acls') !== false || 
                          strpos($lower_title, 'pals') !== false || strpos($lower_title, 'first aid') !== false) {
                  $category = 'lifesaving';
                }

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
  </section>
</main>

<?php get_footer(); ?>
