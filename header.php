<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:wght@400;700&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
  </head>
  <body <?php body_class(); ?>>
<header id="main-header" class="text-white">
  <div id="header-container" class="container mx-auto flex justify-between items-center p-4">
    <!-- Logo -->
    <div>
      <a href="<?php echo get_home_url(); ?>">
        <img src="https://www.securitytrainingclasses.com/wp-content/uploads/2025/07/STA-WHITE.png" alt="Security Training Academy Logo" class="h-12 w-auto">
      </a>
    </div>

    <!-- Desktop Navigation Menu -->
    <nav class="hidden md:flex space-x-6 items-center">
      <a href="<?php echo get_home_url(); ?>" class="hover:text-safety-orange transition-colors">Home</a>
      <!-- Classes Dropdown -->
      <div class="relative group">
        <button class="hover:text-safety-orange transition-colors flex items-center cursor-pointer">
          Classes
          <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </button>
        <div class="absolute left-0 pt-2 w-80 rounded-md shadow-xl bg-white hidden group-hover:block z-50 transform origin-top-left transition-all duration-150 ease-out">
          <div class="py-2 text-navy rounded-t-md overflow-hidden">
            <a href="<?php echo get_permalink(get_page_by_path('all-classes')); ?>" class="block px-5 py-3 text-sm hover:bg-gray-100 hover:text-safety-orange transition-colors border-l-4 border-transparent hover:border-safety-orange flex items-center">
              <i class="fas fa-th-list mr-3 text-navy"></i>
              <span>ALL CLASSES</span>
            </a>
            <a href="/security-guard-training" class="block px-5 py-3 text-sm hover:bg-gray-100 hover:text-safety-orange transition-colors border-l-4 border-transparent hover:border-safety-orange flex items-center">
              <i class="fas fa-user-shield mr-3 text-navy"></i>
              <span>Security Guard Training</span>
            </a>
            <a href="/firearms-certifications" class="block px-5 py-3 text-sm hover:bg-gray-100 hover:text-safety-orange transition-colors border-l-4 border-transparent hover:border-safety-orange flex items-center">
              <i class="fas fa-bullseye mr-3 text-navy"></i>
              <span>Firearms Certifications MD & Multi State</span>
            </a>
            <a href="/special-police-training" class="block px-5 py-3 text-sm hover:bg-gray-100 hover:text-safety-orange transition-colors border-l-4 border-transparent hover:border-safety-orange flex items-center">
              <i class="fas fa-shield-alt mr-3 text-navy"></i>
              <span>Special Police Training</span>
            </a>
            <a href="/nra-classes" class="block px-5 py-3 text-sm hover:bg-gray-100 hover:text-safety-orange transition-colors border-l-4 border-transparent hover:border-safety-orange flex items-center">
              <i class="fas fa-medal mr-3 text-navy"></i>
              <span>NRA Classes</span>
            </a>
            <a href="/uscca-classes" class="block px-5 py-3 text-sm hover:bg-gray-100 hover:text-safety-orange transition-colors border-l-4 border-transparent hover:border-safety-orange flex items-center">
              <i class="fas fa-certificate mr-3 text-navy"></i>
              <span>USCCA Classes</span>
            </a>
            <a href="/life-saving-courses" class="block px-5 py-3 text-sm hover:bg-gray-100 hover:text-safety-orange transition-colors border-l-4 border-transparent hover:border-safety-orange flex items-center">
              <i class="fas fa-heartbeat mr-3 text-navy"></i>
              <span>Life Saving Courses, CPR, ACLS, PALS</span>
            </a>
          </div>
        </div>
      </div>
      
      <a href="#faq" class="hover:text-safety-orange transition-colors">FAQs</a>
      <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="hover:text-safety-orange transition-colors">Blog</a>
      <a href="#contact" class="hover:text-safety-orange transition-colors">Contact Us</a>
      <a href="https://www.policeprotectionservicesllc.com/" target="_blank" class="hover:text-safety-orange transition-colors flex items-center">
        Police Protection Services
        <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
      </a>
    </nav>

    <!-- Right-side buttons -->
    <div class="hidden md:flex items-center space-x-4">
        <a href="tel:<?php echo esc_attr($GLOBALS['phone_number']); ?>" class="text-sm flex items-center space-x-2">
            <!-- Simple Phone Icon from Font Awesome -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor" class="w-5 h-5">
                <path d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"/>
            </svg>
            <span class="text-white text-lg"><?php echo esc_html($GLOBALS['phone_number']); ?></span>
        </a>
        <a href="https://bookeo.com/securitytrainingacademy" target="_blank" class="bg-safety-orange text-white font-bold py-2 px-4 rounded hover:bg-opacity-90 transition-colors">
            Book Now
        </a>
    </div>
    
    <!-- Mobile Menu Button -->
    <div class="md:hidden">
        <button id="mobile-menu-button" class="text-white focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
        </button>
    </div>
  </div>
  
  <!-- Mobile Menu Overlay -->
  <div id="mobile-menu" class="md:hidden fixed inset-0 z-50 hidden">
    <!-- Background overlay -->
    <div class="fixed inset-0 bg-black bg-opacity-50" id="mobile-menu-overlay"></div>
    
    <!-- Menu content -->
    <div class="fixed top-0 left-0 w-full bg-navy shadow-lg transform transition-transform duration-300 ease-in-out">
      <!-- Header with close button -->
      <div class="flex justify-between items-center p-4 border-b border-steel-gray">
        <img src="https://www.securitytrainingclasses.com/wp-content/uploads/2025/07/STA-WHITE.png" alt="Security Training Academy Logo" class="h-10 w-auto">
        <button id="mobile-menu-close" class="text-white focus:outline-none">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
      </div>
      
      <!-- Navigation -->
      <nav class="flex flex-col p-4 max-h-screen overflow-y-auto">
        <a href="<?php echo get_home_url(); ?>" class="hover:text-safety-orange transition-colors py-3 border-b border-steel-gray border-opacity-30">Home</a>
        
        <!-- Mobile Classes Sub-menu -->
        <div class="border-b border-steel-gray border-opacity-30">
          <button id="mobile-classes-toggle" class="w-full flex justify-between items-center font-bold text-white py-3">
            <span>Classes</span>
            <svg class="w-4 h-4 transition-transform transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
          </button>
          <div id="mobile-classes-submenu" class="hidden flex flex-col pl-4 pb-2 border-l-2 border-safety-orange ml-2">
              <a href="<?php echo get_permalink(get_page_by_path('all-classes')); ?>" class="hover:text-safety-orange transition-colors py-2 flex items-center">
                <i class="fas fa-th-list mr-3 text-safety-orange w-4"></i>
                <span>ALL CLASSES</span>
              </a>
              <a href="/security-guard-training" class="hover:text-safety-orange transition-colors py-2 flex items-center">
                <i class="fas fa-user-shield mr-3 text-safety-orange w-4"></i>
                <span>Security Guard Training</span>
              </a>
              <a href="/firearms-certifications" class="hover:text-safety-orange transition-colors py-2 flex items-center">
                <i class="fas fa-bullseye mr-3 text-safety-orange w-4"></i>
                <span>Firearms Certifications</span>
              </a>
              <a href="/special-police-training" class="hover:text-safety-orange transition-colors py-2 flex items-center">
                <i class="fas fa-shield-alt mr-3 text-safety-orange w-4"></i>
                <span>Special Police Training</span>
              </a>
              <a href="/nra-classes" class="hover:text-safety-orange transition-colors py-2 flex items-center">
                <i class="fas fa-medal mr-3 text-safety-orange w-4"></i>
                <span>NRA Classes</span>
              </a>
              <a href="/uscca-classes" class="hover:text-safety-orange transition-colors py-2 flex items-center">
                <i class="fas fa-certificate mr-3 text-safety-orange w-4"></i>
                <span>USCCA Classes</span>
              </a>
              <a href="/life-saving-courses" class="hover:text-safety-orange transition-colors py-2 flex items-center">
                <i class="fas fa-heartbeat mr-3 text-safety-orange w-4"></i>
                <span>Life Saving Courses</span>
              </a>
          </div>
        </div>

        <a href="https://www.policeprotectionservicesllc.com/" target="_blank" class="hover:text-safety-orange transition-colors py-3 border-b border-steel-gray border-opacity-30 flex items-center">
          Police Protection Services
          <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
        </a>
        <a href="#faq" class="hover:text-safety-orange transition-colors py-3 border-b border-steel-gray border-opacity-30">FAQs</a>
        <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="hover:text-safety-orange transition-colors py-3 border-b border-steel-gray border-opacity-30">Blog</a>
        <a href="#contact" class="hover:text-safety-orange transition-colors py-3 border-b border-steel-gray border-opacity-30">Contact Us</a>
        
        <!-- Call to Action Buttons -->
        <div class="mt-6 space-y-3">
          <a href="https://bookeo.com/securitytrainingacademy" target="_blank" class="block bg-safety-orange text-white font-bold py-3 px-4 rounded hover:bg-opacity-90 transition-colors text-center">
            Book Now
          </a>
          <a href="tel:<?php echo esc_attr($GLOBALS['phone_number']); ?>" class="block text-center py-2 text-white border border-white rounded hover:bg-white hover:text-navy transition-colors">
            Call Us: <?php echo esc_html($GLOBALS['phone_number']); ?>
          </a>
        </div>
      </nav>
    </div>
  </div>
</header>