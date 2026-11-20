<?php
$kicker = get_sub_field('kicker') ?: __('Athletic activities', 'projecttheme');
$heading = get_sub_field('heading') ?: __('What exercise did you do?', 'projecttheme');
?>
<div
  class="period-activities"
  data-activity-tracker
  data-storage-key="projecttheme-period-dates-v1"
  data-load-error="<?php esc_attr_e('Saved activities could not be loaded from this browser.', 'projecttheme'); ?>"
  data-selected-message="<?php esc_attr_e('Activities selected. Save your entry to add them to the calendar.', 'projecttheme'); ?>"
>
  <div class="period-activities__intro">
    <p class="period-activities__kicker"><?php echo esc_html($kicker); ?></p>
    <h2 class="period-activities__heading"><?php echo esc_html($heading); ?></h2>
  </div>

  <div class="period-activities__options" role="group" aria-label="<?php esc_attr_e('Select activities for today', 'projecttheme'); ?>">
    <button class="period-activities__option" type="button" data-activity-choice="strength" aria-pressed="false">
      <svg class="period-activities__icon" viewBox="0 0 24 24" aria-hidden="true">
        <path d="M3 12h4l3-7 4 14 3-7h4" />
      </svg>
      <span><?php esc_html_e('Strength', 'projecttheme'); ?></span>
    </button>

    <button class="period-activities__option" type="button" data-activity-choice="cardio" aria-pressed="false">
      <svg class="period-activities__icon" viewBox="0 0 24 24" aria-hidden="true">
        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
      </svg>
      <span><?php esc_html_e('Cardio', 'projecttheme'); ?></span>
    </button>

    <button class="period-activities__option" type="button" data-activity-choice="hiit" aria-pressed="false">
      <svg class="period-activities__icon" viewBox="0 0 24 24" aria-hidden="true">
        <path d="M13 2 3 14h8l-1 8 11-12h-8l1-8z" />
      </svg>
      <span><?php esc_html_e('HIIT', 'projecttheme'); ?></span>
    </button>

    <button class="period-activities__option" type="button" data-activity-choice="yoga" aria-pressed="false">
      <svg class="period-activities__icon" viewBox="0 0 24 24" aria-hidden="true">
        <path d="M12 8a4 4 0 1 0 0 8 4 4 0 0 0 0-8z M12 2v2 M12 20v2 M4.93 4.93l1.42 1.42 M17.65 17.65l1.42 1.42 M2 12h2 M20 12h2 M4.93 19.07l1.42-1.42 M17.65 6.35l1.42-1.42" />
      </svg>
      <span><?php esc_html_e('Yoga', 'projecttheme'); ?></span>
    </button>
  </div>

  <p class="period-activities__status" data-activity-status role="status" aria-live="polite"></p>
</div>
