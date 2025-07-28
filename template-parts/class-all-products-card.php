<?php
/**
 * Template part for displaying a single class product card.
 *
 * @package Security_Training_Classes
 */

$product_data = $args['product_data'];

// Extract and sanitize data
$productId = esc_attr($product_data['productId']);
$name = esc_html($product_data['name']);
$short_description = wp_trim_words(wp_strip_all_tags($product_data['description']), 20, '...');
$full_description = wp_kses_post($product_data['description']); // Keep basic HTML for the modal
$thumbnail_url = !empty($product_data['thumbnail']) ? esc_url($product_data['thumbnail']) : '';
$price = !empty($product_data['price']) ? esc_html($product_data['price']) : 'Contact for pricing';
$booking_url = esc_url("https://bookeo.com/securitytrainingacademy?type={$productId}");
$modal_id = 'product-modal-' . $productId;

// Default thumbnail if none is provided
if (empty($thumbnail_url)) {
    $thumbnail_url = 'https://www-151g.bookeo.com/bookeo/cfile/42557E9JMC918221126FA4/1749122294599_EA4WCJPPWRLX6WMK97XLA3LXAP3C4HYA_STARTYOUTUBE_JvMJrKA9mrs_ENDYOUTUBE__480_360.jpg';
}
?>
<div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col class-item">
    <a href="<?php echo $booking_url; ?>" target="_blank">
        <img class="w-full h-48 object-cover" src="<?php echo $thumbnail_url; ?>" alt="<?php echo $name; ?>">
    </a>
    <div class="p-6 flex-grow flex flex-col">
        <h3 class="text-xl font-bold text-navy mb-3 flex-grow"><?php echo $name; ?></h3>
        <p class="text-steel-gray mb-4 text-sm">
            <?php echo $short_description; ?>
            <?php if (strlen(wp_strip_all_tags($product_data['description'])) > strlen($short_description)) : ?>
                <button data-modal-target="#<?php echo $modal_id; ?>" class="text-safety-orange font-semibold hover:underline text-sm cursor-pointer">Read More</button>
            <?php endif; ?>
        </p>
        
        <div class="space-y-3 border-t border-gray-200 pt-4 mt-auto">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2 text-safety-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="text-lg font-bold text-navy"><?php echo $price; ?></span>
            </div>
        </div>

        <a href="<?php echo $booking_url; ?>" target="_blank" class="mt-6 bg-safety-orange text-white font-bold py-3 px-6 rounded w-full text-center block hover:bg-opacity-90 transition-colors">Book Now</a>
    </div>
</div>

<!-- Modal for this product -->
<div id="<?php echo $modal_id; ?>" class="fixed inset-0 z-50 hidden items-center justify-center p-4 class-modal modal-overlay-bg">
    <div class="bg-white rounded-lg shadow-2xl max-w-2xl w-full max-h-[90vh] flex flex-col overflow-hidden">
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-4 bg-navy text-white border-b border-gray-300">
            <h2 class="text-xl font-bold"><?php echo $name; ?></h2>
            <button data-modal-close="#<?php echo $modal_id; ?>" class="text-2xl font-bold leading-none hover:opacity-75 cursor-pointer">&times;</button>
        </div>
        
        <!-- Modal Body -->
        <div class="p-6 overflow-y-auto">
            <div class="prose max-w-none">
                <?php echo $full_description; ?>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="flex justify-end items-center p-4 bg-gray-50 border-t border-gray-200 mt-auto">
            <button data-modal-close="#<?php echo $modal_id; ?>" class="text-navy font-semibold px-6 py-2 mr-4 hover:underline cursor-pointer">Close</button>
            <a href="<?php echo $booking_url; ?>" target="_blank" class="bg-safety-orange text-white font-bold py-2 px-6 rounded hover:bg-opacity-90 transition-colors">Book Now</a>
        </div>
    </div>
</div>
