<?php

namespace Drupal\pagedesigner_theme_settings;

use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\pagedesigner_theme_settings\Entity\ThemeSettings;

/**
 * Defines an interface for Color plugin plugins.
 */
interface StyleDefinitionPluginInterface extends PluginInspectionInterface {

  /**
   * Return the container's label.
   *
   * @return string
   *   returns the label as a string.
   */
  public function getLabel();

  /**
   * Return the SCSS code of the style definition.
   *
   * @return string
   *   Returns the SCSS code of all of the containers style definitions.
   */
  public function getScss($entity);

  /**
   * Adds style container to the config's style_definitions_containers field.
   *
   * @param \Drupal\pagedesigner_theme_settings\Entity\ThemeSettings $config
   *   Theme settings config entitty.
   */
  public function initConfig(ThemeSettings $config);

  /**
   * Returns the form field for the definition.
   *
   * @param array $configValue
   *   Config values for the specific definition.
   * @param string $themeSettingsId
   *   ID of the parent theme settings.
   *
   * @return array
   *   Render array of the definitions form field.
   */
  public function getPreview(array $configValue, string $themeSettingsId);

  /**
   * Returns the form element for the definition.
   *
   * @param array $form
   *   Render array for the form.
   * @param array $configValue
   *   Config values for the specific definition.
   *
   * @return array
   *   Render array of the definitions form.
   */
  public function getEditForm(array &$form, array $configValue);

  /**
   * Returns link to the create form.
   *
   * @param string $themeSettingsId
   *   ID of the parent theme settings.
   */
  public function getCreateLink(string $themeSettingsId);

  /**
   * Returns link to the edit form.
   *
   * @param string $themeSettingsId
   *   ID of the parent theme settings.
   * @param string $definitionId
   *   ID of the definition.
   */
  public function getEditLink(string $themeSettingsId, string $definitionId);

  /**
   * Returns link to the delete form.
   */
  public function getDeleteLink();

}
