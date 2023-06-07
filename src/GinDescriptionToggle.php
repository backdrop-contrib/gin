<?php

namespace Drupal\gin;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Service to handle toggling form descriptions.
 */
class TonicDescriptionToggle implements ContainerInjectionInterface {


  /**
   * The content form helper class.
   *
   * @var \Drupal\gin\TonicContentFormHelper
   */
  protected $contentFormHelper;

  /**
   * The tonic theme settings class.
   *
   * @var \Drupal\gin\TonicSettings
   */
  protected $ginSettings;

  /**
   * TonicDescriptionToggle constructor.
   *
   * @param \Drupal\gin\TonicSettings $ginSettings
   *   The tonic theme settings class.
   * @param \Drupal\gin\TonicContentFormHelper $contentFormHelper
   *   The content form helper class.
   */
  public function __construct(TonicSettings $ginSettings, TonicContentFormHelper $contentFormHelper) {
    $this->ginSettings = $ginSettings;
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
