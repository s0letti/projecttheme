<?php
$heading = get_sub_field('heading') ?: __('Hormonal', 'projecttheme');
$pill_title = get_sub_field('pill_title') ?: __('The Pill', 'projecttheme');
$pill_text = get_sub_field('pill_text');
$iud_title = get_sub_field('iud_title') ?: __('The Hormonal IUD', 'projecttheme');
$iud_text = get_sub_field('iud_text');
?>
<div class="c-disclosure__inner">
  <details class="c-disclosure__details" id="hormonal">
    <summary class="c-disclosure__summary">
      <span class="c-disclosure__heading"><?php echo esc_html($heading); ?></span>
    </summary>
    <div class="c-disclosure__content">
      <?php if ($pill_text) : ?>
        <section class="c-disclosure__item">
          <h3 class="c-disclosure__item-title"><?php echo esc_html($pill_title); ?></h3>
          <p class="c-disclosure__text"><?php echo nl2br(esc_html($pill_text)); ?></p>
        </section>
      <?php endif; ?>

      <?php if ($iud_text) : ?>
        <section class="c-disclosure__item">
          <h3 class="c-disclosure__item-title"><?php echo esc_html($iud_title); ?></h3>
          <p class="c-disclosure__text"><?php echo nl2br(esc_html($iud_text)); ?></p>
        </section>
      <?php endif; ?>
    </div>
  </details>
</div>
