<?php
/**
 * The template for displaying single blog posts
 *
 * @package Security_Training_Classes
 */

get_header();
?>

<main>
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    
    <!-- Post Header -->
    <article class="bg-gradient-to-l from-[var(--color-navy)] to-blue-800 text-white py-20 -mt-32 pt-56">
      <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
          
          <!-- Breadcrumb -->
          <nav class="text-sm mb-6">
            <ol class="flex items-center space-x-2 text-gray-300">
              <li><a href="<?php echo home_url(); ?>" class="hover:text-white transition-colors">Home</a></li>
              <li>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
              </li>
              <li><a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="hover:text-white transition-colors">Blog</a></li>
            </ol>
          </nav>
          
          <!-- Post Meta -->
          <div class="flex flex-wrap items-center text-sm text-gray-300 mb-6">
            <div class="flex items-center mr-6 mb-2">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
              </svg>
              <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date('F j, Y'); ?></time>
            </div>
            <div class="flex items-center mr-6 mb-2">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
              </svg>
              <span>By <?php echo get_the_author(); ?></span>
            </div>
            <div class="flex items-center mb-2">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
              <span><?php echo reading_time(); ?> min read</span>
            </div>
          </div>
          
          <!-- Post Title -->
          <h1 class="text-4xl md:text-5xl font-instrument-serif leading-tight mb-6"><?php the_title(); ?></h1>
          
          <!-- Categories -->
          <?php $categories = get_the_category(); ?>
          <?php if (!empty($categories)) : ?>
            <div class="flex flex-wrap gap-2">
              <?php foreach ($categories as $category) : ?>
                <span class="inline-block bg-white bg-opacity-20 text-navy text-sm px-3 py-1 rounded-full">
                  <?php echo esc_html($category->name); ?>
                </span>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
          
        </div>
      </div>
    </article>
    
    <!-- Featured Image -->
    <?php if (has_post_thumbnail()) : ?>
      <section class="-mt-16 ">
        <div class="container mx-auto px-4">
          <div class="max-w-4xl mx-auto">
            <div class="rounded-lg overflow-hidden shadow-2xl">
              <?php the_post_thumbnail('full', array('class' => 'w-full h-auto')); ?>
            </div>
          </div>
        </div>
      </section>
    <?php endif; ?>
    
    <!-- Post Content -->
    <section class="py-12 bg-white">
      <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
          
          <!-- Post Content -->
          <div class="prose prose-lg max-w-none">
            <?php the_content(); ?>
          </div>
          
          <!-- Tags -->
          <?php $tags = get_the_tags(); ?>
          <?php if ($tags) : ?>
            <div class="mt-12 pt-8 border-t border-gray-200">
              <h3 class="text-lg font-bold text-navy mb-4">Tags</h3>
              <div class="flex flex-wrap gap-2">
                <?php foreach ($tags as $tag) : ?>
                  <a href="<?php echo get_tag_link($tag->term_id); ?>" class="inline-block bg-gray-100 hover:bg-safety-orange hover:text-white text-navy text-sm px-3 py-1 rounded-full transition-colors">
                    #<?php echo esc_html($tag->name); ?>
                  </a>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endif; ?>
          
          <!-- Author Bio -->
          <?php $author_bio = get_the_author_meta('description'); ?>
          <?php if ($author_bio) : ?>
            <div class="mt-12 p-6 bg-gray-50 rounded-lg">
              <div class="flex items-start">
                <div class="flex-shrink-0 mr-4">
                  <?php echo get_avatar(get_the_author_meta('ID'), 80, '', '', array('class' => 'rounded-full')); ?>
                </div>
                <div>
                  <h3 class="text-xl font-bold text-navy mb-2">About <?php echo get_the_author(); ?></h3>
                  <p class="text-steel-gray"><?php echo esc_html($author_bio); ?></p>
                </div>
              </div>
            </div>
          <?php endif; ?>


          <!-- CTA Banner -->
  <section class="pt-6">
    <div class="container mx-auto px-4">
      <div class="max-w-4xl mx-auto text-center">
        <a href="tel:4437027891" target="_blank" class="block hover:opacity-90 transition-opacity">
          <img src="https://www.securitytrainingclasses.com/wp-content/uploads/2023/03/STA-CTA-1024x289.png" 
               alt="Security Training Academy - Book Your Training Today" 
               class="w-full h-auto rounded-lg">
        </a>
      </div>
    </div>
  </section>
          
          <!-- Post Navigation -->
          <div class="mt-12 pt-8 border-t border-gray-200">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
              
              <!-- Previous Post -->
              <?php $prev_post = get_previous_post(); ?>
              <?php if ($prev_post) : ?>
                <div class="flex-1 md:mr-8">
                  <p class="text-sm text-steel-gray mb-2">Previous Post</p>
                  <a href="<?php echo get_permalink($prev_post); ?>" class="text-navy hover:text-safety-orange font-semibold transition-colors">
                    <div class="flex items-center">
                      <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                      </svg>
                      <?php echo get_the_title($prev_post); ?>
                    </div>
                  </a>
                </div>
              <?php endif; ?>
              
              <!-- Next Post -->
              <?php $next_post = get_next_post(); ?>
              <?php if ($next_post) : ?>
                <div class="flex-1 text-right">
                  <p class="text-sm text-steel-gray mb-2">Next Post</p>
                  <a href="<?php echo get_permalink($next_post); ?>" class="text-navy hover:text-safety-orange font-semibold transition-colors">
                    <div class="flex items-center justify-end">
                      <?php echo get_the_title($next_post); ?>
                      <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                      </svg>
                    </div>
                  </a>
                </div>
              <?php endif; ?>
              
            </div>
          </div>
          
          <!-- Back to Blog -->
          <div class="mt-8 text-center">
            <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="inline-flex items-center bg-safety-orange text-white font-bold py-3 px-6 rounded hover:bg-opacity-90 transition-colors">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
              </svg>
              Back to Blog
            </a>
          </div>
          
        </div>
      </div>
    </section>
    
  <?php endwhile; endif; ?>
  
  
  
  <!-- Related Posts -->
  <section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
      <div class="max-w-6xl mx-auto">
        <h2 class="text-3xl font-instrument-serif text-navy text-center mb-12">Related Articles</h2>
        
        <?php
        $related_posts = get_posts(array(
          'category__in' => wp_get_post_categories(get_the_ID()),
          'numberposts' => 3,
          'post__not_in' => array(get_the_ID())
        ));
        ?>
        
        <?php if ($related_posts) : ?>
          <div class="grid md:grid-cols-3 gap-8">
            <?php foreach ($related_posts as $post) : setup_postdata($post); ?>
              <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <?php if (has_post_thumbnail()) : ?>
                  <div class="aspect-w-16 aspect-h-9 overflow-hidden">
                    <a href="<?php the_permalink(); ?>">
                      <?php the_post_thumbnail('medium', array('class' => 'w-full h-48 object-cover hover:scale-105 transition-transform duration-300')); ?>
                    </a>
                  </div>
                <?php else : ?>
                  <div class="w-full h-48 bg-gradient-to-br from-navy to-blue-800 flex items-center justify-center">
                    <svg class="w-12 h-12 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                  </div>
                <?php endif; ?>
                
                <div class="p-6">
                  <div class="text-sm text-steel-gray mb-2"><?php echo get_the_date('F j, Y'); ?></div>
                  <h3 class="text-lg font-bold text-navy mb-3 hover:text-safety-orange transition-colors">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                  </h3>
                  <p class="text-steel-gray mb-4"><?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?></p>
                  <a href="<?php the_permalink(); ?>" class="inline-flex items-center text-safety-orange font-semibold hover:text-navy transition-colors">
                    Read More
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                  </a>
                </div>
              </article>
            <?php endforeach; wp_reset_postdata(); ?>
          </div>
        <?php else : ?>
          <p class="text-center text-steel-gray">No related articles found.</p>
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