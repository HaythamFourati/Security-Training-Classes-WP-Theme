<?php
/**
 * Template part for displaying a single class modal.
 *
 * @package Security_Training_Classes
 */

$class_data = $args['class_data'];

// Extract and sanitize data for the modal
$eventId = esc_attr($class_data['eventId']);
$title = esc_html($class_data['title']);
$full_description = wp_kses_post($class_data['description']);
$booking_url = esc_url($class_data['booking_url']);
$modal_id = 'class-modal-' . $eventId;
?>

<div id="<?php echo $modal_id; ?>" class="fixed inset-0 z-50 hidden items-center justify-center p-4 class-modal modal-overlay-bg">
    <div class="bg-white rounded-lg shadow-2xl max-w-2xl w-full max-h-[90vh] flex flex-col overflow-hidden">
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-4 bg-navy text-white border-b border-gray-300">
            <h2 class="text-xl font-bold"><?php echo $title; ?></h2>
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
