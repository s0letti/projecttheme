<?php
$carousel_key = get_sub_field('carousel_key');
?>
<div
  class="carousel-nav"
  data-carousel-nav
  data-carousel-key="<?php echo esc_attr($carousel_key); ?>"
  data-slide-label="<?php echo esc_attr__('Go to slide %d', 'projecttheme'); ?>"
  role="group"
  aria-label="<?php esc_attr_e('Choose a slide', 'projecttheme'); ?>"
  hidden
></div>
