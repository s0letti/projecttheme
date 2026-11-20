<?php
$heading = get_sub_field('heading') ?: __('Non Hormonal', 'projecttheme');
$condom_title = get_sub_field('condom_title') ?: __('The Condom', 'projecttheme');
$condom_text = get_sub_field('condom_text');
$copper_iud_title = get_sub_field('copper_iud_title') ?: __('The Copper IUD', 'projecttheme');
$copper_iud_text = get_sub_field('copper_iud_text');
?>
<div class="c-disclosure__inner">
  <details class="c-disclosure__details" id="non-hormonal">
    <summary class="c-disclosure__summary">
      <span class="c-disclosure__heading"><?php echo esc_html($heading); ?></span>
    </summary>
    <div class="c-disclosure__content">
      <?php if ($condom_text) : ?>
        <section class="c-disclosure__item">
          <h3 class="c-disclosure__item-title"><?php echo esc_html($condom_title); ?></h3>
          <p class="c-disclosure__text"><?php echo nl2br(esc_html($condom_text)); ?></p>
        </section>
      <?php endif; ?>

      <?php if ($copper_iud_text) : ?>
        <section class="c-disclosure__item">
          <h3 class="c-disclosure__item-title"><?php echo esc_html($copper_iud_title); ?></h3>
          <p class="c-disclosure__text"><?php echo nl2br(esc_html($copper_iud_text)); ?></p>
        </section>
      <?php endif; ?>
    </div>
  </details>
</div>
