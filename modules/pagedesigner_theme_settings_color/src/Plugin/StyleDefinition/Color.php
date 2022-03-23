<?php

namespace Drupal\pagedesigner_theme_settings_color\Plugin\StyleDefinition;

use Drupal\pagedesigner_theme_settings\StyleDefinitionPluginBase;

/**
 * Class Color, contains the color definition.
 *
 * @StyleDefinitionPlugin(
 *   id = "color",
 *   label = @Translation("Color"),
 *   weight = 20,
 *   group = "color_definition"
 * )
 */
class Color extends StyleDefinitionPluginBase {

  /**
   * {@inheritdoc}
   */
  public function getScss($definition) {
    return  $definition['scss_var'] . ': ' . $definition['value'] . ";\n";
  }

  /**
   * {@inheritdoc}
   */
  public function getPreview(array $configValue, string $themeSettingsId) {
    $markup = '<a class="pts-edit-color" href="' . $this->getEditLink($themeSettingsId, $configValue['id']) . '"><div data-background-color="' . $configValue['value'] . '"></div><strong>' . $configValue['label'] . '</strong>' . $configValue['value'] . '</a>';

    $color = [];
    $color[$configValue['id']] = [
      'label' =>  $configValue['label'],
      'value' =>  $configValue['value'],
      'scss_var' =>  $configValue['scss_var'],
    ];

    return [
      '#type' => 'markup',
      '#markup' => $markup,
      '#attached' => [
        'library' => 'pagedesigner_theme_settings_color/backend-styling',
        'drupalSettings' => [
          'pagedesigner_theme_settings' => [
            'color' => [
              'definitions' => $color,
            ],
          ],
        ]
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getEditForm(array &$form, array $configValue) {
    parent::getEditForm($form, $configValue);

    $form['scss_var'] = [
      '#type' => 'textfield',
      '#title' => $this->t("SCSS Variable name"),
      '#default_value' => isset($configValue['scss_var']) ? $configValue['scss_var'] : '',
    ];

    $form['value'] = [
      '#type' => 'textfield',
      '#title' => $this->t("Value"),
      '#default_value' => isset($configValue['value']) ? $configValue['value'] : '',
    ];

    $form['group'] = [
      '#type' => 'select',
      '#title' => $this->t("Group"),
      '#empty_option' => $this->t('None'),
      '#options' => $this->getDefinitionGroups(),
      '#default_value' => isset($configValue['group']) ? $configValue['group'] : '',
    ];

  }

  /**
   * {@inheritdoc}
   */
  public function createDefinition($values) {
    $groupId = $values['group'];
    if (!$this->themeSettings->style_definitions_containers[$this->containerId]['definitions'][$groupId]['colors']) {
      $this->themeSettings->style_definitions_containers[$this->containerId]['definitions'][$groupId]['colors'] = [];
    }
    $this->themeSettings->style_definitions_containers[$this->containerId]['definitions'][$groupId]['colors'][$values['id']] = $values;
    $this->themeSettings->save();
  }

  private function getDefinitionGroups() {
    $options = [];
    foreach ($this->themeSettings->style_definitions_containers['color_definition_container']['definitions'] as $definitionKey => $definitionValue) {
      if ($definitionValue['plugin_id'] == 'color_group') {
        $options[$definitionKey] = $definitionValue['label'];
      }
    }
    return $options;
  }

}
