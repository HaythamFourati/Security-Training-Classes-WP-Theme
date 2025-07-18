<?php
/**
 * Template part for displaying a single class card.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Security_Training_Classes
 */

$class_data = $args['class_data'];

// Extract and sanitize data
$eventId = esc_attr($class_data['eventId']);
$title = esc_html($class_data['title']);
$short_description = wp_trim_words(wp_strip_all_tags($class_data['description']), 20, '...');
$full_description = wp_kses_post($class_data['description']); // Keep basic HTML for the modal
$thumbnail_url = esc_url($class_data['thumbnail']);
$date = esc_html($class_data['date']);
$start_time = esc_html($class_data['start_time']);
$seats = esc_html($class_data['seats']);
$booking_url = esc_url($class_data['booking_url']);
$category = esc_attr($class_data['category']);
$modal_id = 'class-modal-' . $eventId;

// Default thumbnail if none is provided
if (empty($thumbnail_url)) {
    $thumbnail_url = get_theme_file_uri('/images/default-class-image.jpg');
}

// Capture modal HTML into a global variable to be printed later
ob_start();
?>
<div id="<?php echo $modal_id; ?>" class="fixed inset-0 bg-black bg-opacity-60 z-50 hidden items-center justify-center p-4 class-modal">
    <div class="bg-white rounded-lg shadow-2xl max-w-2xl w-full max-h-[90vh] flex flex-col overflow-hidden">
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-4 bg-navy text-white border-b border-gray-300">
            <h2 class="text-xl font-bold"><?php echo $title; ?></h2>
            <button data-modal-close="#<?php echo $modal_id; ?>" class="text-2xl font-bold leading-none hover:opacity-75">&times;</button>
        </div>
        
        <!-- Modal Body -->
        <div class="p-6 overflow-y-auto">
            <div class="prose max-w-none">
                <?php echo $full_description; ?>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="flex justify-end items-center p-4 bg-gray-50 border-t border-gray-200 mt-auto">
            <button data-modal-close="#<?php echo $modal_id; ?>" class="text-navy font-semibold px-6 py-2 mr-4 hover:underline">Close</button>
            <a href="<?php echo $booking_url; ?>" target="_blank" class="bg-safety-orange text-white font-bold py-2 px-6 rounded hover:bg-opacity-90 transition-colors">Book Now</a>
        </div>
    </div>
</div>
<?php
global $class_modals_html;
$class_modals_html .= ob_get_clean();

// Now, output the card itself
?>
<div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col class-item" data-category="<?php echo $category; ?>">
    <a href="<?php echo $booking_url; ?>" target="_blank">
        <img class="w-full h-48 object-cover" src="<?php echo $thumbnail_url; ?>" alt="<?php echo $title; ?>">
    </a>
    <div class="p-6 flex-grow flex flex-col">
        <h3 class="text-xl font-bold text-navy mb-3 flex-grow"><?php echo $title; ?></h3>
        <p class="text-steel-gray mb-4 text-sm">
            <?php echo $short_description; ?>
            <?php if (strlen(wp_strip_all_tags($class_data['description'])) > strlen($short_description)) : ?>
                <button data-modal-target="#<?php echo $modal_id; ?>" class="text-safety-orange font-semibold hover:underline text-sm cursor-pointer">Read More</button>
            <?php endif; ?>
        </p>
        
        <div class="space-y-3 text-sm text-steel-gray border-t border-gray-200 pt-4 mt-auto">
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-2 text-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span><?php echo $date; ?></span>
            </div>
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-2 text-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span><?php echo $start_time; ?></span>
            </div>
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-2 text-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                <span><?php echo $seats; ?> Seats Available</span>
            </div>
        </div>

        <a href="<?php echo $booking_url; ?>" target="_blank" class="mt-6 bg-safety-orange text-white font-bold py-3 px-6 rounded w-full text-center block hover:bg-opacity-90 transition-colors">Book Now</a>
    </div>
</div>

