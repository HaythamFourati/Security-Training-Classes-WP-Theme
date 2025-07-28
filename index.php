<?php
/**
 * The main template file for displaying blog posts
 *
 * @package Security_Training_Classes
 */

get_header();
?>

<main>
  <!-- Blog Header -->
  <section class="bg-gradient-to-l from-[var(--color-navy)] to-blue-800 text-white py-20 -mt-32 pt-56">
    <div class="container mx-auto px-4 text-center">
      <h1 class="text-5xl md:text-6xl font-instrument-serif leading-tight mb-4">Security Training Blog</h1>
      <p class="text-lg md:text-xl text-gray-300 mb-8">Expert insights, training tips, and industry news from our certified instructors</p>
    </div>
  </section>

  <!-- Blog Posts Section -->
  <section class="py-20 bg-white">
    <div class="container mx-auto px-4">
      <div class="max-w-6xl mx-auto">
        
        <?php if (have_posts()) : ?>
          <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            <?php while (have_posts()) : the_post(); ?>
              <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <?php if (has_post_thumbnail()) : ?>
                  <div class="aspect-w-16 aspect-h-9 overflow-hidden">
                    <a href="<?php the_permalink(); ?>">
                      <?php the_post_thumbnail('medium_large', array('class' => 'w-full h-48 object-cover hover:scale-105 transition-transform duration-300')); ?>
                    </a>
                  </div>
                <?php else : ?>
                  <div class="w-full h-48 bg-gradient-to-br from-navy to-blue-800 flex items-center justify-center">
                    <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                  </div>
                <?php endif; ?>
                
                <div class="p-6">
                  <!-- Post Meta -->
                  <div class="flex items-center text-sm text-steel-gray mb-3">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date('F j, Y'); ?></time>
                    <span class="mx-2">•</span>
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span><?php echo get_the_author(); ?></span>
                  </div>
                  
                  <!-- Post Title -->
                  <h2 class="text-xl font-bold text-navy mb-3 hover:text-safety-orange transition-colors">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                  </h2>
                  
                  <!-- Post Excerpt -->
                  <div class="text-steel-gray mb-4">
                    <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                  </div>
                  
                  <!-- Categories -->
                  <?php $categories = get_the_category(); ?>
                  <?php if (!empty($categories)) : ?>
                    <div class="flex flex-wrap gap-2 mb-4">
                      <?php foreach ($categories as $category) : ?>
                        <span class="inline-block bg-gray-100 text-navy text-xs px-2 py-1 rounded-full">
                          <?php echo esc_html($category->name); ?>
                        </span>
                      <?php endforeach; ?>
                    </div>
                  <?php endif; ?>
                  
                  <!-- Read More Button -->
                  <a href="<?php the_permalink(); ?>" class="inline-flex items-center text-safety-orange font-semibold hover:text-navy transition-colors">
                    Read More
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                  </a>
                </div>
              </article>
            <?php endwhile; ?>
          </div>
          
          <!-- Pagination -->
          <div class="flex justify-center mt-12">
            <?php
            $pagination = paginate_links(array(
              'prev_text' => false,
              'next_text' => false,
              'type' => 'array',
              'mid_size' => 2,
              'end_size' => 1
            ));
            
            if ($pagination) :
            ?>
              <nav class="flex items-center space-x-2" aria-label="Pagination Navigation">
                <!-- Previous Button -->
                <?php if (get_previous_posts_link()) : ?>
                  <a href="<?php echo get_previous_posts_page_link(); ?>" class="inline-flex items-center px-4 py-2 text-sm font-medium text-navy bg-white border border-gray-300 rounded-l-md hover:bg-gray-50 hover:text-safety-orange transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Previous
                  </a>
                <?php else : ?>
                  <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-300 rounded-l-md cursor-not-allowed">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Previous
                  </span>
                <?php endif; ?>
                
                <!-- Page Numbers -->
                <div class="flex">
                  <?php foreach ($pagination as $page) : ?>
                    <?php if (strpos($page, 'current') !== false) : ?>
                      <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-safety-orange border border-safety-orange">
                        <?php echo strip_tags($page); ?>
                      </span>
                    <?php elseif (strpos($page, 'dots') !== false) : ?>
                      <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300">
                        ...
                      </span>
                    <?php else : ?>
                      <?php echo str_replace(
                        'class="page-numbers"',
                        'class="inline-flex items-center px-4 py-2 text-sm font-medium text-navy bg-white border border-gray-300 hover:bg-gray-50 hover:text-safety-orange transition-colors"',
                        $page
                      ); ?>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </div>
                
                <!-- Next Button -->
                <?php if (get_next_posts_link()) : ?>
                  <a href="<?php echo get_next_posts_page_link(); ?>" class="inline-flex items-center px-4 py-2 text-sm font-medium text-navy bg-white border border-gray-300 rounded-r-md hover:bg-gray-50 hover:text-safety-orange transition-colors">
                    Next
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                  </a>
                <?php else : ?>
                  <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-300 rounded-r-md cursor-not-allowed">
                    Next
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                  </span>
                <?php endif; ?>
              </nav>
            <?php endif; ?>
          </div>
          
        <?php else : ?>
          <!-- No Posts Found -->
          <div class="text-center py-12">
            <svg class="w-24 h-24 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h2 class="text-2xl font-bold text-navy mb-4">No Blog Posts Yet</h2>
            <p class="text-steel-gray mb-6">We're working on creating valuable content for you. Check back soon for expert insights on security training!</p>
            <a href="<?php echo home_url(); ?>" class="inline-flex items-center bg-safety-orange text-white font-bold py-3 px-6 rounded hover:bg-opacity-90 transition-colors">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
              </svg>
              Return Home
            </a>
          </div>
        <?php endif; ?>
        
      </div>
    </div>
  </section>
  
  <!-- FAQ Section -->
  <?php get_template_part('template-parts/faq-section'); ?>
  
  <!-- Contact Section -->
  <?php get_template_part('template-parts/contact-section'); ?>
</main>

<?php get_footer(); ?>