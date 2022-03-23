<?php

namespace Drupal\pagedesigner_theme_settings;

use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\pagedesigner_theme_settings\Entity\ThemeSettings;

/**
 * Defines an interface for StyleDefinitionContainer plugin plugins.
 */
interface StyleDefinitionContainerPluginInterface extends PluginInspectionInterface {

  /**
   * Return the container's label.
   *
   * @return string
   *   returns the label as a string.
   */
  public function getLabel();

  /**
   * Adds style container to the config's style_definitions_containers field.
   *
   * @param \Drupal\pagedesigner_theme_settings\Entity\ThemeSettings $config
   *   Theme settings config entitty.
   */
  public function initConfig(ThemeSettings $config);

  /**
   * Returns the form element for the container.
   *
   * @param array $configValue
   *   Config values for the specific container.
   * @param string $themeSettingsId
   *   ID of the parent theme settings.
   *
   * @return array
   *   Render array of the containers form.
   */
  public function getEditForm(array $configValue, string $themeSettingsId);

}
