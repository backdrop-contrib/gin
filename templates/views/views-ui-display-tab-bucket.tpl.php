    <?php
    /**
     * @file
     * Template for each "box" on the display query configuration screen.
     */
    $classes[] = 'views-ui-display-tab-bucket';
    ?>
    <div class="<?php print implode(' ', $classes); ?>"<?php print backdrop_attributes($attributes); ?>>
      <?php print $item_help_icon; ?>
      <?php if(!empty($actions)) : ?>
        <?php print $actions; ?>
      <?php endif; ?>
      <?php if (!empty($title)) : ?>
        <div class="views-ui-display-tab-bucket__header">
          <h3 class="views-ui-display-tab-bucket__title"><?php print $title; ?></h3>
        </div>
      <?php endif; ?>
      <div class="views-display-setting views-ui-display-tab-setting">
        <?php print $content; ?>
      </div>
    </div>

