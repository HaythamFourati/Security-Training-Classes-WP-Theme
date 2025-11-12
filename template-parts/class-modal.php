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
$upcoming_dates = isset($class_data['upcoming_dates']) ? $class_data['upcoming_dates'] : array();
$meeting_location = isset($class_data['meeting_location']) ? esc_html($class_data['meeting_location']) : '';
$seats = isset($class_data['seats']) ? esc_html($class_data['seats']) : '';
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
            <!-- Description -->
            <div class="prose prose-slate max-w-none mb-6 text-gray-800">
                <?php echo $full_description; ?>
            </div>
            
            <!-- Class Information Section -->
            <div class="border-t border-gray-200 pt-6 mt-6">
                <h3 class="text-lg font-bold text-navy mb-4">Class Information</h3>
                
                <!-- Upcoming Dates -->
                <?php if (!empty($upcoming_dates)) : ?>
                <div class="mb-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 mr-3 mt-0.5 text-navy flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <div class="flex-1">
                            <h4 class="font-semibold text-navy mb-2">Upcoming Dates:</h4>
                            <ul class="space-y-2">
                                <?php foreach ($upcoming_dates as $date_info) : ?>
                                <li class="text-sm text-gray-700">
                                    <span class="font-medium text-navy"><?php echo esc_html($date_info['date']); ?></span>
                                    <?php if (!empty($date_info['time_slots'])) : ?>
                                        <span class="text-gray-700"> – <?php echo esc_html(implode(', ', $date_info['time_slots'])); ?></span>
                                    <?php endif; ?>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Meeting Location -->
                <?php if (!empty($meeting_location)) : ?>
                <div class="mb-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 mr-3 mt-0.5 text-navy flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <div class="flex-1">
                            <h4 class="font-semibold text-navy mb-1">Location:</h4>
                            <p class="text-sm text-gray-700"><?php echo $meeting_location; ?></p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Seats Available -->
                <?php if (!empty($seats)) : ?>
                <div class="mb-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 mr-3 mt-0.5 text-navy flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <div class="flex-1">
                            <h4 class="font-semibold text-navy mb-1">Availability:</h4>
                            <p class="text-sm text-gray-700"><?php echo $seats; ?> Seats Available</p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="flex justify-end items-center p-4 bg-gray-50 border-t border-gray-200 mt-auto">
            <button data-modal-close="#<?php echo $modal_id; ?>" class="text-navy font-semibold px-6 py-2 mr-4 hover:underline cursor-pointer">Close</button>
            <a href="<?php echo $booking_url; ?>" target="_blank" class="bg-safety-orange text-white font-bold py-2 px-6 rounded hover:bg-opacity-90 transition-colors">Book Now</a>
        </div>
    </div>
</div>
