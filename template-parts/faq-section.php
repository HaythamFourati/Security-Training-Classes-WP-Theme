<?php
/**
 * Template part for displaying the FAQ accordion section
 */
?>

<!-- FAQ Accordion Section -->
<section class="py-20 bg-gray-100">
  <div class="container mx-auto px-4 max-w-4xl">
    <h2 class="text-4xl font-bold text-navy text-center mb-12">Frequently Asked Questions</h2>
    <div class="space-y-4" id="faq-accordion">
      <!-- FAQ Item 1 -->
      <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <button class="w-full flex justify-between items-center text-left p-6 font-bold text-navy text-xl focus:outline-none">
          <span>Do I need any prior experience to take a firearms training course?</span>
          <svg class="w-6 h-6 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </button>
        <div class="p-6 pt-0 text-steel-gray hidden">
          No prior experience is necessary! We offer beginner, intermediate, and advanced courses tailored to your current skill level.
        </div>
      </div>
      <!-- FAQ Item 2 -->
      <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <button class="w-full flex justify-between items-center text-left p-6 font-bold text-navy text-xl focus:outline-none">
          <span>What should I bring to a firearms training class?</span>
          <svg class="w-6 h-6 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </button>
        <div class="p-6 pt-0 text-steel-gray hidden">
          For most classes, you'll need a valid government-issued ID, appropriate clothing (closed-toe shoes, hat, safety glasses, and hearing protection), and your firearm and ammunition (if applicable). Some courses provide firearms if needed.
        </div>
      </div>
      <!-- FAQ Item 3 -->
      <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <button class="w-full flex justify-between items-center text-left p-6 font-bold text-navy text-xl focus:outline-none">
          <span>Do I need any experience to enroll in your security guard training program?</span>
          <svg class="w-6 h-6 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </button>
        <div class="p-6 pt-0 text-steel-gray hidden">
          No prior experience is required. Our courses are designed for beginners as well as those looking to upgrade or renew their certifications.
        </div>
      </div>
      <!-- FAQ Item 4 -->
      <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <button class="w-full flex justify-between items-center text-left p-6 font-bold text-navy text-xl focus:outline-none">
          <span>What is a Special Police Officer (SPO)?</span>
          <svg class="w-6 h-6 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </button>
        <div class="p-6 pt-0 text-steel-gray hidden">
          A Special Police Officer is a licensed individual who has limited law enforcement authority, typically on private property, such as at government buildings, hospitals, universities, or private companies. They are authorized to carry a firearm and make arrests within their jurisdiction.
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Initialize FAQ accordion functionality
    const faqButtons = document.querySelectorAll('#faq-accordion button');
    
    faqButtons.forEach(button => {
      button.addEventListener('click', function() {
        const content = this.nextElementSibling;
        const icon = this.querySelector('svg');
        
        // Toggle content
        if (content.classList.contains('hidden')) {
          content.classList.remove('hidden');
          icon.classList.add('rotate-180');
        } else {
          content.classList.add('hidden');
          icon.classList.remove('rotate-180');
        }
      });
    });
  });
</script>
