<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
  </head>
  <body <?php body_class(); ?>>
<header class="bg-navy text-white shadow-md sticky top-0 z-50">
  <div class="container mx-auto flex justify-between items-center p-4">
    <!-- Logo -->
    <div class="text-2xl font-bold">
      <a href="<?php echo get_home_url(); ?>">Security Training Classes</a>
    </div>

    <!-- Desktop Navigation Menu -->
    <nav class="hidden md:flex space-x-6 items-center">
      <a href="<?php echo get_home_url(); ?>" class="hover:text-safety-orange transition-colors">Home</a>
      <a href="#" class="hover:text-safety-orange transition-colors">Security Guard Training</a>
      <a href="#" class="hover:text-safety-orange transition-colors">Firearms Certification</a>
      <a href="#" class="hover:text-safety-orange transition-colors">SPO Training</a>
      <a href="#" class="hover:text-safety-orange transition-colors">Schedule & Registration</a>
      <a href="#" class="hover:text-safety-orange transition-colors">FAQs</a>
      <a href="#" class="hover:text-safety-orange transition-colors">Contact Us</a>
    </nav>

    <!-- Right-side buttons -->
    <div class="hidden md:flex items-center space-x-4">
        <a href="tel:<?php echo esc_attr($GLOBALS['phone_number']); ?>" class="text-sm">Call Us: <?php echo esc_html($GLOBALS['phone_number']); ?></a>
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
    <nav class="flex flex-col space-y-4 p-4">
      <a href="<?php echo get_home_url(); ?>" class="hover:text-safety-orange transition-colors">Home</a>
      <a href="#" class="hover:text-safety-orange transition-colors">Security Guard Training</a>
      <a href="#" class="hover:text-safety-orange transition-colors">Firearms Certification</a>
      <a href="#" class="hover:text-safety-orange transition-colors">SPO Training</a>
      <a href="#" class="hover:text-safety-orange transition-colors">Schedule & Registration</a>
      <a href="#" class="hover:text-safety-orange transition-colors">FAQs</a>
      <a href="#" class="hover:text-safety-orange transition-colors">Contact Us</a>
      <div class="border-t border-steel-gray my-2"></div>
      <a href="#" class="bg-safety-orange text-white font-bold py-2 px-4 rounded hover:bg-opacity-90 transition-colors mt-2 text-center">
        Book Now
      </a>
      <a href="tel:123-456-7890" class="text-sm text-center mt-2">Call Us: (123) 456-7890</a>
    </nav>
  </div>
</header>