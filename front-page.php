<?php get_header(); ?>

<main>
  <!-- Hero Section -->
  <section class="bg-gradient-to-b from-blue-800 via-blue-700 to-blue-500 text-white py-20 -mt-32 pt-48">
    <div class="container mx-auto px-4">
      <!-- Text Content -->
      <div class="text-center">
        <h1 class="text-7xl md:text-7xl sm:text-4xl leading-tight mb-4 text-orange-100 font-instrument-serif">Maryland’s Premier Security Training Academy </h1>
        <div class="flex flex-col md:flex-row justify-center items-center gap-x-8 gap-y-4 text-lg text-white">
          <div class="flex items-center gap-2">
            <i class="fas fa-certificate text-orange-100 text-xl"></i>
            <span>State-Certified</span>
          </div>
          <div class="flex items-center gap-2">
            <i class="fas fa-user-tie text-orange-100 text-xl"></i>
            <span>Experienced Instructors</span>
          </div>
          <div class="flex items-center gap-2">
            <i class="fas fa-calendar-alt text-orange-100 text-xl"></i>
            <span>Flexible Scheduling</span>
          </div>
        </div>
      </div>

      <?php get_template_part('template-parts/upcoming-classes-section'); ?>
    </div>
  </section>

  <!-- Find Us Section -->
  <section class="py-20 bg-white">
    <div class="container mx-auto px-4">
      <h2 class="text-4xl font-bold text-navy mb-8 text-center">How to Find Us</h2>
      <div class="grid md:grid-cols-2 gap-8 items-center">
        <div class="bg-gray-50 p-6 rounded-lg shadow-lg">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3094.0239088652147!2d-76.52236872458171!3d39.15143783167563!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89b7ffa9978295f7%3A0xb1deb57a4af8b76f!2sSecurity%20Training%20academy!5e0!3m2!1sen!2stn!4v1753547801368!5m2!1sen!2stn" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="rounded-lg"></iframe>
        </div>
        <div class="text-navy">
          <h3 class="text-3xl font-bold mb-4">Visit Our Training Facility</h3>
          <p class="mb-6 text-lg">Located in the heart of Pasadena, Maryland, our state-of-the-art training facility is easily accessible and equipped with everything you need for your security training journey.</p>
          
          <div class="space-y-4">
            <div class="flex items-start">
              <div class="bg-navy text-white p-2 rounded-full mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
              </div>
              <div>
                <h4 class="font-bold text-lg">Address</h4>
                <p>8567 Fort Smallwood Rd unit C,<br>Pasadena, MD 21122, United States</p>
              </div>
            </div>
            
            <div class="flex items-start">
              <div class="bg-navy text-white p-2 rounded-full mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
              </div>
              <div>
                <h4 class="font-bold text-lg">Hours</h4>
                <p>Monday - Friday: 9:00 AM - 5:00 PM<br>Saturday: 10:00 AM - 3:00 PM<br>Sunday: Closed</p>
              </div>
            </div>
            
            <div class="flex items-start">
              <div class="bg-navy text-white p-2 rounded-full mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
              </div>
              <div>
                <h4 class="font-bold text-lg">Contact</h4>
                <p>Phone: (410) 255-0000<br>Email: info@securitytrainingclasses.com</p>
              </div>
            </div>
          </div>
          
        </div>
      </div>
    </div>
  </section>

  <!-- Training Glimpse Section -->
  <section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl font-bold text-navy mb-12 text-center">A Glimpse Into Our Training</h2>
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <!-- Text Content -->
            <div class="text-navy order-2 md:order-1">
                <h3 class="text-3xl font-bold mb-4">Launch Your Career with Maryland's Top Security Training Academy</h3>
                <h4 class="text-2xl text-safety-orange font-bold mb-6">Train. Certify. Get Hired.</h4>
                
                <p class="mb-6">At Security Training Academy, we help you turn ambition into opportunity. Our expert-led programs prepare you for high-demand roles in the security and law enforcement field. Whether you're entering the industry or expanding your credentials, we have the training and support you need to succeed.</p>
                
                <p class="mb-6">Our comprehensive curriculum is designed by industry veterans with decades of experience. From basic security officer training to advanced firearms certification and specialized police officer programs, we offer the full spectrum of security education.</p>
                
                <p class="mb-6">With small class sizes, hands-on training scenarios, and personalized attention, we ensure that every student masters the skills needed to excel in their security career.</p>
                
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="#upcoming-classes" class="bg-safety-orange text-white font-bold py-3 px-6 rounded hover:bg-opacity-90 transition-colors">View Upcoming Classes</a>
                    <a href="#contact" class="bg-navy text-white font-bold py-3 px-6 rounded hover:bg-opacity-90 transition-colors">Contact Us</a>
                </div>
            </div>
            
            <!-- Image Collage -->
            <div class="order-1 md:order-2">
                <div class="grid grid-cols-3 grid-rows-3 gap-3 h-[28rem] mx-auto">
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
                        <img src="https://www.securitytrainingclasses.com/wp-content/uploads/2023/08/instructorimage22.jpg" alt="Security equipment" class="w-full h-full object-cover">
                    </div>
                    <!-- Bottom left image -->
                    <div class="rounded-lg overflow-hidden shadow-lg">
                        <img src="https://www.securitytrainingclasses.com/wp-content/uploads/2022/12/AdobeStock_169813314-1.jpg" alt="Training classroom" class="w-full h-full object-cover">
                    </div>
                    <!-- Bottom right image -->
                    <div class="rounded-lg overflow-hidden shadow-lg">
                        <img src="https://www.securitytrainingclasses.com/wp-content/uploads/2022/12/AdobeStock_318705595-scaled.jpeg" alt="Security badge" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </div>
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
            <p class="text-3xl font-bold text-safety-orange">Since 2018</p>
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

  
  <?php get_template_part('template-parts/faq-section'); ?>

  <?php get_template_part('template-parts/contact-section'); ?>
  
</main>

<?php get_footer(); ?>
