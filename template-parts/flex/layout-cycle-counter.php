<?php
$phase_descriptions = [
  'period' => get_sub_field('period_description') ?: __('You are currently on your period. Oestrogen and progesterone levels are typically low. Your body is working hard right now. If possible, try to schedule fewer appointments and allow yourself some breaks.', 'projecttheme'),
  'follicular' => get_sub_field('follicular_description') ?: __('You are in the follicular phase. Oestrogen levels generally rise as a follicle develops. You may notice changes in your energy or focus; every cycle is different.', 'projecttheme'),
  'ovulation' => get_sub_field('ovulation_description') ?: __('Ovulation often happens around day 14 in a 28-day cycle, but timing can vary. Notice how your energy and body feel during this phase.', 'projecttheme'),
  'luteal' => get_sub_field('luteal_description') ?: __('You are in the luteal phase. Progesterone typically rises after ovulation, and your energy or mood may shift. Notice what feels supportive for you.', 'projecttheme'),
];
?>
<div
  class="cycle-counter"
  data-cycle-counter
  data-storage-key="projecttheme-period-dates-v1"
  data-empty-title="<?php esc_attr_e('Your cycle starts in the calendar', 'projecttheme'); ?>"
  data-empty-description="<?php esc_attr_e('Mark the first day of your period in the calendar to see your current cycle day and phase.', 'projecttheme'); ?>"
  data-error-title="<?php esc_attr_e('Cycle information unavailable', 'projecttheme'); ?>"
  data-error-description="<?php esc_attr_e('Your saved cycle data could not be loaded from this browser.', 'projecttheme'); ?>"
  data-period-title-template="<?php esc_attr_e('Period Day %d', 'projecttheme'); ?>"
  data-follicular-title-template="<?php esc_attr_e('Follicular Phase - Day %d', 'projecttheme'); ?>"
  data-ovulation-title-template="<?php esc_attr_e('Ovulation - Day %d', 'projecttheme'); ?>"
  data-luteal-title-template="<?php esc_attr_e('Luteal Phase - Day %d', 'projecttheme'); ?>"
  data-period-description="<?php echo esc_attr($phase_descriptions['period']); ?>"
  data-follicular-description="<?php echo esc_attr($phase_descriptions['follicular']); ?>"
  data-ovulation-description="<?php echo esc_attr($phase_descriptions['ovulation']); ?>"
  data-luteal-description="<?php echo esc_attr($phase_descriptions['luteal']); ?>"
  role="status"
  aria-live="polite"
  aria-atomic="true"
>
  <h2 class="cycle-counter__heading" data-cycle-heading><?php esc_html_e('Your cycle starts in the calendar', 'projecttheme'); ?></h2>
  <p class="cycle-counter__description" data-cycle-description><?php esc_html_e('Mark the first day of your period in the calendar to see your current cycle day and phase.', 'projecttheme'); ?></p>
</div>
