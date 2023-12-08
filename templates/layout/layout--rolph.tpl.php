<?php
/**
 * @file
 * Template for the Rolph layout.
 *
 * Variables:
 * - $title: The page title, for use in the actual HTML content.
 * - $messages: Status and error messages. Should be displayed prominently.
 * - $tabs: Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node.)
 * - $action_links: Array of actions local to the page, such as 'Add menu' on
 *   the menu administration interface.
 * - $classes: Array of CSS classes to be added to the layout wrapper.
 * - $attributes: Array of additional HTML attributes to be added to the layout
 *     wrapper. Flatten using backdrop_attributes().
 * - $content: An array of content, each item in the array is keyed to one
 *   region of the layout. This layout supports the following sections:
 *   - $content['header']
 *   - $content['top']
 *   - $content['quarter1']
 *   - $content['quarter2']
 *   - $content['quarter3']
 *   - $content['quarter4']
 *   - $content['bottom']
 *   - $content['footer']
 */
?>
<div class="layout--rolph gin page-wrapper <?php print implode(' ', $classes); ?>"<?php print backdrop_attributes($attributes); ?>>
  <div id="skip-link">
    <a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
  </div>
  <div class="region-sticky-watcher"></div>
  <?php if ($content['header']): ?>
    <header class="l-header gin-secondary-toolbar" role="banner" aria-label="<?php print t('Site header'); ?>">
      <div class="l-header-inner container-fluid">
        <?php print $content['header']; ?>
      </div>
    </header>
  <?php endif; ?>

  <header class="region region-sticky">
    <div class="region-sticky__items l-page-title container-fluid">
      <div class="region-sticky__items__inner">
        <div class="block-page-title-block">
          <?php print render($title_prefix); ?>
          <?php if ($title): ?>
            <h1 class="page-title"><?php print $title; ?></h1>
          <?php endif; ?>
          <?php print render($title_suffix); ?>
        </div>
        <div class="block-gin-local-actions">
          <?php print render($action_links); ?>
        </div>
    </div>
  </header>
  <div class="sticky-shadow"></div>
  <?php if ($tabs): ?>
    <div class="content-header clearfix">
      <div class="layout-container">
        <nav class="tabs-wrapper is-horizontal is-collapsible position-container is-horizontal-enabled" role="navigation" aria-labelled-by="primary-tabs-title">
          <?php print $tabs; ?>
        </nav>
      </div>
    </div>
  <?php endif; ?>
  <div class="layout-container">
    <main class="page-content clearfix gin-layer-wrapper" role="main">
      <div class="visually-hidden">
        <a id="main-content" tabindex="-1"></a>
      </div>
      <?php if ($messages): ?>
        <div class="l-messages help" role="status" aria-label="<?php print t('Status messages'); ?>">
          <?php print $messages; ?>
        </div>
        <?php endif; ?>

      <?php if (!empty($content['top'])): ?>
        <div class="l-top region-highlighted">
          <?php print $content['top']; ?>
        </div>
      <?php endif; ?>

      <div class="l-middle l-quarters row">
        <div class="l-quarters-region col-md-3">
          <?php print $content['quarter1']; ?>
        </div>
        <div class="l-quarters-region col-md-3">
          <?php print $content['quarter2']; ?>
        </div>
        <div class="l-quarters-region col-md-3">
          <?php print $content['quarter3']; ?>
        </div>
        <div class="l-quarters-region col-md-3">
          <?php print $content['quarter4']; ?>
        </div>
      </div><!-- /.l-middle -->

      <?php if (!empty($content['bottom'])): ?>
        <div class="l-bottom region-content">
          <?php print $content['bottom']; ?>
        </div>
      <?php endif; ?>

    </main><!-- /.page-content -->
  </div><!-- /.layout-container -->

  <?php if ($content['footer']): ?>
    <footer class="l-footer">
      <div class="l-footer-inner container-fluid">
        <?php print $content['footer']; ?>
      </div>
    </footer>
  <?php endif; ?>
</div><!-- /.layout--rolph -->
