<?php
$title = get_sub_field('carousel_w_intro_title');
$paragraph_one = get_sub_field('carousel_w_intro_paragraph_one');
$paragraph_two = get_sub_field('carousel_w_intro_paragraph_two');
?>
<div class="text-block__content">
  <?php if ($title) : ?>
    <h2 class="text-block__title"><?php echo esc_html($title); ?></h2>
  <?php endif; ?>

  <?php if ($paragraph_one) : ?>
    <p class="text-block__paragraph"><?php echo nl2br(esc_html($paragraph_one)); ?></p>
  <?php endif; ?>

  <?php if ($paragraph_two) : ?>
    <p class="text-block__paragraph"><?php echo nl2br(esc_html($paragraph_two)); ?></p>
  <?php endif; ?>
</div>
