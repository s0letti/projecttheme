<?php
$headline = get_sub_field('headline');
$text     = get_sub_field('text');
$image_id = get_sub_field('image');
?>
<div class="text-left-image-right row align-items-center g-5">
  <div class="text-left-image-right__copy col-md-6">
    <?php if ($headline): ?><h2 class="text-left-image-right__title"><?php echo esc_html($headline); ?></h2><?php endif; ?>
    <?php if ($text): ?><div class="rte"><?php echo wp_kses_post($text); ?></div><?php endif; ?>
  </div>
  <div class="text-left-image-right__media col-md-6">
    <?php echo wp_get_attachment_image($image_id, 'large', false, ['class' => 'text-left-image-right__image img-fluid rounded']); ?>
  </div>
</div>