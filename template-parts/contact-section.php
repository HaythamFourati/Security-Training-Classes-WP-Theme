<?php
/**
 * Template part for displaying the contact section
 */
?>

<!-- Contact Section -->
<section id="contact" class="py-20 bg-gray-50 text-navy">
    <div class="container mx-auto text-center px-4">
        <h2 class="text-4xl font-bold mb-4">Still have questions?</h2>
        <p class="text-xl mb-4">Speak with an instructor today!</p>
        <p class="text-sm mb-8">8567 Fort Smallwood Rd unit C,
       <br/> Pasadena, MD 21122, United States</p>
        <div class="max-w-xl mx-auto">
            <?php 
            // Contact Form 7 Shortcode
            // To set up: 
            // 1. Install Contact Form 7 plugin
            // 2. Create a form using the code in contact-form-7-config.txt
            // 3. Replace 'YOUR_FORM_ID' below with your actual form ID
            // 4. Add the CSS from the config file to your stylesheet
            
            if (function_exists('wpcf7_contact_form')) {
                // Replace '1' with your actual Contact Form 7 ID
                echo do_shortcode('[contact-form-7 id="edeaf24" title="STA Contact"]');
            } else {
                // Fallback form if Contact Form 7 is not installed
                ?>
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-6">
                    <p class="font-semibold">Contact Form 7 Setup Required</p>
                    <p class="text-sm">Please install Contact Form 7 plugin and configure the form using the instructions in contact-form-7-config.txt</p>
                </div>
                <form class="grid grid-cols-1 md:grid-cols-2 gap-4" action="#" method="post">
                    <input type="text" name="name" placeholder="Name" class="p-3 rounded bg-gray-200 text-navy placeholder-navy" required>
                    <input type="email" name="email" placeholder="Email" class="p-3 rounded bg-gray-200 text-navy placeholder-navy" required>
                    <input type="tel" name="phone" placeholder="Phone" class="p-3 rounded bg-gray-200 text-navy placeholder-navy">
                    <textarea name="message" placeholder="Message" class="p-3 rounded bg-gray-200 text-navy placeholder-navy md:col-span-2 min-h-[100px]" required></textarea>
                    <button type="submit" class="bg-safety-orange text-white font-bold py-3 px-6 rounded hover:bg-opacity-90 md:col-span-2 transition-colors">Send Message</button>
                </form>
                <?php
            }
            ?>
        </div>
    </div>
</section>
