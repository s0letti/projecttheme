<?php
$title = get_sub_field('title') ?: __('Contraction Possibilities', 'projecttheme');
$text = get_sub_field('text');
$hormonal_button = get_sub_field('hormonal_button') ?: __('Hormonal', 'projecttheme');
$non_hormonal_button = get_sub_field('non_hormonal_button') ?: __('Non Hormonal', 'projecttheme');
?>
<div class="contraction-possibilities__content">
  <h2 class="contraction-possibilities__title"><?php echo esc_html($title); ?></h2>
  <?php if ($text) : ?>
    <p class="contraction-possibilities__text"><?php echo nl2br(esc_html($text)); ?></p>
  <?php endif; ?>
  <nav class="contraction-possibilities__actions" aria-label="<?php esc_attr_e('Contraceptive options', 'projecttheme'); ?>">
    <a class="contraction-possibilities__button" href="#hormonal"><?php echo esc_html($hormonal_button); ?></a>
    <a class="contraction-possibilities__button" href="#non-hormonal"><?php echo esc_html($non_hormonal_button); ?></a>
  </nav>
</div>
