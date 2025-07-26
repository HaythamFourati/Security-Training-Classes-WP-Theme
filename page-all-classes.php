<?php
/**
 * Template Name: All Classes
 *
 * This template is used to display all available classes.
 *
 * @package Security_Training_Classes
 */

get_header();
?>

<main>
  <!-- Page Header -->
  <section class="bg-gradient-to-l from-[var(--color-navy)] to-blue-800 text-white py-20 -mt-32 pt-56">
    <div class="container mx-auto px-4 text-center">
      <h1 class="text-5xl md:text-6xl font-extrabold leading-tight mb-4">All Classes</h1>
      <p class="text-lg md:text-xl text-gray-300 mb-8">Browse our complete catalog of security training courses</p>
    </div>
  </section>

  <?php get_template_part('template-parts/render-all-classes'); ?>
</main>

<?php get_footer(); ?>
