<?php get_header(); ?>

<main>
  <!-- Hero Section -->
  <section class="bg-gradient-to-l from-[var(--color-navy)] to-blue-800 text-white py-20 -mt-32 pt-56">
    <div class="container mx-auto px-4 grid md:grid-cols-2 gap-12 items-center">
      <!-- Text Content -->
      <div class="text-left">
        <h1 class="text-5xl md:text-6xl font-bold leading-tight mb-4">Maryland’s Premier Security Training Academy</h1>
        <p class="text-lg md:text-xl text-gray-300 mb-8">State-Certified | Experienced Instructors | Flexible Scheduling</p>
        <div class="flex flex-wrap gap-4">
          <a href="#upcoming-classes" class="bg-safety-orange text-white font-bold py-3 px-8 rounded hover:bg-opacity-90 transition-colors text-lg">Explore Classes</a>
          <a href="https://bookeo.com/securitytrainingacademy" target="_blank" class="bg-transparent border-2 border-white text-white font-bold py-3 px-8 rounded hover:bg-white hover:text-navy transition-colors text-lg">Book Now</a>
        </div>
      </div>
      <!-- Image Collage -->
      <div class="grid grid-cols-3 grid-rows-3 gap-3 h-96">
        <!-- Main large image - spans 2x2 -->
        <div class="col-span-2 row-span-2 rounded-lg overflow-hidden shadow-xl">
          <img src="https://www.securitytrainingclasses.com/wp-content/uploads/2022/02/police-officers.jpg" alt="Professional security guard" class="w-full h-full object-cover">
        </div>
        
        <!-- Top right image -->
        <div class="rounded-lg overflow-hidden shadow-lg">
          <img src="https://www.securitytrainingclasses.com/wp-content/uploads/2024/12/AdobeStock_240237675-1.jpg" alt="Security training" class="w-full h-full object-cover">
        </div>
        
        <!-- Middle right image -->
        <div class="rounded-lg overflow-hidden shadow-lg">
          <img src="https://www.securitytrainingclasses.com/wp-content/uploads/2023/05/AdobeStock_386473842.jpg" alt="Security equipment" class="w-full h-full object-cover">
        </div>
        
        <!-- Bottom left image -->
        <div class="rounded-lg overflow-hidden shadow-lg">
          <img src="https://www.securitytrainingclasses.com/wp-content/uploads/2022/10/UTAH-CONCEALED-CARRY-CLASSES-1-1.jpg" alt="Training classroom" class="w-full h-full object-cover">
        </div>
        
        <!-- Bottom right image -->
        <div class="rounded-lg overflow-hidden shadow-lg">
          <img src="https://www.securitytrainingclasses.com/wp-content/uploads/2022/12/AdobeStock_318705595-scaled.jpeg" alt="Security badge" class="w-full h-full object-cover">
        </div>
      </div>
    </div>
  </section>

  <!-- Upcoming Classes Section -->
  <section id="upcoming-classes" class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
      <h2 class="text-4xl font-bold text-navy mb-6 text-center">Upcoming Classes & Registration</h2>
      <div class="flex justify-center space-x-2 mb-12" id="class-filters">
        <button class="px-6 py-2 rounded font-semibold bg-navy text-white" data-filter="all">All</button>
        <button class="px-6 py-2 rounded font-semibold bg-white text-navy border border-gray-300" data-filter="guard">Security Guard Training
        </button>
        <button class="px-6 py-2 rounded font-semibold bg-white text-navy border border-gray-300" data-filter="firearms">Firearms Certification</button>
        <button class="px-6 py-2 rounded font-semibold bg-white text-navy border border-gray-300" data-filter="spo">Special Police Officer (SPO) Training</button>
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
  </section>

  <!-- About Us Section -->
  <section class="py-20 bg-white">
    <div class="container mx-auto grid md:grid-cols-2 gap-12 items-center px-4">
      <div>
        <img src="https://www.securitytrainingclasses.com/wp-content/uploads/2022/12/AdobeStock_240237656-1-2-768x512.jpg" alt="Instructors and students in a training session" class="rounded-lg shadow-xl">
      </div>
      <div class="text-navy">
        <h2 class="text-4xl font-bold mb-4">Professional, Certified, and Ready to Serve.</h2>
        <p class="mb-6">At Security Training Classes, we take pride in shaping tomorrow’s protectors. Since 2005, we’ve been Maryland’s premier destination for professional security and law enforcement training. Whether you're pursuing a career as a security officer, aiming to become a Special Police Officer (SPO), or enhancing your qualifications with firearms certifications, we provide the expert-led instruction and hands-on experience needed to succeed.

<p class="mb-6"> Our mission is to build more than just credentials—we build confidence, competence, and community. With state-approved courses, expert instructors, and real-world training scenarios, we equip every student with the tools to protect and serve with honor and integrity.</p>

<p class="mb-6"> Join the ranks of over 1,500 students who have launched or elevated their careers through our academy. When you're ready to take your training seriously, we're ready to serve.</p>
        <div class="grid grid-cols-3 gap-4 text-center">
          <div>
            <p class="text-3xl font-bold text-safety-orange">1,500+</p>
            <p class="font-semibold">Students Trained</p>
          </div>
          <div>
            <p class="text-3xl font-bold text-safety-orange">State</p>
            <p class="font-semibold">Approved</p>
          </div>
          <div>
            <p class="text-3xl font-bold text-safety-orange">Since 2005</p>
            <p class="font-semibold">Serving Maryland</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Affiliations Section -->
  <section class="py-6 pb-12 bg-white">
    <div class="container mx-auto text-center px-4">
      <h2 class="text-3xl md:text-4xl font-bold text-center text-navy mb-12">Real-time, instructor-led online and in-person classes</h2>
      <div class="flex flex-wrap justify-center items-center gap-x-8 gap-y-8 md:gap-x-16">
        <img src="https://images.leadconnectorhq.com/image/f_webp/q_80/r_1200/u_https://assets.cdn.filesafe.space/9Ys3MLT8cAMGAsVD72yV/media/680e9ec0eb94a81b06062e8e.jpeg" alt="NRA Law Enforcement Instructor Logo" class="h-25 w-auto">
        <img src="https://images.leadconnectorhq.com/image/f_webp/q_80/r_1200/u_https://assets.cdn.filesafe.space/9Ys3MLT8cAMGAsVD72yV/media/680e9f03b3d583c5e5c99720.png" alt="Maryland State Police Licensed Firearm & SPO Instructor Logo" class="h-25 w-auto">
        <img src="https://images.leadconnectorhq.com/image/f_webp/q_80/r_1200/u_https://assets.cdn.filesafe.space/9Ys3MLT8cAMGAsVD72yV/media/680e9ec033fee4d76d429e12.png" alt="Metropolitan Police Licensed Firearm & SPO Instructor Logo" class="h-25 w-auto">
        <img src="https://images.leadconnectorhq.com/image/f_webp/q_80/r_1200/u_https://assets.cdn.filesafe.space/9Ys3MLT8cAMGAsVD72yV/media/680e9ec03176b9a7295f2a19.png" alt="IALEFI - International Association of Law Enforcement Firearms Instructors Logo" class="h-25 w-auto">
        <img src="https://images.leadconnectorhq.com/image/f_webp/q_80/r_1200/u_https://assets.cdn.filesafe.space/9Ys3MLT8cAMGAsVD72yV/media/680e9ec0eb94a846d4062e8f.jpeg" alt="USCCA Training Counselor Logo" class="h-25 w-auto">
        <img src="https://images.leadconnectorhq.com/image/f_webp/q_80/r_1200/u_https://assets.cdn.filesafe.space/9Ys3MLT8cAMGAsVD72yV/media/680e9ec03176b980955f2a1a.png" alt="Veteran-Owned Small Business Enterprise Program Logo" class="h-25 w-auto">
      </div>
    </div>
  </section>

  <!-- Calendar Section -->
  <section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4 max-w-6xl">
      <h2 class="text-4xl font-bold text-navy mb-12 text-center">Check Our Schedule</h2>
      <div class="bg-white p-4 md:p-8 rounded-lg shadow-lg">
        <iframe src="https://calendar.google.com/calendar/embed?src=u7iu9m3l3a7aa2dqf3r1tu13fi4pk5fo%40import.calendar.google.com&amp;ctz=America%2FNew_York" style="border: 0" width="100%" height="600" frameborder="0" scrolling="no"></iframe>
      </div>
    </div>
  </section>

  
  <!-- FAQ Accordion Section -->
  <section class="py-20 bg-gray-100">
    <div class="container mx-auto px-4 max-w-4xl">
      <h2 class="text-4xl font-bold text-navy text-center mb-12">Frequently Asked Questions</h2>
      <div class="space-y-4" id="faq-accordion">
        <!-- FAQ Item 1 -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
          <button class="w-full flex justify-between items-center text-left p-6 font-bold text-navy text-xl focus:outline-none">
            <span>Do I need any prior experience to take a firearms training course?</span>
            <svg class="w-6 h-6 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
          </button>
          <div class="p-6 pt-0 text-steel-gray hidden">
            No prior experience is necessary! We offer beginner, intermediate, and advanced courses tailored to your current skill level.
          </div>
        </div>
        <!-- FAQ Item 2 -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
          <button class="w-full flex justify-between items-center text-left p-6 font-bold text-navy text-xl focus:outline-none">
            <span>What should I bring to a firearms training class?</span>
            <svg class="w-6 h-6 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
          </button>
          <div class="p-6 pt-0 text-steel-gray hidden">
            For most classes, you'll need a valid government-issued ID, appropriate clothing (closed-toe shoes, hat, safety glasses, and hearing protection), and your firearm and ammunition (if applicable). Some courses provide firearms if needed.
          </div>
        </div>
        <!-- FAQ Item 3 -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
          <button class="w-full flex justify-between items-center text-left p-6 font-bold text-navy text-xl focus:outline-none">
            <span>Do I need any experience to enroll in your security guard training program?</span>
            <svg class="w-6 h-6 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
          </button>
          <div class="p-6 pt-0 text-steel-gray hidden">
            No prior experience is required. Our courses are designed for beginners as well as those looking to upgrade or renew their certifications.
          </div>
        </div>
        <!-- FAQ Item 4 -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
          <button class="w-full flex justify-between items-center text-left p-6 font-bold text-navy text-xl focus:outline-none">
            <span>What is a Special Police Officer (SPO)?</span>
            <svg class="w-6 h-6 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
          </button>
          <div class="p-6 pt-0 text-steel-gray hidden">
            A Special Police Officer is a licensed individual who has limited law enforcement authority, typically on private property, such as at government buildings, hospitals, universities, or private companies. They are authorized to carry a firearm and make arrests within their jurisdiction.
          </div>
        </div>
      </div>
    </div>
  </section>

<!-- Contact Section -->
<section class="py-20 bg-gray-50 text-navy">
    <div class="container mx-auto text-center px-4">
        <h2 class="text-4xl font-bold mb-4">Still have questions?</h2>
        <p class="text-xl mb-4">Speak with an instructor today!</p>
        <p class="text-sm mb-8">8567 Fort Smallwood Rd unit C,
       <br/> Pasadena, MD 21122, United States</p>
        <div class="max-w-xl mx-auto">
            <form class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" placeholder="Name" class="p-3 rounded bg-gray-200 text-navy placeholder-navy">
                <input type="email" placeholder="Email" class="p-3 rounded bg-gray-200 text-navy placeholder-navy">
                <input type="tel" placeholder="Phone" class="p-3 rounded bg-gray-200 text-navy placeholder-navy">
                <input type="text" placeholder="Message" class="p-3 rounded bg-gray-200 text-navy placeholder-navy md:col-span-2">
                <button type="submit" class="bg-safety-orange text-white font-bold py-3 px-6 rounded hover:bg-opacity-90 md:col-span-2">Send Message</button>
            </form>
        </div>
    </div>
  </section>
  
</main>

<?php get_footer(); ?>
