<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Security_Training_Classes
 */

get_header();
?>

<main>
  <!-- 404 Header -->
  <section class="bg-gradient-to-l from-[var(--color-navy)] to-blue-800 text-white py-20 -mt-32 pt-56">
    <div class="container mx-auto px-4 text-center">
      <div class="max-w-3xl mx-auto">
        <div class="mb-8">
          <svg class="w-32 h-32 mx-auto text-white opacity-50 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
          </svg>
        </div>
        <h1 class="text-6xl md:text-8xl font-instrument-serif leading-tight mb-4">404</h1>
        <h2 class="text-3xl md:text-4xl font-instrument-serif leading-tight mb-6">Page Not Found</h2>
        <p class="text-lg md:text-xl text-gray-300 mb-8">Sorry, the page you're looking for doesn't exist or has been moved.</p>
      </div>
    </div>
  </section>

  <!-- 404 Content -->
  <section class="py-20 bg-white">
    <div class="container mx-auto px-4">
      <div class="max-w-4xl mx-auto text-center">

        <!-- Quick Links -->
        <div class="mb-12">
          <h3 class="text-2xl font-bold text-navy mb-8">Try other pages:</h3>
          <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- Home -->
            <a href="<?php echo home_url(); ?>" class="group bg-gray-50 hover:bg-[#ff6600] hover:text-white p-6 rounded-lg transition-all duration-300 transform hover:-translate-y-1">
              <div class="text-center">
                <svg class="w-12 h-12 mx-auto mb-4 text-navy group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <h4 class="text-lg font-bold text-navy group-hover:text-white mb-2">Home</h4>
                <p class="text-steel-gray group-hover:text-white text-sm">Return to our homepage</p>
              </div>
            </a>
            
            <!-- All Classes -->
            <a href="<?php echo get_permalink(get_page_by_path('all-classes')); ?>" class="group bg-gray-50 hover:bg-[#ff6600] hover:text-white p-6 rounded-lg transition-all duration-300 transform hover:-translate-y-1">
              <div class="text-center">
                <svg class="w-12 h-12 mx-auto mb-4 text-navy group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                <h4 class="text-lg font-bold text-navy group-hover:text-white mb-2">All Classes</h4>
                <p class="text-steel-gray group-hover:text-white text-sm">Browse our training courses</p>
              </div>
            </a>
            
            <!-- Security Guard Training -->
            <a href="/security-guard-training" class="group bg-gray-50 hover:bg-[#ff6600] hover:text-white p-6 rounded-lg transition-all duration-300 transform hover:-translate-y-1">
              <div class="text-center">
                <svg class="w-12 h-12 mx-auto mb-4 text-navy group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                <h4 class="text-lg font-bold text-navy group-hover:text-white mb-2">Security Training</h4>
                <p class="text-steel-gray group-hover:text-white text-sm">Professional security courses</p>
              </div>
            </a>
            
            <!-- Blog -->
            <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="group bg-gray-50 hover:bg-[#ff6600] hover:text-white p-6 rounded-lg transition-all duration-300 transform hover:-translate-y-1">
              <div class="text-center">
                <svg class="w-12 h-12 mx-auto mb-4 text-navy group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
                <h4 class="text-lg font-bold text-navy group-hover:text-white mb-2">Blog</h4>
                <p class="text-steel-gray group-hover:text-white text-sm">Training tips and insights</p>
              </div>
            </a>
            
            <!-- Firearms Training -->
            <a href="/firearms-certifications" class="group bg-gray-50 hover:bg-[#ff6600] hover:text-white p-6 rounded-lg transition-all duration-300 transform hover:-translate-y-1">
              <div class="text-center">
                <svg class="w-12 h-12 mx-auto mb-4 text-navy group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                <h4 class="text-lg font-bold text-navy group-hover:text-white mb-2">Firearms Training</h4>
                <p class="text-steel-gray group-hover:text-white text-sm">Weapons certification courses</p>
              </div>
            </a>
            
            <!-- Contact -->
            <a href="#contact" class="group bg-gray-50 hover:bg-[#ff6600] hover:text-white p-6 rounded-lg transition-all duration-300 transform hover:-translate-y-1">
              <div class="text-center">
                <svg class="w-12 h-12 mx-auto mb-4 text-navy group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <h4 class="text-lg font-bold text-navy group-hover:text-white mb-2">Contact Us</h4>
                <p class="text-steel-gray group-hover:text-white text-sm">Get in touch with us</p>
              </div>
            </a>
            
          </div>
        </div>
        
        <!-- Help Text -->
        <div class="bg-gray-50 p-8 rounded-lg">
          <h3 class="text-xl font-bold text-navy mb-4">Need Help?</h3>
          <p class="text-steel-gray mb-6">If you can't find what you're looking for, our team is here to help you get the security training you need.</p>
          <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="tel:<?php echo esc_attr($GLOBALS['phone_number']); ?>" class="inline-flex items-center justify-center bg-navy text-white font-bold py-3 px-6 rounded hover:bg-opacity-90 transition-colors">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
              </svg>
              Call Us
            </a>
            <a href="https://bookeo.com/securitytrainingacademy" target="_blank" class="inline-flex items-center justify-center bg-safety-orange text-white font-bold py-3 px-6 rounded hover:bg-opacity-90 transition-colors">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
              </svg>
              Book Training
            </a>
          </div>
        </div>
        
      </div>
    </div>
  </section>
  
  <!-- Contact Section -->
  <?php get_template_part('template-parts/contact-section'); ?>
</main>

<?php get_footer(); ?>
