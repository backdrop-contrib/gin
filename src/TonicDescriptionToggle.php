<?php

namespace Drupal\tonic;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Service to handle toggling form descriptions.
 */
class TonicDescriptionToggle implements ContainerInjectionInterface {


  /**
   * The content form helper class.
   *
   * @var \Drupal\tonic\TonicContentFormHelper
   */
  protected $contentFormHelper;

  /**
   * The tonic theme settings class.
   *
   * @var \Drupal\tonic\TonicSettings
   */
  protected $tonicSettings;

  /**
   * TonicDescriptionToggle constructor.
   *
   * @param \Drupal\tonic\TonicSettings $tonicSettings
   *   The tonic theme settings class.
   * @param \Drupal\tonic\TonicContentFormHelper $contentFormHelper
   *   The content form helper class.
   */
  public function __construct(TonicSettings $tonicSettings, TonicContentFormHelper $contentFormHelper) {
    $this->ginSettings = $tonicSettings;
    $this->contentFormHelper = $contentFormHelper;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $classResolver = $container->get('class_resolver');

    return new static(
      $classResolver->getInstanceFromDefinition(TonicSettings::class),
      $classResolver->getInstanceFromDefinition(TonicContentFormHelper::class),
    );
  }

  /**
   * Generic preprocess enabling toggle.
   *
   * @param array $variables
   *   The variables array (modify in place).
   */
  public function preprocess(array &$variables) {
    if ($this->isEnabled()) {
      if (!empty($variables['description'])) {
        $variables['description_display'] = 'invisible';
        $variables['description_toggle'] = TRUE;
      }
      // Add toggle for text_format, description is in wrapper.
      elseif (!empty($variables['element']['#description_toggle'])) {
        $variables['description_toggle'] = TRUE;
      }
    }
  }

  /**
   * Functionality is enabled via setting on content forms.
   *
   * @return bool
   *   Wether feature is enabled or not.
   */
  public function isEnabled() {
    return $this->ginSettings->get('show_description_toggle') && $this->contentFormHelper->isContentForm();
  }

}
