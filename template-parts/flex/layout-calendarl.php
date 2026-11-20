<?php
$heading = get_sub_field('heading');
?>
<div
  class="period-calendar"
  data-period-calendar
  data-storage-key="projecttheme-period-dates-v1"
  data-load-error="<?php esc_attr_e('Saved period dates could not be loaded from this browser.', 'projecttheme'); ?>"
  data-save-error="<?php esc_attr_e('Your browser could not save this period day. It may not be retained after you leave.', 'projecttheme'); ?>"
  data-saved-message="<?php esc_attr_e('Period day saved on this device only.', 'projecttheme'); ?>"
  data-removed-message="<?php esc_attr_e('Period day removed from this device.', 'projecttheme'); ?>"
  data-period-label="<?php esc_attr_e('Period day', 'projecttheme'); ?>"
  data-mood-label="<?php esc_attr_e('Mood', 'projecttheme'); ?>"
  data-mood-happy-label="<?php esc_attr_e('Happy', 'projecttheme'); ?>"
  data-mood-neutral-label="<?php esc_attr_e('Neutral', 'projecttheme'); ?>"
  data-mood-sad-label="<?php esc_attr_e('Bad', 'projecttheme'); ?>"
  data-activities-label="<?php esc_attr_e('Activities', 'projecttheme'); ?>"
  data-activity-strength-label="<?php esc_attr_e('Strength', 'projecttheme'); ?>"
  data-activity-cardio-label="<?php esc_attr_e('Cardio', 'projecttheme'); ?>"
  data-activity-hiit-label="<?php esc_attr_e('HIIT', 'projecttheme'); ?>"
  data-activity-yoga-label="<?php esc_attr_e('Yoga', 'projecttheme'); ?>"
>
  <?php if ($heading) : ?>
    <h2 class="period-calendar__heading"><?php echo esc_html($heading); ?></h2>
  <?php endif; ?>

  <div class="period-calendar__toolbar">
    <button class="period-calendar__nav" type="button" data-calendar-previous aria-label="<?php esc_attr_e('Previous month', 'projecttheme'); ?>">
      <span aria-hidden="true">&lsaquo;</span>
    </button>
    <h3 class="period-calendar__month" data-calendar-month></h3>
    <button class="period-calendar__nav" type="button" data-calendar-next aria-label="<?php esc_attr_e('Next month', 'projecttheme'); ?>">
      <span aria-hidden="true">&rsaquo;</span>
    </button>
    <button class="period-calendar__today" type="button" data-calendar-today><?php esc_html_e('Today', 'projecttheme'); ?></button>
  </div>

  <div class="period-calendar__weekdays" aria-hidden="true">
    <span><?php esc_html_e('Mon', 'projecttheme'); ?></span>
    <span><?php esc_html_e('Tue', 'projecttheme'); ?></span>
    <span><?php esc_html_e('Wed', 'projecttheme'); ?></span>
    <span><?php esc_html_e('Thu', 'projecttheme'); ?></span>
    <span><?php esc_html_e('Fri', 'projecttheme'); ?></span>
    <span><?php esc_html_e('Sat', 'projecttheme'); ?></span>
    <span><?php esc_html_e('Sun', 'projecttheme'); ?></span>
  </div>
  <div class="period-calendar__days" data-calendar-days></div>

  <ul class="period-calendar__legend" aria-label="<?php esc_attr_e('Calendar legend', 'projecttheme'); ?>">
    <li><span class="period-calendar__legend-dot period-calendar__legend-dot--period" aria-hidden="true"></span><?php esc_html_e('Period', 'projecttheme'); ?></li>
    <li><span class="period-calendar__legend-dot period-calendar__legend-dot--today" aria-hidden="true"></span><?php esc_html_e('Today', 'projecttheme'); ?></li>
    <li><span class="period-calendar__mood-key" aria-hidden="true">🙂 😐 🙁</span><?php esc_html_e('Mood', 'projecttheme'); ?></li>
    <li><span class="period-calendar__activity-key" aria-hidden="true"><?php esc_html_e('STR · CAR · HIIT · YOGA', 'projecttheme'); ?></span><?php esc_html_e('Activities', 'projecttheme'); ?></li>
  </ul>

  <p class="period-calendar__hint"><?php esc_html_e('Select a day to mark or remove a period day. Entries stay in this browser only.', 'projecttheme'); ?></p>
  <p class="period-calendar__status" data-calendar-status role="status" aria-live="polite"></p>
</div>
