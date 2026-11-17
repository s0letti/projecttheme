<?php
$title = get_sub_field('hero_title');
$text = get_sub_field('hero_text');
$cta = get_sub_field('hero_cta');

$cta_url = is_array($cta) && !empty($cta['url']) ? $cta['url'] : '';
$cta_title = is_array($cta) && !empty($cta['title']) ? $cta['title'] : '';
$cta_target = is_array($cta) && !empty($cta['target']) ? $cta['target'] : '_self';
$cta_rel = $cta_target === '_blank' ? 'noopener noreferrer' : '';
?>
<div class="hero__content">
  <?php if ($title) : ?>
    <h1 class="hero__title"><?php echo nl2br(esc_html($title)); ?></h1>
  <?php endif; ?>

  <?php if ($text) : ?>
    <p class="hero__text"><?php echo nl2br(esc_html($text)); ?></p>
  <?php endif; ?>

  <?php if ($cta_url) : ?>
    <a class="hero__cta" href="<?php echo esc_url($cta_url); ?>" target="<?php echo esc_attr($cta_target); ?>" rel="<?php echo esc_attr($cta_rel); ?>">
      <?php echo esc_html($cta_title ?: __('Start Now', 'projecttheme')); ?>
    </a>
  <?php endif; ?>
</div>
