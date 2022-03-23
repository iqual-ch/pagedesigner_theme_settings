<?php

namespace Drupal\pagedesigner_theme_settings_typography\Plugin\StyleDefinition;

use Drupal\pagedesigner_theme_settings\StyleDefinitionPluginBase;
use Drupal\Core\Serialization\Yaml;
use Symfony\Component\Yaml\Yaml as YamlParser;
use Drupal\Component\Serialization\Yaml as YamlSerializer;

/**
 * Class Typography, contains the typography definition.
 *
 * @StyleDefinitionPlugin(
 *   id = "typography",
 *   label = @Translation("Typography"),
 *   weight = 20,
 *   group = "typography_definition"
 * )
 */
class Typography extends StyleDefinitionPluginBase {

  /**
   * {@inheritdoc}
   */
  public function getScss($definition) {
    $scss = "@mixin " . $definition['scss_var'] . "{" . "\n";
    foreach ($definition['value']['style'] as $property => $value) {
      $scss .= "  " . $property . ": " . $value . ";" . "\n";
    }

    if (array_key_exists('breakpoints', $definition['value']) && is_array($definition['value']['breakpoints'])) {
      foreach ($definition['value']['breakpoints'] as $breakpoint => $values) {
        $scss .= "  " . '@media only screen and ' . $breakpoint . ' {' . "\n";
        foreach ($values as $property => $value) {
          $scss .= "    " . $property . ": " . $value . ";" . "\n";
        }
        $scss .=  "  }" . "\n";
      }
    }

    if (array_key_exists('pseudo', $definition['value']) && is_array($definition['value']['pseudo'])) {
      foreach ($definition['value']['pseudo'] as $selector => $definitions) {
        $scss .= "  " . '&' . $selector . ' {' . "\n";
        foreach ($definitions['style'] as $property => $value) {
          $scss .= "    " . $property . ": " . $value . ";" . "\n";
        }
        if (array_key_exists('breakpoints', $definitions) && is_array($definitions['breakpoints'])) {
          foreach ($definitions['breakpoints'] as $breakpoint => $values) {
            $scss .= "    " . '@media only screen and ' . $breakpoint . ' {' . "\n";
            foreach ($values as $property => $value) {
              $scss .= "      " . $property . ": " . $value . ";" . "\n";
            }
            $scss .=  "    }" . "\n";
          }
        }
        $scss .=  "  }" . "\n";
      }
    }

    $scss .= "}" . "\n\n";

    return $scss;
  }

  /**
   * {@inheritdoc}
   */
  public function getPreview(array $configValue, string $themeSettingsId) {
    $markup = '<div class="typography-definition" data-gjs-type="typography-definition-holder"><a class="pts-edit-typography" href="' . $this->getEditLink($themeSettingsId, $configValue['id']) . '">' . $configValue['label'] . '</a><div class="definition-preview" data-gjs-type="preview"><div data-gjs-type="editable" id="' . $configValue['id'] . '">' . $configValue['label'] . '</div></div></div>';
    return [
      '#type' => 'markup',
      '#markup' => $markup,
      '#attached' => [
        'drupalSettings' => [
          'pagedesigner_theme_settings' => [
            'typography' => [
              'definitions' => [
                $configValue['id'] => $configValue['value'],
              ],
            ],
          ],
        ],
        'library' => 'pagedesigner_theme_settings_typography/backend-styling',
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
