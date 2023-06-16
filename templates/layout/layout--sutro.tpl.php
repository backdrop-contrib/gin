<?php
/**
 * @file
 * Template for the Sutro layout.
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
 *   - $content['content']
 *   - $content['half1']
 *   - $content['half2']
 *   - $content['bottom']
 *   - $content['footer']
 *
 */
?>
<div class="layout--sutro <?php print implode(' ', $classes); ?>"<?php print backdrop_attributes($attributes); ?>>
  <div id="skip-link">
    <a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
  </div>

  <?php if ($content['header']): ?>
    <header class="l-header tonic-secondary-toolbar" role="banner" aria-label="<?php print t('Site header'); ?>">
      <div class="l-header-inner container-fluid">
        <?php print $content['header']; ?>
      </div>
    </header>
  <?php endif; ?>
  <header class="region region-sticky">
    <a id="main-content"></a>
    <div class="region-sticky__items l-page-title container-fluid">
      <div class="region-sticky__items__inner">
        <div class="block-page-title-block">
          <?php print render($title_prefix); ?>
          <?php if ($title): ?>
            <h1 class="page-title"><?php print $title; ?></h1>
          <?php endif; ?>
          <?php print render($title_suffix); ?>
        </div>
        <div class="block-tonic-local-actions">
          <?php print render($action_links); ?>
        </div>
      </div>
    </div>
  </header>


  <div class="l-wrapper">
    <div class="l-wrapper-inner container-fluid">

      <?php if ($messages): ?>
        <div class="l-messages" role="status" aria-label="<?php print t('Status messages'); ?>">
          <?php print $messages; ?>
        </div>
      <?php endif; ?>

      <?php if ($tabs): ?>
        <nav class="tabs-wrapper is-horizontal is-collapsible position-container is-horizontal-enabled" role="navigation" aria-labelled-by="primary-tabs-title">
          <?php print $tabs; ?>
        </nav>
      <?php endif; ?>

      <?php print $action_links; ?>

      <?php if (!empty($content['top'])): ?>
        <div class="l-top region">
          <?php print $content['top']; ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($content['content'])): ?>
        <div class="l-content region" role="main" aria-label="<?php print t('Main content'); ?>">
          <?php print $wrap_prefix . $content['content'] . $wrap_suffix; ?>
        </div>
      <?php endif; ?>

      <div class="l-middle l-halves row">
        <div class="l-halves-region col-md-6 region">
          <?php print $content['half1']; ?>
        </div>
        <div class="l-halves-region col-md-6 region">
          <?php print $content['half2']; ?>
        </div>
      </div><!-- /.l-middle -->

      <?php if (!empty($content['bottom'])): ?>
        <div class="l-bottom region">
          <?php print $content['bottom']; ?>
        </div>
      <?php endif; ?>

    </div><!-- /.l-content -->
  </div><!-- /.l-wrapper -->

  <?php if ($content['footer']): ?>
    <footer class="l-footer region">
      <div class="l-footer-inner container-fluid">
        <?php print $content['footer']; ?>
      </div>
    </footer>
  <?php endif; ?>
</div><!-- /.layout--sutro -->
