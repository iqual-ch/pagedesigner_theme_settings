<?php

namespace Drupal\pagedesigner_theme_settings_component\Plugin\StyleDefinition;

use Drupal\pagedesigner_theme_settings\StyleDefinitionPluginBase;
use Drupal\Core\Serialization\Yaml;
use Symfony\Component\Yaml\Yaml as YamlParser;
use Drupal\Component\Serialization\Yaml as YamlSerializer;

/**
 * Class Component, contains the component styling.
 *
 * @StyleDefinitionPlugin(
 *   id = "component",
 *   label = @Translation("Component Styling"),
 *   weight = 10,
 *   group = "component_definition"
 * )
 */
class Component extends StyleDefinitionPluginBase {

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
    $markup = '<a class="pts-edit-color" href="' . $this->getEditLink($themeSettingsId, $configValue['id']) . '"><strong>' . $configValue['label'] . '</strong></a>';

    return [
      '#type' => 'markup',
      '#markup' => $markup,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getEditForm(array &$form, array $configValue) {
    parent::getEditForm($form, $configValue);

    $form['scss_var'] = [
      '#type' => 'textfield',
      '#title' => $this->t("SCSS Mixin name"),
      '#default_value' => isset($configValue['scss_var']) ? $configValue['scss_var'] : '',
    ];

    $form['css_selectors'] = [
      '#type' => 'textfield',
      '#title' => $this->t("CSS Selectors"),
      '#default_value' => isset($configValue['css_selectors']) ? $configValue['css_selectors'] : '',
    ];

    $form['value'] = [
      '#type' => 'textarea',
      '#title' => $this->t("CSS Definitions"),
      '#default_value' => isset($configValue['value']) ? Yaml::encode($configValue['value']) : '',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function processValues($values) {
    $values['value'] = YamlSerializer::decode($values['value']);
    return $values;
  }

}
