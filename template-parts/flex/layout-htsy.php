<?php
$default_phase_tips = [
  [
    'phase' => 'period',
    'category' => __('Rest & Recovery', 'projecttheme'),
    'description' => __('Poor sleep can increase pain sensitivity and worsen mood, so aim for a regular schedule. Plan lighter days; energy is often lower, so move demanding tasks to other phases if you can.', 'projecttheme'),
  ],
  [
    'phase' => 'period',
    'category' => __('Movement', 'projecttheme'),
    'description' => __('Walking, stretching, yoga or easy swimming can reduce cramps by improving circulation and releasing endorphins. Listen to your body; if you feel strong, normal training is fine, and if not, rest is just as valid.', 'projecttheme'),
  ],
  [
    'phase' => 'period',
    'category' => __('Nutrition', 'projecttheme'),
    'description' => __('Iron-rich foods like lentils, spinach, oats, pumpkin seeds or red meat can help replace iron. Vitamin C from peppers or citrus improves absorption. Water and warm teas like ginger or chamomile can help with bloating and comfort.', 'projecttheme'),
  ],
  [
    'phase' => 'follicular',
    'category' => __('Rest & Recovery', 'projecttheme'),
    'description' => __('Your body may recover faster now, so you may need less rest than in other phases. Keep a regular sleep schedule anyway, and avoid taking on too much as your energy rises.', 'projecttheme'),
  ],
  [
    'phase' => 'follicular',
    'category' => __('Movement', 'projecttheme'),
    'description' => __('Rising oestrogen can support energy, motivation and recovery. This can be a good time to try new workouts, build strength, increase intensity or train for endurance.', 'projecttheme'),
  ],
  [
    'phase' => 'follicular',
    'category' => __('Nutrition', 'projecttheme'),
    'description' => __('Keep up iron-rich foods with vitamin C, and add enough protein, whole grains and colourful vegetables to fuel your workouts. Fermented foods and water can support digestion and energy.', 'projecttheme'),
  ],
  [
    'phase' => 'ovulation',
    'category' => __('Rest & Recovery', 'projecttheme'),
    'description' => __('Energy and mood may be high, but your body still needs recovery after intense sessions. Prioritise sleep and plan rest days between hard workouts.', 'projecttheme'),
  ],
  [
    'phase' => 'ovulation',
    'category' => __('Movement', 'projecttheme'),
    'description' => __('This can be a good time for intense sessions, team sports, runs or personal bests. Ligaments may be looser around ovulation, so warm up well and pay attention to your knees and joints.', 'projecttheme'),
  ],
  [
    'phase' => 'ovulation',
    'category' => __('Nutrition', 'projecttheme'),
    'description' => __('Fuel your energy with protein, complex carbohydrates, fibre-rich foods and healthy fats. Drink plenty of water to stay hydrated.', 'projecttheme'),
  ],
  [
    'phase' => 'luteal',
    'category' => __('Rest & Recovery', 'projecttheme'),
    'description' => __('Progesterone can make you feel warmer, tired or less able to sleep deeply. Keep a regular bedtime, limit evening caffeine and allow extra rest as your period approaches.', 'projecttheme'),
  ],
  [
    'phase' => 'luteal',
    'category' => __('Movement', 'projecttheme'),
    'description' => __('Moderate strength training and steady cardio may feel good earlier in this phase. Toward the end, try Pilates, yoga, walking or lighter workouts and allow more recovery time.', 'projecttheme'),
  ],
  [
    'phase' => 'luteal',
    'category' => __('Nutrition', 'projecttheme'),
    'description' => __('Regular meals with complex carbohydrates may help keep blood sugar stable. Nuts, seeds and dark chocolate contain magnesium; reduce salt, alcohol or caffeine if they affect how you feel.', 'projecttheme'),
  ],
];

$phase_tips = [];
if (have_rows('phase_tips')) {
  while (have_rows('phase_tips')) {
    the_row();
    $phase = get_sub_field('phase');
    $category = get_sub_field('category');
    $description = get_sub_field('description');

    if (in_array($phase, ['period', 'follicular', 'ovulation', 'luteal'], true) && $category && $description) {
      $phase_tips[] = [
        'phase' => $phase,
        'category' => $category,
        'description' => $description,
      ];
    }
  }
}

if (!$phase_tips) {
  $phase_tips = $default_phase_tips;
}
?>
<div
  class="htsy"
  data-htsy
  data-storage-key="projecttheme-period-dates-v1"
  data-empty-message="<?php esc_attr_e('Add the first day of your period in the calendar to see tips for your current phase.', 'projecttheme'); ?>"
  data-error-message="<?php esc_attr_e('Your saved cycle data could not be loaded from this browser.', 'projecttheme'); ?>"
  data-no-tips-message="<?php esc_attr_e('No support tips have been added for your current phase yet.', 'projecttheme'); ?>"
  data-phase-status-template="<?php esc_attr_e('Support tips for the %s phase are now shown.', 'projecttheme'); ?>"
  data-period-label="<?php esc_attr_e('menstruation', 'projecttheme'); ?>"
  data-follicular-label="<?php esc_attr_e('follicular', 'projecttheme'); ?>"
  data-ovulation-label="<?php esc_attr_e('ovulation', 'projecttheme'); ?>"
  data-luteal-label="<?php esc_attr_e('luteal', 'projecttheme'); ?>"
>
  <div class="htsy__cards">
    <?php foreach ($phase_tips as $tip) : ?>
      <article class="htsy__card" data-htsy-card data-phase="<?php echo esc_attr($tip['phase']); ?>" hidden>
        <h2 class="htsy__category"><?php echo esc_html($tip['category']); ?></h2>
        <p class="htsy__description"><?php echo esc_html($tip['description']); ?></p>
      </article>
    <?php endforeach; ?>
  </div>
  <p class="htsy__message" data-htsy-empty role="status" aria-live="polite">
    <?php esc_html_e('Add the first day of your period in the calendar to see tips for your current phase.', 'projecttheme'); ?>
  </p>
  <p class="visually-hidden" data-htsy-status role="status" aria-live="polite"></p>
</div>
