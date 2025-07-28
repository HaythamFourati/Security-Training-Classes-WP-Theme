<?php
/**
 * Template Name: USCCA Classes
 *
 * This template is used to display USCCA training classes.
 *
 * @package Security_Training_Classes
 */

get_header();
?>

<main>
  <!-- Page Header -->
  <section class="bg-gradient-to-l from-[var(--color-navy)] to-blue-800 text-white py-20 -mt-32 pt-56">
    <div class="container mx-auto px-4 text-center">
      <h1 class="text-5xl md:text-6xl font-instrument-serif leading-tight mb-4">USCCA Classes</h1>
      <p class="text-lg md:text-xl text-gray-300 mb-8">United States Concealed Carry Association training and certification programs</p>
    </div>
  </section>

  <!-- USCCA Training Classes Section -->
  <?php get_template_part('template-parts/render-filtered-classes', null, ['filter_term' => 'USCCA']); ?>

  <!-- FAQ Section -->
  <?php get_template_part('template-parts/faq-section'); ?>

  <!-- Contact Section -->
  <?php get_template_part('template-parts/contact-section'); ?>
</main>

<?php get_footer(); ?>
