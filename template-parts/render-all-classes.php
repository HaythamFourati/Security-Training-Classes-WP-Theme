<?php
/**
 * Template part for rendering all available class products
 *
 * @package Security_Training_Classes
 */
?>

<!-- All Classes Section -->
<section id="all-classes" class="py-20 bg-white">
  <div class="container mx-auto px-4">
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
          echo '<div id="products-grid" class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">';

          foreach ($products_data['data'] as $product) {
            // Skip products that are not active or not publicly bookable
            if (isset($product['active']) && $product['active'] === false) {
              continue;
            }

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

          // Pagination container if needed
          echo '<div id="products-pagination" class="flex justify-center items-center space-x-4 mt-12"></div>';
          
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
          echo '<p class="text-center">No classes available at this time.</p>';
        }
      }
    }
    ?>
  </div>
</section>
