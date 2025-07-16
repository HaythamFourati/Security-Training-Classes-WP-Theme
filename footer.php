<footer class="bg-navy text-white pt-12">
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-4 gap-8 px-4 text-center md:text-left">
      <!-- About -->
      <div>
        <h4 class="font-bold text-lg mb-4">Security Training Classes</h4>
        <p class="text-steel-gray">Providing top-tier security and law enforcement training in Maryland since 2005.</p>
      </div>
      <!-- Quick Links -->
      <div>
        <h4 class="font-bold text-lg mb-4">Quick Links</h4>
        <ul class="space-y-2">
          <li><a href="#" class="hover:text-safety-orange">Security Guard Training</a></li>
          <li><a href="#" class="hover:text-safety-orange">Firearms Certification</a></li>
          <li><a href="#" class="hover:text-safety-orange">SPO Training</a></li>
                    <li><a href="#" class="hover:text-safety-orange">Contact Us</a></li>
        </ul>
      </div>
      <!-- Contact Info -->
      <div>
        <h4 class="font-bold text-lg mb-4">Contact Us</h4>
        <p class="text-steel-gray">123 Training Rd, Baltimore, MD</p>
        <p class="text-steel-gray">contact@securitytraining.com</p>
                <p><a href="tel:<?php echo esc_attr($GLOBALS['phone_number']); ?>" class="text-steel-gray hover:text-safety-orange transition-colors"><?php echo esc_html($GLOBALS['phone_number']); ?></a></p>
      </div>
      <!-- Social Media -->
      <div>
        <h4 class="font-bold text-lg mb-4">Follow Us</h4>
        <div class="flex justify-center md:justify-start space-x-4">
          <a href="#" class="hover:text-safety-orange">Facebook</a>
          <a href="#" class="hover:text-safety-orange">Instagram</a>
        </div>
      </div>
    </div>
    <div class="border-t border-steel-gray mt-8 py-4">
      <p class="text-center text-steel-gray text-sm">&copy; <?php echo date('Y'); ?> Security Training Classes. All Rights Reserved.</p>
    </div>
</footer>

  <?php wp_footer(); ?>
</body>
</html>
