<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
  </head>
  <body <?php body_class(); ?>>
<header id="main-header" class="text-white">
  <div class="container mx-auto flex justify-between items-center p-4">
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
        <button class="hover:text-safety-orange transition-colors flex items-center">
          Classes
          <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </button>
        <div class="absolute left-0 pt-2 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden group-hover:block z-50">
          <div class="py-1 text-navy">
            <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100">ALL CLASSES</a>
            <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100">Security Guard Training</a>
            <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100">Firearms Certifications MD & Multi State</a>
            <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100">Special Police Training</a>
            <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100">NRA Classes</a>
            <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100">USCCA Classes</a>
            <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100">Life Saving Courses, CPR, ACLS, PALS</a>
          </div>
        </div>
      </div>
      <a href="#" class="hover:text-safety-orange transition-colors">Schedule & Registration</a>
      <a href="#" class="hover:text-safety-orange transition-colors">FAQs</a>
      <a href="#" class="hover:text-safety-orange transition-colors">Contact Us</a>
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
        <a href="#" class="bg-safety-orange text-white font-bold py-2 px-4 rounded hover:bg-opacity-90 transition-colors">
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
  
  <!-- Mobile Menu -->
  <div id="mobile-menu" class="md:hidden hidden bg-navy">
    <nav class="flex flex-col space-y-2 p-4">
      <a href="<?php echo get_home_url(); ?>" class="hover:text-safety-orange transition-colors py-2">Home</a>
      
      <!-- Mobile Classes Sub-menu -->
      <div class="py-2">
        <button id="mobile-classes-toggle" class="w-full flex justify-between items-center font-bold text-white">
          <span>Classes</span>
          <svg class="w-4 h-4 transition-transform transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </button>
        <div id="mobile-classes-submenu" class="hidden flex flex-col space-y-2 pl-4 mt-2">
            <a href="#" class="hover:text-safety-orange transition-colors">ALL CLASSES</a>
            <a href="#" class="hover:text-safety-orange transition-colors">Security Guard Training</a>
            <a href="#" class="hover:text-safety-orange transition-colors">Firearms Certifications MD & Multi State</a>
            <a href="#" class="hover:text-safety-orange transition-colors">Special Police Training</a>
            <a href="#" class="hover:text-safety-orange transition-colors">NRA Classes</a>
            <a href="#" class="hover:text-safety-orange transition-colors">USCCA Classes</a>
            <a href="#" class="hover:text-safety-orange transition-colors">Life Saving Courses, CPR, ACLS, PALS</a>
        </div>
      </div>

      <a href="#" class="hover:text-safety-orange transition-colors py-2">Schedule & Registration</a>
      <a href="#" class="hover:text-safety-orange transition-colors py-2">FAQs</a>
      <a href="#" class="hover:text-safety-orange transition-colors py-2">Contact Us</a>
      <div class="border-t border-steel-gray my-2"></div>
      <a href="#" class="bg-safety-orange text-white font-bold py-2 px-4 rounded hover:bg-opacity-90 transition-colors mt-2 text-center">
        Book Now
      </a>
      <a href="tel:<?php echo esc_attr($GLOBALS['phone_number']); ?>" class="text-sm text-center mt-2">Call Us: <?php echo esc_html($GLOBALS['phone_number']); ?></a>
    </nav>
  </div>
</header>