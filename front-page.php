<?php get_header(); ?>

<main>
  <!-- Hero Section -->
  <section class="relative bg-navy text-white h-[600px] flex items-center justify-center text-center z-0">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('<?php echo get_theme_file_uri('/images/hero-background.jpg'); ?>');"></div>
    
    <div class="relative z-10 p-8">
      <h1 class="text-5xl md:text-6xl font-extrabold leading-tight mb-4">Launch Your Career in Security <br/> and Law Enforcement Today.</h1>
      <p class="text-lg md:text-xl text-steel-gray mb-8">Trusted Training Programs in Maryland — Security Guard, SPO, and Firearms Certifications.</p>
      
      <div class="flex justify-center space-x-4 mb-8">
        <a href="#" class="bg-safety-orange text-white font-bold py-3 px-6 rounded hover:bg-opacity-90 transition-colors">Explore Classes</a>
        <a href="#" class="bg-transparent border-2 border-white text-white font-bold py-3 px-6 rounded hover:bg-white hover:text-navy transition-colors">Book Now</a>
      </div>
      
      <div class="inline-block bg-gray-800 bg-opacity-70 p-4 rounded-lg border border-steel-gray">
        <p class="text-sm font-semibold">State-Certified | Experienced Instructors | Flexible Scheduling</p>
      </div>
    </div>
  </section>

  <!-- Upcoming Classes Section -->
  <section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
      <h2 class="text-4xl font-bold text-navy mb-6 text-center">Upcoming Classes & Registration</h2>
      <div class="flex justify-center space-x-2 mb-12" id="class-filters">
        <button class="px-6 py-2 rounded font-semibold bg-navy text-white" data-filter="all">All</button>
        <button class="px-6 py-2 rounded font-semibold bg-white text-navy border border-gray-300" data-filter="guard">Guard</button>
        <button class="px-6 py-2 rounded font-semibold bg-white text-navy border border-gray-300" data-filter="firearms">Firearms</button>
        <button class="px-6 py-2 rounded font-semibold bg-white text-navy border border-gray-300" data-filter="spo">SPO</button>
      </div>
      <?php
      $apiKey = get_option('bookeo_api_key');
      $secretKey = get_option('bookeo_secret_key');
      
      // Set the timezone to avoid warnings
      date_default_timezone_set('UTC');

      // Dynamically set the time frame for the next 30 days
      $startTime = date('Y-m-d\T00:00:00\Z');
      $endTime = date('Y-m-d\T23:59:59\Z', strtotime('+30 days'));

      $url = "https://api.bookeo.com/v2/availability/slots?startTime={$startTime}&endTime={$endTime}&apiKey={$apiKey}&secretKey={$secretKey}";

      $response = wp_remote_get($url);

      if (is_wp_error($response)) {
        echo '<p class="text-center text-red-500">Failed to load classes. Please try again later.</p>';
      } else {
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        if (!empty($data['data'])) {
          $available_classes = array_filter($data['data'], function($class) {
            return $class['numSeatsAvailable'] > 0;
          });

          if (!empty($available_classes)) {
            echo '<div class="space-y-4">';

            foreach ($available_classes as $class) {
              $title = esc_html($class['courseSchedule']['title']);
              $start_time_obj = new DateTime($class['startTime']);
              $date = $start_time_obj->format('F j, Y');
              $start_time = $start_time_obj->format('g:i A');
              $seats = esc_html($class['numSeatsAvailable']);
              $productId = esc_attr($class['productId']);
              $booking_url = "https://bookeo.com/securitytrainingacademy?type={$productId}";
              
              // Determine category from title
              $category = 'other'; // Default category
              $lower_title = strtolower($title);
              if (strpos($lower_title, 'guard') !== false || strpos($lower_title, 'security officer') !== false) {
                $category = 'guard';
              } elseif (strpos($lower_title, 'firearm') !== false || strpos($lower_title, 'handgun') !== false || strpos($lower_title, 'wear & carry') !== false || strpos($lower_title, 'hql') !== false || strpos($lower_title, 'ccw') !== false) {
                $category = 'firearms';
              } elseif (strpos($lower_title, 'spo') !== false || strpos($lower_title, 'special police') !== false) {
                $category = 'spo';
              }
              ?>
              <div class="bg-white p-6 rounded-lg shadow-lg flex justify-between items-center class-item" data-category="<?php echo $category; ?>">
                <div>
                  <h3 class="text-xl font-bold text-navy"><?php echo $title; ?></h3>
                  <p class="text-steel-gray">Date: <?php echo $date; ?> | Start Time: <?php echo $start_time; ?> | Seats Available: <?php echo $seats; ?></p>
                </div>
                <a href="<?php echo $booking_url; ?>" target="_blank" class="bg-safety-orange text-white font-bold py-2 px-6 rounded hover:bg-opacity-90 transition-colors whitespace-nowrap">Book Now</a>
              </div>
              <?php
            }

            echo '</div>';
          } else {
            echo '<p class="text-center">No upcoming classes with available seats at this time.</p>';
          }
        } else {
          echo '<p class="text-center">No upcoming classes available at this time.</p>';
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
        <p class="mb-6">Since 2005, Security Training Classes has been Maryland's trusted source for professional security and law enforcement certification. Our mission is to equip every student with the skills, confidence, and credentials needed to excel in their careers and serve our communities with integrity.</p>
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
            <p class="text-3xl font-bold text-safety-orange">Since '05</p>
            <p class="font-semibold">Serving Maryland</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Training Programs Section -->
  <section class="py-20 bg-gray-100">
    <div class="container mx-auto text-center px-4">
      <h2 class="text-4xl font-bold text-navy mb-12">Our Training Programs</h2>
      <div class="grid md:grid-cols-3 gap-8">
        <!-- Security Guard Card -->
        <div class="bg-white p-8 rounded-lg shadow-lg text-center">
          <div class="text-safety-orange mb-4"><!-- Placeholder for badge icon --></div>
          <h3 class="text-2xl font-bold text-navy mb-3">Security Guard Training</h3>
          <p class="text-steel-gray mb-6">Get licensed and certified with hands-on training and expert instruction.</p>
          <a href="#" class="bg-navy text-white font-bold py-2 px-6 rounded hover:bg-opacity-90 transition-colors">Learn More</a>
        </div>
        <!-- Firearms Certification Card -->
        <div class="bg-white p-8 rounded-lg shadow-lg text-center">
          <div class="text-safety-orange mb-4"><!-- Placeholder for target icon --></div>
          <h3 class="text-2xl font-bold text-navy mb-3">Firearms Certifications</h3>
          <p class="text-steel-gray mb-6">Certified training for safe, responsible firearm use and licensing.</p>
          <a href="#" class="bg-navy text-white font-bold py-2 px-6 rounded hover:bg-opacity-90 transition-colors">Learn More</a>
        </div>
        <!-- SPO Training Card -->
        <div class="bg-white p-8 rounded-lg shadow-lg text-center">
          <div class="text-safety-orange mb-4"><!-- Placeholder for shield icon --></div>
          <h3 class="text-2xl font-bold text-navy mb-3">Special Police Officer (SPO)</h3>
          <p class="text-steel-gray mb-6">Train for SPO duties with specialized instruction and real-world preparation.</p>
          <a href="#" class="bg-navy text-white font-bold py-2 px-6 rounded hover:bg-opacity-90 transition-colors">Learn More</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials Section -->
  <section class="py-20 bg-white">
    <div class="container mx-auto text-center px-4">
      <h2 class="text-4xl font-bold text-navy mb-12">What Our Graduates Say</h2>
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Testimonial 1 -->
        <div class="bg-gray-100 p-8 rounded-lg shadow-lg">
          <p class="text-steel-gray italic mb-4">"Thanks to STC, I passed my SPO exam and landed my first job in 3 weeks. The instructors were top-notch."</p>
          <p class="font-bold text-navy">- James R.</p>
          <p class="text-sm text-safety-orange">Certified SPO</p>
        </div>
        <!-- Testimonial 2 -->
        <div class="bg-gray-100 p-8 rounded-lg shadow-lg">
          <p class="text-steel-gray italic mb-4">"The firearms certification course was thorough and professional. I feel much more confident and responsible."</p>
          <p class="font-bold text-navy">- Maria G.</p>
          <p class="text-sm text-safety-orange">Firearms Certified</p>
        </div>
        <!-- Testimonial 3 -->
        <div class="bg-gray-100 p-8 rounded-lg shadow-lg">
          <p class="text-steel-gray italic mb-4">"A great place to start your security career. The guard training was comprehensive and practical."</p>
          <p class="font-bold text-navy">- David L.</p>
          <p class="text-sm text-safety-orange">Licensed Security Guard</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Upcoming Classes Section -->
  <section class="py-20 bg-gray-100">
    <div class="container mx-auto text-center px-4">
      <h2 class="text-4xl font-bold text-navy mb-12">Upcoming Classes & Registration</h2>
      <!-- Class Filters -->
      <div class="flex justify-center space-x-4 mb-8">
        <button class="bg-navy text-white font-bold py-2 px-6 rounded">All</button>
        <button class="bg-white text-navy font-bold py-2 px-6 rounded border border-navy">Guard</button>
        <button class="bg-white text-navy font-bold py-2 px-6 rounded border border-navy">Firearms</button>
        <button class="bg-white text-navy font-bold py-2 px-6 rounded border border-navy">SPO</button>
      </div>
      <!-- Class Listings -->
      <div class="space-y-4 text-left max-w-4xl mx-auto">
        <!-- Class 1 -->
        <div class="bg-white p-6 rounded-lg shadow-lg flex justify-between items-center">
          <div>
            <h3 class="text-xl font-bold text-navy">Security Guard Certification</h3>
            <p class="text-steel-gray">Next Class: August 5, 2025</p>
          </div>
          <a href="#" class="bg-safety-orange text-white font-bold py-2 px-6 rounded hover:bg-opacity-90">Book Now</a>
        </div>
        <!-- Class 2 -->
        <div class="bg-white p-6 rounded-lg shadow-lg flex justify-between items-center">
          <div>
            <h3 class="text-xl font-bold text-navy">Firearms Safety & Licensing</h3>
            <p class="text-steel-gray">Next Class: August 12, 2025</p>
          </div>
          <a href="#" class="bg-safety-orange text-white font-bold py-2 px-6 rounded hover:bg-opacity-90">Book Now</a>
        </div>
        <!-- Class 3 -->
        <div class="bg-white p-6 rounded-lg shadow-lg flex justify-between items-center">
          <div>
            <h3 class="text-xl font-bold text-navy">Special Police Officer (SPO) Training</h3>
            <p class="text-steel-gray">Next Class: August 19, 2025</p>
          </div>
          <a href="#" class="bg-safety-orange text-white font-bold py-2 px-6 rounded hover:bg-opacity-90">Book Now</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Certifications & Partnerships Section -->
  <section class="py-16 bg-white">
    <div class="container mx-auto text-center px-4">
      <h2 class="text-3xl font-bold text-navy mb-8">Trusted. Certified. Approved.</h2>
      <div class="flex justify-center items-center space-x-8 md:space-x-12">
        <p class="font-bold text-xl text-steel-gray">MD State Police</p>
        <p class="font-bold text-xl text-steel-gray">NRA Certified</p>
        <p class="font-bold text-xl text-steel-gray">Homeland Security</p>
        <p class="font-bold text-xl text-steel-gray">Veteran Owned</p>
      </div>
    </div>
  </section>

  <!-- FAQ Accordion Section -->
  <section class="py-20 bg-gray-100">
    <div class="container mx-auto px-4 max-w-4xl">
      <h2 class="text-4xl font-bold text-navy text-center mb-12">Frequently Asked Questions</h2>
      <div class="space-y-4">
        <!-- FAQ Item 1 -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
          <h3 class="font-bold text-navy text-xl">What is the duration of the security guard training?</h3>
          <p class="text-steel-gray mt-2">Our standard security guard course is a 40-hour program, typically completed over one week. We also offer flexible weekend schedules.</p>
        </div>
        <!-- FAQ Item 2 -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
          <h3 class="font-bold text-navy text-xl">Are your certifications recognized by the state of Maryland?</h3>
          <p class="text-steel-gray mt-2">Yes, all of our training programs are fully certified and approved by the Maryland State Police and other relevant authorities.</p>
        </div>
        <!-- FAQ Item 3 -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
          <h3 class="font-bold text-navy text-xl">What are the requirements for firearms licensing?</h3>
          <p class="text-steel-gray mt-2">Requirements include being at least 21 years old, passing a background check, and successfully completing our certified safety and handling course.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section class="py-20 bg-navy text-white">
    <div class="container mx-auto text-center px-4">
        <h2 class="text-4xl font-bold mb-4">Still have questions?</h2>
        <p class="text-xl mb-8">Speak with an instructor today!</p>
        <div class="max-w-xl mx-auto">
            <form class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" placeholder="Name" class="p-3 rounded bg-steel-gray text-white placeholder-gray-300">
                <input type="email" placeholder="Email" class="p-3 rounded bg-steel-gray text-white placeholder-gray-300">
                <input type="tel" placeholder="Phone" class="p-3 rounded bg-steel-gray text-white placeholder-gray-300">
                <input type="text" placeholder="Message" class="p-3 rounded bg-steel-gray text-white placeholder-gray-300 md:col-span-2">
                <button type="submit" class="bg-safety-orange text-white font-bold py-3 px-6 rounded hover:bg-opacity-90 md:col-span-2">Send Message</button>
            </form>
        </div>
    </div>
  </section>
</main>

<?php get_footer(); ?>
