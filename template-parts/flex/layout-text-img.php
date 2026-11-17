<?php
$headline = get_sub_field('headline');
$text = get_sub_field('text');
$image_id = get_sub_field('image');
?>
<div class="text-img row align-items-center g-5">
  <div class="text-img__copy col-12 col-lg-8">
    <?php if ($headline) : ?>
      <h2 class="text-img__title"><?php echo esc_html($headline); ?></h2>
    <?php endif; ?>

    <?php if ($text) : ?>
      <div class="text-img__text rte"><?php echo wp_kses_post($text); ?></div>
    <?php endif; ?>
  </div>

  <?php if ($image_id) : ?>
    <div class="text-img__media col-12 col-lg-4">
      <?php
      echo wp_get_attachment_image(
        $image_id,
        'large',
        false,
        [
          'class' => 'text-img__image img-fluid',
          'loading' => 'lazy',
          'decoding' => 'async',
        ]
      );
      ?>
    </div>
  <?php endif; ?>
</div>
