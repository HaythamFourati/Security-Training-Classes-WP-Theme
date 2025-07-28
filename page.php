<?php
/**
 * The template for displaying all pages
 *
 * @package Security_Training_Classes
 */

get_header();
?>

<main>
  <?php while (have_posts()) : the_post(); ?>
    
    <!-- Page Header -->
    <section class="bg-gradient-to-l from-[var(--color-navy)] to-blue-800 text-white py-20 -mt-32 pt-56">
      <div class="container mx-auto px-4 text-center">
        <h1 class="text-5xl md:text-6xl font-instrument-serif leading-tight mb-4"><?php the_title(); ?></h1>
        <?php if (get_the_excerpt()) : ?>
          <p class="text-lg md:text-xl text-gray-300 mb-8"><?php echo get_the_excerpt(); ?></p>
        <?php endif; ?>
      </div>
    </section>

    <!-- Page Content -->
    <section class="py-20 bg-white">
      <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
          
          <?php if (has_post_thumbnail()) : ?>
            <!-- Featured Image -->
            <div class="mb-12">
              <div class="rounded-lg overflow-hidden shadow-lg">
                <?php the_post_thumbnail('full', array('class' => 'w-full h-auto')); ?>
              </div>
            </div>
          <?php endif; ?>
          
          <!-- Page Content -->
          <div class="prose prose-lg max-w-none">
            <?php the_content(); ?>
          </div>
          
          <!-- Page Links (for multi-page content) -->
          <?php
          wp_link_pages(array(
            'before' => '<div class="page-links mt-8 text-center"><span class="page-links-title text-navy font-semibold">Pages: </span>',
            'after'  => '</div>',
            'link_before' => '<span class="inline-block bg-gray-100 hover:bg-safety-orange hover:text-white text-navy px-3 py-1 rounded transition-colors mr-2">',
            'link_after'  => '</span>',
          ));
          ?>
          
        </div>
      </div>
    </section>
    
  <?php endwhile; ?>
  
  <!-- FAQ Section -->
  <?php get_template_part('template-parts/faq-section'); ?>
  
  <!-- Contact Section -->
  <?php get_template_part('template-parts/contact-section'); ?>
</main>

<?php get_footer(); ?>
