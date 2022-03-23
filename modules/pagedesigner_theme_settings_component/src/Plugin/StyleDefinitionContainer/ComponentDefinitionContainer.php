<?php

namespace Drupal\pagedesigner_theme_settings_component\Plugin\StyleDefinitionContainer;

use Drupal\pagedesigner_theme_settings\StyleDefinitionContainerPluginBase;

/**
 * Class ComponentDefinitionContainer.
 *
 * @StyleDefinitionContainerPlugin(
 *   id = "component_definition_container",
 *   label = @Translation("Component styling"),
 *   weight = 40,
 *   group = "component_definition"
 * )
 */
class ComponentDefinitionContainer extends StyleDefinitionContainerPluginBase {

  /**
   * {@inheritdoc}
   */
  public function getDefinitionsList(array &$form, string $themeSettingsId, array $configValue) {
    $patterns = \Drupal::service('plugin.manager.ui_patterns')->getDefinitions();

    $form['list-definition'] = [
      '#type' => 'container',
      '#title' => $configValue['label'],
      '#attributes' => [
        'class' => 'pts-definitions-wrapper pts-definition-group-' . $this->pluginDefinition['group'],
      ],
    ];

    ksort($patterns);
    foreach ($patterns as $pattern_id => $pattern) {

     $renderArray = [
        '#type' => 'container',
        '#title' => $pattern_id,
        '#attributes' => [
          'class' => 'pts-definitions-wrapper pts-definition-group-' . $this->pluginDefinition['group'],
        ],
      ];

      $markup = '<strong>' . $pattern_id . '</strong>';
      $renderArray['edit_group'] = [
        '#type' => 'markup',
        '#markup' => $markup,
      ];

      $form['list-definition'][$pattern_id] = $renderArray;

      if (array_key_exists($pattern_id, $configValue['definitions'])) {
        $definitions = $configValue['definitions'][$pattern_id];
        array_multisort(array_map(function ($element) {
          return $element['weight'];
        }, $definitions), SORT_ASC, $definitions);

        foreach ($definitions as $definition) {
          $definitionsPlugin = $this->pluginManager->createInstance($definition['plugin_id']);
          $form['list-definition'][$pattern_id][$definition['id']] = $definitionsPlugin->getPreview($definition, $themeSettingsId);
        }
      }



    }
  }

}
