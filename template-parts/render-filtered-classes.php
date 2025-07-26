<?php
/**
 * Template part for rendering filtered class products
 *
 * @package Security_Training_Classes
 */

// Get the filter term from the args or set a default
$filter_term = isset($args['filter_term']) ? $args['filter_term'] : '';

// Define the section ID based on the filter term
$section_id = !empty($filter_term) ? 'filtered-classes-' . sanitize_title($filter_term) : 'filtered-classes';

// Define the section title based on the filter term
$section_title = !empty($filter_term) ? esc_html($filter_term) . ' Classes' : 'Featured Classes';

// Define the section description based on the filter term
$section_description = !empty($filter_term) ? 'Browse our ' . esc_html(strtolower($filter_term)) . ' training courses' : 'Browse our featured security training courses';
?>

<!-- Filtered Classes Section -->
<section id="<?php echo $section_id; ?>" class="py-20 bg-white">
  <div class="container mx-auto px-4">
    <h2 class="text-4xl font-bold text-navy mb-6 text-center"><?php echo $section_title; ?></h2>
    <p class="text-center text-xl text-steel-gray mb-12"><?php echo $section_description; ?></p>
    
    <?php
    $apiKey = get_option('bookeo_api_key');
    $secretKey = get_option('bookeo_secret_key');

    if (empty($apiKey) || empty($secretKey)) {
      echo '<p class="text-center text-red-500">API keys are not configured. Please set them in Settings -> Bookeo API.</p>';
    } else {
      // Fetch all products
      $products_url = "https://api.bookeo.com/v2/settings/products?apiKey={$apiKey}&secretKey={$secretKey}";
      $products_response = wp_remote_get($products_url);

      if (is_wp_error($products_response)) {
        echo '<p class="text-center text-red-500">Failed to load class data. Please try again later.</p>';
      } else {
        $products_data = json_decode(wp_remote_retrieve_body($products_response), true);

        if (!empty($products_data['data'])) {
          // Filter products based on the filter term
          $filtered_products = array();
          
          foreach ($products_data['data'] as $product) {
            // Skip products that are not active
            if (isset($product['active']) && $product['active'] === false) {
              continue;
            }
            
            // If filter term is provided, check if product name or description contains the term
            if (!empty($filter_term)) {
              $name_match = stripos($product['name'], $filter_term) !== false;
              $desc_match = stripos($product['description'], $filter_term) !== false;
              
              // Only include products that match the filter term
              if (!$name_match && !$desc_match) {
                continue;
              }
            }
            
            // Add matching product to filtered list
            $filtered_products[] = $product;
          }
          
          if (!empty($filtered_products)) {
            echo '<div id="filtered-products-grid" class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">';
            
            foreach ($filtered_products as $product) {
              $price = '';
              if (!empty($product['defaultRates']) && !empty($product['defaultRates'][0]['price']['amount'])) {
                $price = '$' . number_format($product['defaultRates'][0]['price']['amount'], 2);
              }

              $product_data = [
                'productId' => $product['productId'],
                'name' => $product['name'],
                'description' => $product['description'],
                'thumbnail' => !empty($product['images'][0]['url']) ? $product['images'][0]['url'] : '',
                'price' => $price
              ];

              get_template_part('template-parts/class-all-products-card', null, ['product_data' => $product_data]);
            }
            
            echo '</div>';

            // Pagination container if needed for larger filtered lists
            if (count($filtered_products) > 6) {
              echo '<div id="filtered-products-pagination" class="flex justify-center items-center space-x-4 mt-12"></div>';
            }
            
            // Make sure the modals are properly initialized
            echo '<script>
              document.addEventListener("DOMContentLoaded", function() {
                // Initialize modal open functionality
                document.querySelectorAll("[data-modal-target]").forEach(function(button) {
                  button.addEventListener("click", function() {
                    const modalId = this.getAttribute("data-modal-target");
                    const modal = document.querySelector(modalId);
                    if (modal) {
                      modal.classList.replace("hidden", "flex");
                      document.body.classList.add("overflow-hidden");
                    }
                  });
                });
                
                // Initialize modal close functionality
                document.querySelectorAll("[data-modal-close]").forEach(function(button) {
                  button.addEventListener("click", function() {
                    const modalId = this.getAttribute("data-modal-close");
                    const modal = document.querySelector(modalId);
                    if (modal) {
                      modal.classList.replace("flex", "hidden");
                      document.body.classList.remove("overflow-hidden");
                    }
                  });
                });
                
                // Close modal when clicking on overlay
                document.querySelectorAll(".class-modal").forEach(function(modal) {
                  modal.addEventListener("click", function(e) {
                    if (e.target === this) {
                      this.classList.replace("flex", "hidden");
                      document.body.classList.remove("overflow-hidden");
                    }
                  });
                });
              });
            </script>';
          } else {
            echo '<p class="text-center">No ' . esc_html(strtolower($filter_term)) . ' classes available at this time.</p>';
          }
        } else {
          echo '<p class="text-center">No classes available at this time.</p>';
        }
      }
    }
    ?>
  </div>
</section>
