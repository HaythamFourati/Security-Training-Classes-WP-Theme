<?php
/**
 * Template Name: Security Guard Training
 *
 * This template is used to display security guard training classes.
 *
 * @package Security_Training_Classes
 */

get_header();
?>

<main>
  <!-- Page Header -->
  <section class="bg-gradient-to-l from-[var(--color-navy)] to-blue-800 text-white py-20 -mt-32 pt-56">
    <div class="container mx-auto px-4 text-center">
      <h1 class="text-5xl md:text-6xl font-instrument-serif leading-tight mb-4">Security Guard Training</h1>
      <p class="text-lg md:text-xl text-gray-300 mb-8">Professional security guard certification courses to advance your career</p>
    </div>
  </section>

  <!-- Introduction Section -->
  <section class="py-16 bg-white">
    <div class="container mx-auto px-4">
      <div class="max-w-3xl mx-auto">
        <h2 class="text-3xl font-bold text-navy mb-6">Start Your Security Career with Professional Training</h2>
        <div class="prose max-w-none text-steel-gray">
          <p>Our comprehensive security guard training programs are designed to prepare you for a successful career in the security industry. Led by experienced instructors with real-world experience, our courses provide the knowledge and skills required to excel in this growing field.</p>
          
          <p>Maryland security guards must complete state-approved training to obtain their security guard certification. Our courses are fully compliant with Maryland state requirements and will prepare you to pass the necessary examinations.</p>
          
          <h3 class="text-2xl font-bold text-navy mt-8 mb-4">Why Choose Our Security Guard Training?</h3>
          <ul>
            <li>State-certified training programs</li>
            <li>Experienced instructors with law enforcement backgrounds</li>
            <li>Hands-on practical training scenarios</li>
            <li>Small class sizes for personalized attention</li>
            <li>Flexible scheduling options</li>
            <li>Job placement assistance</li>
            <li>Affordable tuition with payment plans available</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- Guard Training Classes Section -->
  <?php get_template_part('template-parts/render-filtered-classes', null, ['filter_term' => 'Guard']); ?>

  <!-- Career Opportunities Section -->
  <section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
      <div class="max-w-3xl mx-auto">
        <h2 class="text-3xl font-bold text-navy mb-6">Career Opportunities in Security</h2>
        <div class="prose max-w-none text-steel-gray">
          <p>After completing our security guard training, you'll be qualified for various positions in the security industry, including:</p>
          
          <ul>
            <li>Unarmed Security Guard</li>
            <li>Armed Security Guard</li>
            <li>Loss Prevention Specialist</li>
            <li>Security Supervisor</li>
            <li>Event Security</li>
            <li>Corporate Security</li>
            <li>Residential Security</li>
          </ul>
          
          <p class="mt-6">The security industry offers stable employment with opportunities for advancement. Many of our graduates have gone on to successful careers with leading security companies throughout Maryland and the surrounding areas.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ Section -->
  <?php get_template_part('template-parts/faq-section'); ?>

  <!-- Contact Section -->
  <?php get_template_part('template-parts/contact-section'); ?>
</main>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // FAQ Accordion functionality
    const faqButtons = document.querySelectorAll('#faq-accordion button');
    
    faqButtons.forEach(button => {
      button.addEventListener('click', function() {
        const content = this.nextElementSibling;
        const icon = this.querySelector('svg');
        
        // Toggle content
        if (content.classList.contains('hidden')) {
          content.classList.remove('hidden');
          content.style.maxHeight = content.scrollHeight + 'px';
          icon.classList.add('rotate-180');
        } else {
          content.classList.add('hidden');
          content.style.maxHeight = null;
          icon.classList.remove('rotate-180');
        }
      });
    });
  });
</script>

<?php get_footer(); ?>
