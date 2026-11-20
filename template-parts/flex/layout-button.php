<?php
$link = get_sub_field('button_link');
$url = is_array($link) && !empty($link['url']) ? $link['url'] : '';
$label = is_array($link) && !empty($link['title']) ? $link['title'] : __('Update Period', 'projecttheme');
$target = is_array($link) && !empty($link['target']) ? $link['target'] : '_self';
$rel = $target === '_blank' ? 'noopener noreferrer' : '';
?>
<?php if ($url) : ?>
  <div class="button-component">
    <a
      class="button-component__link"
      href="<?php echo esc_url($url); ?>"
      target="<?php echo esc_attr($target); ?>"
      rel="<?php echo esc_attr($rel); ?>"
    ><?php echo esc_html($label); ?></a>
  </div>
<?php endif; ?>
