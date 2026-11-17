<?php
$cards = get_sub_field('cards') ?: [];

if (empty($cards)) {
  return;
}

$carousel_id = wp_unique_id('carousel-w-');
$initial_index = count($cards) > 1 ? 1 : 0;
?>
<div
  id="<?php echo esc_attr($carousel_id); ?>"
  class="carousel-w"
  data-carousel-w
  data-initial-index="<?php echo esc_attr($initial_index); ?>"
  role="region"
  aria-roledescription="<?php esc_attr_e('carousel', 'projecttheme'); ?>"
  aria-label="<?php esc_attr_e('Carousel', 'projecttheme'); ?>"
>
  <div class="carousel-w__viewport" tabindex="0">
    <div class="carousel-w__track">
      <?php foreach ($cards as $index => $card) :
        $phase = $card['phase'] ?? '';
        $title = $card['title'] ?? '';
        $text = $card['text'] ?? '';
        $is_active = $index === $initial_index;
      ?>
        <article
          class="carousel-w__card<?php echo $is_active ? ' is-active' : ''; ?>"
          role="group"
          aria-roledescription="<?php esc_attr_e('slide', 'projecttheme'); ?>"
          aria-label="<?php echo esc_attr(sprintf(__('%1$d of %2$d', 'projecttheme'), $index + 1, count($cards))); ?>"
        >
          <?php if ($phase) : ?>
            <p class="carousel-w__phase"><?php echo esc_html($phase); ?></p>
          <?php endif; ?>
          <?php if ($title) : ?>
            <h2 class="carousel-w__title"><?php echo esc_html($title); ?></h2>
          <?php endif; ?>
          <?php if ($text) : ?>
            <p class="carousel-w__text"><?php echo nl2br(esc_html($text)); ?></p>
          <?php endif; ?>
        </article>
      <?php endforeach; ?>
    </div>
  </div>

  <?php if (count($cards) > 1) : ?>
    <div class="carousel-w__indicators" role="group" aria-label="<?php esc_attr_e('Choose a slide', 'projecttheme'); ?>">
      <?php foreach ($cards as $index => $card) : ?>
        <button
          class="carousel-w__indicator<?php echo $index === $initial_index ? ' is-active' : ''; ?>"
          type="button"
          data-carousel-w-indicator="<?php echo esc_attr($index); ?>"
          aria-label="<?php echo esc_attr(sprintf(__('Go to slide %d', 'projecttheme'), $index + 1)); ?>"
          aria-pressed="<?php echo $index === $initial_index ? 'true' : 'false'; ?>"
        ></button>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>
