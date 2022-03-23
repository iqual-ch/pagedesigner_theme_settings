<?php

namespace Drupal\pagedesigner_theme_settings_color\Plugin\StyleDefinition;

use Drupal\pagedesigner_theme_settings\StyleDefinitionPluginBase;

/**
 * Class ColorGroup, defines a group of colors.
 *
 * @StyleDefinitionPlugin(
 *   id = "color_group",
 *   label = @Translation("Color Group"),
 *   weight = 10,
 *   group = "color_definition"
 * )
 */
class ColorGroup extends StyleDefinitionPluginBase {

  /**
   * {@inheritdoc}
   */
  public function getScss($definitions) {
    $scss = '// ' . $definitions['label'] . "\n";
    foreach ($definitions['colors'] as $definition) {
      $manager = \Drupal::service('plugin.manager.pagedesigner_theme_settings.style_definition');
      $scss .= $manager->createInstance($definition['plugin_id'])->getScss($definition);
    }
    return $scss. "\n";
  }

  /**
   * {@inheritdoc}
   */
  public function getPreview(array $configValue, string $themeSettingsId) {
    $renderArray = [
      '#type' => 'container',
      '#title' => $configValue['label'],
      '#attributes' => [
        'class' => 'pts-color-group',
      ],
      '#attached' => [
        'library' => 'pagedesigner_theme_settings_color/backend-styling',
      ],
    ];

    $markup = '<a class="pts-edit-color-group" href="' . $this->getEditLink($themeSettingsId, $configValue['id']) . '">' . $configValue['label'] . '</a>';
    $renderArray['edit_group'] = [
      '#type' => 'markup',
      '#markup' => $markup,
    ];

    if (isset($configValue['colors'])) {
      $manager = \Drupal::service('plugin.manager.pagedesigner_theme_settings.style_definition');
      foreach ($configValue['colors'] as $definition) {
        $definitionsPlugin = $manager->createInstance($definition['plugin_id']);
        $renderArray[$definition['id']] = $definitionsPlugin->getPreview($definition, $themeSettingsId);
      }
    }

    return $renderArray;
  }

  /**
   * {@inheritdoc}
   */
  public function createDefinition($values) {
    if (!isset($values['colors'])) {
      $values['colors'] = [];
    }
    parent::createDefinition($values);
  }

}
