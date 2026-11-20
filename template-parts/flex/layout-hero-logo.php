<?php
$logo_alt = get_sub_field('logo_alt') ?: __('Flowwing', 'projecttheme');
?>
<div class="hero-logo">
  <div class="hero-logo__wordmark" role="img" aria-label="<?php echo esc_attr($logo_alt); ?>">
    <?php include get_template_directory() . '/assets/images/flowwing.svg'; ?>
  </div>
</div>
