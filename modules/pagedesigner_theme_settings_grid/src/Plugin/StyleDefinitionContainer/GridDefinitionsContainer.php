<?php

namespace Drupal\pagedesigner_theme_settings_grid\Plugin\StyleDefinitionContainerPlugin;

use Drupal\pagedesigner_theme_settings\StyleDefinitionContainerPluginBase;

/**
 * Class GridDefinitionsContainer.
 *
 * @package Drupal\pagedesigner_theme_settings\Plugin\StyleDefinitionContainerPlugin
 *
 * @StyleDefinitionContainerPlugin(
 *   id = "grid_definitions_container",
 *   label = @Translation("Grid definitions"),
 *   weight = 30
 * )
 */
class GridDefinitionsContainer extends StyleDefinitionContainerPluginBase {

  /**
   * {@inheritdoc}
   */
  public function getScss() {
    echo "TEST";
  }

}
