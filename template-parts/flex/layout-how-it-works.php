<?php
$heading = get_sub_field('heading') ?: __('How it works', 'projecttheme');
$steps = [];

if (have_rows('steps')) {
  while (have_rows('steps')) {
    the_row();
    $steps[] = [
      'title' => get_sub_field('step_title'),
      'description' => get_sub_field('step_description'),
    ];
  }
}

if (!$steps) {
  $steps = [
    [
      'title' => __('Enter your last period', 'projecttheme'),
      'description' => __('Add the first day of your last period in the calendar. Flowwing estimates your phases.', 'projecttheme'),
    ],
    [
      'title' => __('Log your mood', 'projecttheme'),
      'description' => __('Choose happy, neutral or bad each day. It takes a few seconds.', 'projecttheme'),
    ],
    [
      'title' => __('Discover your patterns', 'projecttheme'),
      'description' => __('Save your monthly overview and learn when you have energy and when you need rest.', 'projecttheme'),
    ],
  ];
}
?>
<div class="how-it-works">
  <h2 class="how-it-works__heading"><?php echo esc_html($heading); ?></h2>
  <ol class="how-it-works__steps">
    <?php foreach ($steps as $index => $step) : ?>
      <li class="how-it-works__step">
        <span class="how-it-works__number" aria-hidden="true"><?php echo esc_html((string) ($index + 1)); ?></span>
        <?php if (!empty($step['title'])) : ?>
          <h3 class="how-it-works__step-title"><?php echo esc_html($step['title']); ?></h3>
        <?php endif; ?>
        <?php if (!empty($step['description'])) : ?>
          <p class="how-it-works__step-description"><?php echo esc_html($step['description']); ?></p>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ol>
</div>
