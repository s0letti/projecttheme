<?php
$heading = get_sub_field('heading') ?: __('Body & Mind', 'projecttheme');
$phase_content = [
  'period' => [
    'description' => __('Estradiol and progesterone are typically at their lowest during menstruation. The uterine lining sheds, and prostaglandins can trigger cramps, headaches or nausea. Heavy bleeding may also lower iron levels and contribute to fatigue.

Lower hormone levels, discomfort and poor sleep can affect energy and mood. Everyone experiences their cycle differently.

These effects are tendencies, not rules, and research is still limited.', 'projecttheme'),
    'illustration' => null,
    'description_is_html' => false,
  ],
  'follicular' => [
    'description' => __('Follicle-stimulating hormone helps an egg mature while estradiol rises and rebuilds the uterine lining. Some people notice better energy, focus or recovery as the phase progresses.

Rising estradiol may support serotonin and dopamine activity. You might feel more motivated or creative, though experiences vary from person to person.

These effects are tendencies, not rules, and research is still limited.', 'projecttheme'),
    'illustration' => null,
    'description_is_html' => false,
  ],
  'ovulation' => [
    'description' => __('An increase in luteinizing hormone helps release a mature egg. Cervical mucus may become clearer and stretchier, and body temperature can rise slightly afterwards.

Some people notice more energy, confidence or libido; others feel no change or experience one-sided pelvic discomfort. Responses vary widely.

These effects are tendencies, not rules, and research is still limited.', 'projecttheme'),
    'illustration' => null,
    'description_is_html' => false,
  ],
  'luteal' => [
    'description' => __('After ovulation, the corpus luteum produces progesterone. Body temperature may rise slightly, and some people notice slower digestion, bloating, breast tenderness or changes in appetite.

Toward the end of the phase, progesterone and estradiol fall. This can be linked to PMS symptoms such as headaches, cravings, sleep changes or shifts in mood.

These effects are tendencies, not rules, and research is still limited.', 'projecttheme'),
    'illustration' => null,
    'description_is_html' => false,
  ],
];

if (have_rows('phase_content')) {
  while (have_rows('phase_content')) {
    the_row();
    $phase = get_sub_field('phase');

    if (!isset($phase_content[$phase])) {
      continue;
    }

    $description = get_sub_field('description');
    if (is_string($description) && trim(wp_strip_all_tags($description)) !== '') {
      $phase_content[$phase]['description'] = $description;
      $phase_content[$phase]['description_is_html'] = true;
    }

    $illustration = get_sub_field('illustration');
    if (is_array($illustration) && !empty($illustration['ID'])) {
      $phase_content[$phase]['illustration'] = $illustration['ID'];
    }
  }
}
?>
<div
  class="body-mind"
  data-body-mind
  data-storage-key="projecttheme-period-dates-v1"
  data-empty-message="<?php esc_attr_e('Mark the first day of your period in the calendar to see body and mind information for your current phase.', 'projecttheme'); ?>"
  data-error-message="<?php esc_attr_e('Your saved cycle data could not be loaded from this browser.', 'projecttheme'); ?>"
  data-no-content-message="<?php esc_attr_e('No body and mind information has been added for your current phase yet.', 'projecttheme'); ?>"
  data-phase-status-template="<?php esc_attr_e('Body and mind information for the %s phase is now shown.', 'projecttheme'); ?>"
  data-period-label="<?php esc_attr_e('menstruation', 'projecttheme'); ?>"
  data-follicular-label="<?php esc_attr_e('follicular', 'projecttheme'); ?>"
  data-ovulation-label="<?php esc_attr_e('ovulation', 'projecttheme'); ?>"
  data-luteal-label="<?php esc_attr_e('luteal', 'projecttheme'); ?>"
>
  <div class="body-mind__cards">
    <?php foreach ($phase_content as $phase => $content) : ?>
      <article class="body-mind__card" data-body-mind-card data-phase="<?php echo esc_attr($phase); ?>">
        <div class="body-mind__copy">
          <h2 class="body-mind__heading"><?php echo esc_html($heading); ?></h2>
          <div class="body-mind__description">
            <?php
            if ($content['description_is_html']) {
              echo wp_kses_post($content['description']);
            } else {
              echo wp_kses_post(wpautop(esc_html($content['description'])));
            }
            ?>
          </div>
        </div>
        <div class="body-mind__illustration body-mind__illustration--<?php echo esc_attr($phase); ?>" aria-hidden="true">
          <?php if ($content['illustration']) : ?>
            <?php echo wp_get_attachment_image($content['illustration'], 'medium', false, ['class' => 'body-mind__image', 'loading' => 'lazy', 'decoding' => 'async', 'alt' => '']); ?>
          <?php else : ?>
            <svg class="body-mind__mascot" viewBox="0 0 120 160" focusable="false">
              <g class="body-mind__limbs">
                <path d="M60 78v38M60 91 39 106M60 91l21 15M60 116 47 145M60 116l13 29" />
              </g>
              <path class="body-mind__head" d="M60 18c-18 0-31 13-31 30 0 15 10 26 24 30l-2 8h18l-2-8c14-4 24-15 24-30 0-17-13-30-31-30Z" />
              <circle class="body-mind__eye" cx="49" cy="47" r="2.5" />
              <circle class="body-mind__eye" cx="71" cy="47" r="2.5" />
              <path class="body-mind__smile" d="M51 58c5 6 13 6 18 0" />
            </svg>
          <?php endif; ?>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
  <p class="body-mind__message" data-body-mind-empty role="status" aria-live="polite">
    <?php esc_html_e('Mark the first day of your period in the calendar to see body and mind information for your current phase.', 'projecttheme'); ?>
  </p>
  <p class="visually-hidden" data-body-mind-status role="status" aria-live="polite"></p>
</div>
