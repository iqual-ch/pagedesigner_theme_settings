<?php

namespace Drupal\pagedesigner_theme_settings\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a StyleDefinitionContainerPlugin plugin item annotation object.
 *
 * @see \Drupal\pagedesigner_theme_settings\StyleDefinitionContainerPluginBase
 * @see plugin_api
 *
 * @Annotation
 */
class StyleDefinitionContainerPlugin extends Plugin {

  /**
   * Style definition container machine name.
   *
   * @var string
   */
  public $id;

  /**
   * Style definition container label.
   *
   * @var string
   */
  public $label;

  /**
   * Weight, used for sorting.
   *
   * @var int
   */
  public $weight;

  /**
   * Style definition group.
   *
   * @var string
   */
  public $group;

}
