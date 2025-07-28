<?php
/**
 * Template Name: Life Saving Courses
 *
 * This template is used to display life saving training courses.
 *
 * @package Security_Training_Classes
 */

get_header();
?>

<main>
  <!-- Page Header -->
  <section class="bg-gradient-to-l from-[var(--color-navy)] to-blue-800 text-white py-20 -mt-32 pt-56">
    <div class="container mx-auto px-4 text-center">
      <h1 class="text-5xl md:text-6xl font-instrument-serif leading-tight mb-4">Life Saving Courses</h1>
      <p class="text-lg md:text-xl text-gray-300 mb-8">Essential CPR, first aid, and emergency response training courses</p>
    </div>
  </section>

  <!-- Life Saving Training Classes Section -->
  <?php get_template_part('template-parts/render-filtered-classes', null, ['filter_term' => 'Life Saving']); ?>

  <!-- FAQ Section -->
  <?php get_template_part('template-parts/faq-section'); ?>

  <!-- Contact Section -->
  <?php get_template_part('template-parts/contact-section'); ?>
</main>

<?php get_footer(); ?>
