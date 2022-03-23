<?php

namespace Drupal\pagedesigner_theme_settings\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a StyleDefinitionPlugin item annotation object.
 *
 * @see \Drupal\pagedesigner_theme_settings\StyleDefinitionPluginBase
 * @see plugin_api
 *
 * @Annotation
 */
class StyleDefinitionPlugin extends Plugin {

  /**
   * Style definition machine name.
   *
   * @var string
   */
  public $id;

  /**
   * Style definition label.
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
