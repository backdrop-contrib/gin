<?php
/**
 * @file
 * Override core's block.tpl.php template file.
 *
 * Changes:
 * - Block titles from h2 to h3
 * - Content class
 */
?>
<div class="<?php print implode(' ', $classes); ?>"<?php print backdrop_attributes($attributes); ?>>

<?php print render($title_prefix); ?>
<?php if ($title): ?>
  <h3 class="block-title<?php print ($panel) ? ' panel__title' : ''; ?>"><?php print $title; ?></h3>
<?php endif; ?>
<?php print render($title_suffix); ?>

  <div class="block-content<?php print ($panel) ? ' panel__content' : ''; ?>">
    <?php print render($content); ?>
  </div>
</div>
