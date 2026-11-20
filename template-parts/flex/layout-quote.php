<?php
$quote = get_sub_field('quote_text') ?: __('Your cycle isn’t a limit. It’s a guide.', 'projecttheme');
?>
<figure class="quote__figure">
  <blockquote class="quote__text">
    <span class="quote__mark" aria-hidden="true">“</span>
    <p><?php echo esc_html($quote); ?></p>
    <span class="quote__mark" aria-hidden="true">”</span>
  </blockquote>
</figure>
