<?php
/**
 * Template part for displaying the FAQ accordion section
 */

// FAQ Data Array
$faq_items = [
    [
        'question' => 'Do I need any prior experience to take a firearms training course?',
        'answer' => 'No prior experience is necessary! We offer beginner, intermediate, and advanced courses tailored to your current skill level.'
    ],
    [
        'question' => 'What should I bring to a firearms training class?',
        'answer' => 'For most classes, you\'ll need a valid government-issued ID, appropriate clothing (closed-toe shoes, hat, safety glasses, and hearing protection), and your firearm and ammunition (if applicable). Some courses provide firearms if needed.'
    ],
    [
        'question' => 'Do I need any experience to enroll in your security guard training program?',
        'answer' => 'No prior experience is required. Our courses are designed for beginners as well as those looking to upgrade or renew their certifications.'
    ],
    [
        'question' => 'What is a Special Police Officer (SPO)?',
        'answer' => 'A Special Police Officer is a licensed individual who has limited law enforcement authority, typically on private property, such as at government buildings, hospitals, universities, or private companies. They are authorized to carry a firearm and make arrests within their jurisdiction.'
    ],
    [
        'question' => 'How long are the training courses?',
        'answer' => 'Course duration varies depending on the type of training. Basic security guard courses typically take 8-16 hours, while firearms training can range from 4-8 hours. Advanced courses may span multiple days.'
    ],
    [
        'question' => 'Do you provide job placement assistance?',
        'answer' => 'Yes! We have partnerships with leading security companies in Maryland and provide job placement assistance to our graduates. Many of our students receive job offers shortly after completing their certification.'
    ]
];
?>

<!-- FAQ Accordion Section -->
<section id="faq" class="py-20 bg-gray-100">
  <div class="container mx-auto px-4 max-w-4xl">
    <h2 class="text-4xl font-bold text-navy text-center mb-12">Frequently Asked Questions</h2>
    <div class="space-y-4" id="faq-accordion">
      <?php foreach ($faq_items as $index => $faq) : ?>
        <div class="bg-white rounded-lg shadow-lg overflow-hidden cursor-pointer">
          <button class="w-full flex justify-between items-center text-left p-6 font-bold text-navy text-xl focus:outline-none cursor-pointer hover:bg-gray-50 transition-colors">
            <span><?php echo esc_html($faq['question']); ?></span>
            <svg class="w-6 h-6 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </button>
          <div class="p-6 pt-0 text-steel-gray hidden">
            <?php echo esc_html($faq['answer']); ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
