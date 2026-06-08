<?php
/**
 * Template Name: Booking Confirmed
 *
 * Thank you page displayed after successful class booking.
 *
 * @package Security_Training_Classes
 */

get_header();
?>

<main class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
  <section class="relative overflow-hidden -mt-32 pt-56 pb-20">
    <div class="absolute inset-0 bg-gradient-to-l from-[var(--color-navy)] to-blue-800 opacity-95"></div>
    
    <div class="absolute inset-0 overflow-hidden">
      <div class="absolute -top-1/2 -right-1/4 w-96 h-96 bg-[var(--color-safety-orange)] rounded-full opacity-10 blur-3xl"></div>
      <div class="absolute -bottom-1/2 -left-1/4 w-96 h-96 bg-blue-400 rounded-full opacity-10 blur-3xl"></div>
    </div>
    
    <div id="confetti-container" class="confetti-container"></div>
    
    <div class="container mx-auto px-4 text-center relative z-10">
      <div id="success-icon" class="inline-flex items-center justify-center w-24 h-24 mb-8 bg-white rounded-full shadow-2xl">
        <svg class="w-12 h-12 text-[var(--color-safety-orange)]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
        </svg>
      </div>
      
      <h1 id="main-heading" class="text-5xl md:text-7xl font-extrabold leading-tight mb-6 text-white">
        You're All Set!
      </h1>
      
      <p id="sub-heading" class="text-xl md:text-2xl text-gray-200 mb-4 max-w-2xl mx-auto">
        Your class booking has been confirmed
      </p>
      
      <p class="text-lg text-gray-300 max-w-xl mx-auto">
        We've sent a confirmation email with all the details you need for your upcoming training session.
      </p>
    </div>
  </section>

  <section class="py-16 md:py-24">
    <div class="container mx-auto px-4 max-w-5xl">
      <div class="grid md:grid-cols-3 gap-8 mb-16">
        <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300 border-t-4 border-[var(--color-safety-orange)]">
          <div class="flex items-center justify-center w-16 h-16 mb-6 bg-gradient-to-br from-[var(--color-safety-orange)] to-orange-600 rounded-xl">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
          </div>
          <h3 class="text-2xl font-bold text-[var(--color-navy)] mb-3">Check Your Email</h3>
          <p class="text-gray-600 leading-relaxed">
            A confirmation email with your class details, location, and what to bring has been sent to your inbox.
          </p>
        </div>

        <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300 border-t-4 border-blue-600">
          <div class="flex items-center justify-center w-16 h-16 mb-6 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
          </div>
          <h3 class="text-2xl font-bold text-[var(--color-navy)] mb-3">Mark Your Calendar</h3>
          <p class="text-gray-600 leading-relaxed">
            Add the training date to your calendar so you don't miss this important session.
          </p>
        </div>

        <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300 border-t-4 border-green-600">
          <div class="flex items-center justify-center w-16 h-16 mb-6 bg-gradient-to-br from-green-600 to-green-700 rounded-xl">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <h3 class="text-2xl font-bold text-[var(--color-navy)] mb-3">Prepare for Class</h3>
          <p class="text-gray-600 leading-relaxed">
            Review the pre-class materials and requirements sent in your confirmation email.
          </p>
        </div>
      </div>

      <div class="bg-gradient-to-r from-[var(--color-navy)] to-blue-800 rounded-3xl p-10 md:p-12 shadow-2xl text-white mb-16">
        <div class="max-w-3xl mx-auto text-center">
          <h2 class="text-3xl md:text-4xl font-bold mb-6">What Happens Next?</h2>
          
          <div class="space-y-6 text-left">
            <div class="flex items-start gap-4">
              <div class="flex-shrink-0 w-8 h-8 bg-[var(--color-safety-orange)] rounded-full flex items-center justify-center font-bold text-sm">
                1
              </div>
              <div>
                <h4 class="font-bold text-lg mb-1">Confirmation Email</h4>
                <p class="text-gray-200">You'll receive an email within the next few minutes with all your booking details.</p>
              </div>
            </div>
            
            <div class="flex items-start gap-4">
              <div class="flex-shrink-0 w-8 h-8 bg-[var(--color-safety-orange)] rounded-full flex items-center justify-center font-bold text-sm">
                2
              </div>
              <div>
                <h4 class="font-bold text-lg mb-1">Reminder Notifications</h4>
                <p class="text-gray-200">We'll send you reminders 48 hours and 24 hours before your class begins.</p>
              </div>
            </div>
            
            <div class="flex items-start gap-4">
              <div class="flex-shrink-0 w-8 h-8 bg-[var(--color-safety-orange)] rounded-full flex items-center justify-center font-bold text-sm">
                3
              </div>
              <div>
                <h4 class="font-bold text-lg mb-1">Attend Your Class</h4>
                <p class="text-gray-200">Show up on time with the required materials and get ready for an excellent training experience.</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-3xl p-10 md:p-12 shadow-xl border border-gray-200">
        <div class="max-w-2xl mx-auto text-center">
          <div class="inline-flex items-center justify-center w-16 h-16 mb-6 bg-blue-100 rounded-full">
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          
          <h2 class="text-3xl md:text-4xl font-bold text-[var(--color-navy)] mb-4">Need Help?</h2>
          <p class="text-lg text-gray-600 mb-8">
            Our team is here to answer any questions you may have about your upcoming class.
          </p>
          
          <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="tel:<?php echo esc_attr($GLOBALS['phone_number']); ?>" class="inline-flex items-center gap-3 bg-[var(--color-safety-orange)] text-white font-bold py-4 px-8 rounded-xl hover:bg-opacity-90 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
              </svg>
              <span><?php echo esc_html($GLOBALS['phone_number']); ?></span>
            </a>
            
            <a href="mailto:<?php echo esc_attr($GLOBALS['email']); ?>" class="inline-flex items-center gap-3 bg-[var(--color-navy)] text-white font-bold py-4 px-8 rounded-xl hover:bg-opacity-90 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
              </svg>
              <span>Email Us</span>
            </a>
          </div>
        </div>
      </div>

      <div class="mt-12 text-center">
        <a href="<?php echo esc_url(home_url('/all-classes')); ?>" class="inline-flex items-center gap-2 text-[var(--color-navy)] font-semibold hover:text-[var(--color-safety-orange)] transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
          </svg>
          <span>Browse More Classes</span>
        </a>
        <span class="mx-4 text-gray-400">|</span>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-flex items-center gap-2 text-[var(--color-navy)] font-semibold hover:text-[var(--color-safety-orange)] transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
          </svg>
          <span>Return to Homepage</span>
        </a>
      </div>
    </div>
  </section>
</main>

<?php get_footer(); ?>
