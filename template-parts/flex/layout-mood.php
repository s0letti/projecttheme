<?php
$kicker = get_sub_field('kicker') ?: __('Choose your mood', 'projecttheme');
$heading = get_sub_field('heading') ?: __('How are you feeling today?', 'projecttheme');
?>
<div
  class="period-mood"
  data-mood-tracker
  data-storage-key="projecttheme-period-dates-v1"
  data-load-error="<?php esc_attr_e('Saved mood could not be loaded from this browser.', 'projecttheme'); ?>"
  data-save-error="<?php esc_attr_e('Your browser could not save these entries. They may not be retained after you leave.', 'projecttheme'); ?>"
  data-selected-message="<?php esc_attr_e('Mood selected. Save your entry to add it to the calendar.', 'projecttheme'); ?>"
  data-saved-message="<?php esc_attr_e('Mood and activities saved to the calendar on this device only.', 'projecttheme'); ?>"
  data-deleted-message="<?php esc_attr_e('Today\'s mood and activity entries were removed from this device.', 'projecttheme'); ?>"
  data-choose-entry-message="<?php esc_attr_e('Choose a mood or activity before saving your entry.', 'projecttheme'); ?>"
>
  <div class="period-mood__intro">
    <p class="period-mood__kicker"><?php echo esc_html($kicker); ?></p>
    <h2 class="period-mood__heading"><?php echo esc_html($heading); ?></h2>
  </div>

  <div class="period-mood__options" role="group" aria-label="<?php esc_attr_e('Select your mood for today', 'projecttheme'); ?>">
    <button class="period-mood__option" type="button" data-mood-choice="happy" aria-pressed="false">
      <svg class="period-mood__face" viewBox="0 0 64 64" aria-hidden="true">
        <circle cx="32" cy="32" r="27" />
        <circle class="period-mood__eye" cx="22" cy="25" r="2" />
        <circle class="period-mood__eye" cx="42" cy="25" r="2" />
        <path d="M20 36c3 7 7 10 12 10s9-3 12-10" />
      </svg>
      <span class="period-mood__label"><?php esc_html_e('Happy', 'projecttheme'); ?></span>
      <span class="period-mood__description"><?php esc_html_e('Energized, positive, or just in a good mood', 'projecttheme'); ?></span>
    </button>

    <button class="period-mood__option" type="button" data-mood-choice="neutral" aria-pressed="false">
      <svg class="period-mood__face" viewBox="0 0 64 64" aria-hidden="true">
        <circle cx="32" cy="32" r="27" />
        <circle class="period-mood__eye" cx="22" cy="25" r="2" />
        <circle class="period-mood__eye" cx="42" cy="25" r="2" />
        <path d="M21 41h22" />
      </svg>
      <span class="period-mood__label"><?php esc_html_e('Neutral', 'projecttheme'); ?></span>
      <span class="period-mood__description"><?php esc_html_e('Not great, not bad, just an ordinary day', 'projecttheme'); ?></span>
    </button>

    <button class="period-mood__option" type="button" data-mood-choice="sad" aria-pressed="false">
      <svg class="period-mood__face" viewBox="0 0 64 64" aria-hidden="true">
        <circle cx="32" cy="32" r="27" />
        <circle class="period-mood__eye" cx="22" cy="25" r="2" />
        <circle class="period-mood__eye" cx="42" cy="25" r="2" />
        <path d="M20 44c3-7 7-10 12-10s9 3 12 10" />
      </svg>
      <span class="period-mood__label"><?php esc_html_e('Bad', 'projecttheme'); ?></span>
      <span class="period-mood__description"><?php esc_html_e('Feeling low, irritable, anxious or drained', 'projecttheme'); ?></span>
    </button>
  </div>

  <div class="period-mood__actions">
    <button class="period-mood__save" type="button" data-period-entry-save><?php esc_html_e('Save Entry', 'projecttheme'); ?></button>
    <button class="period-mood__delete" type="button" data-period-entry-delete><?php esc_html_e('Delete Entry', 'projecttheme'); ?></button>
  </div>
  <p class="period-mood__status" data-period-entry-status role="status" aria-live="polite"></p>
</div>
