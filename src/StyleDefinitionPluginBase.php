<?php

namespace Drupal\pagedesigner_theme_settings;

use Drupal\Component\Plugin\PluginBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\StringTranslation\TranslationInterface;
use Drupal\pagedesigner_theme_settings\Entity\ThemeSettings;

/**
 * Base class for Task plugin plugins.
 *
 * @see \Drupal\pagedesigner_theme_settings\Annotation\StyleDefinitionPlugin
 * @see \Drupal\pagedesigner_theme_settings\StyleDefinitionPluginInterface
 */
abstract class StyleDefinitionPluginBase extends PluginBase implements StyleDefinitionPluginInterface, ContainerFactoryPluginInterface {
  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, TranslationInterface $string_translation) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->stringTranslation = $string_translation;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('string_translation'),
    );
  }

  /**
   * Return the container's label.
   *
   * @return string
   *   returns the label as a string.
   */
  public function getLabel() {
    return $this->pluginDefinition['label'];
  }

  /**
   * Return the SCSS code of the style definition.
   *
   * @return string
   *   Returns the SCSS code of all of the containers style definitions.
   */
  abstract public function getScss($entity);

  /**
   * Adds style container to the config's style_definitions_containers field.
   *
   * @param \Drupal\pagedesigner_theme_settings\Entity\ThemeSettings $config
   *   Theme settings config entitty.
   */
  public function initConfig(ThemeSettings $config) {
    if (!\array_key_exists($this->pluginDefinition['id'], $config['style_definitions_containers'])) {
      $config['style_definitions_containers'][$this->pluginDefinition['id']] = [];
      $config->save();
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getCreateLink(string $themeSettingsId) {
    $currentPath = \Drupal::service('path.current')->getPath();
    return '/admin/appearance/pagedesigner-theme-settings/' . $themeSettingsId . '/definition/add/' . $this->pluginId . '/color_definition_container/' . '?destination=' . $currentPath;
  }

  /**
   * {@inheritdoc}
   */
  public function getEditLink(string $themeSettingsId, string $definitionId) {
    $currentPath = \Drupal::service('path.current')->getPath();
    $pluginManager = \Drupal::service('plugin.manager.pagedesigner_theme_settings.style_definition_container');
    $group = $this->pluginDefinition['group'];
    $containerId = '';
    foreach($pluginManager->getDefinitions() as $key => $containerPlugin) {
      if ($containerPlugin['group'] == $group) {
        $containerId = $key;
      }
    }

    return '/admin/appearance/pagedesigner-theme-settings/' . $themeSettingsId . '/definition/' . $containerId . '/' . $definitionId . '/edit?destination=' . $currentPath;
  }

  /**
   * {@inheritdoc}
   */
  public function getDeleteLink() {
    return '';
  }

  /**
   * {@inheritdoc}
   */
  public function getEditForm(array &$form, array $configValue) {
    $form['label'] = [
      '#required' => TRUE,
      '#type' => 'textfield',
      '#title' => $this->t("Label"),
      '#default_value' => isset($configValue['label']) ? $configValue['label'] : '',
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => isset($configValue['id']) ? $configValue['id'] : '',
      '#required' => TRUE,
      '#machine_name' => [
        'exists' => [$this, 'exists'],
        'replace_pattern' => '[^a-z0-9_.]+',
      ],
      '#disabled' => isset($configValue['id']),
    ];

    $form['weight'] = [
      '#type' => 'number',
      '#title' => $this->t("Weight"),
      '#default_value' => isset($configValue['weight']) ? $configValue['weight'] : '',
    ];
  }

  /**
   * Helper function to check whether the configuration entity exists.
   *
   * @param string $id
   *   The machine name.
   *
   * @return bool
   *   Whether or not the machine name is taken.
   */
  public function exists($id) {
    return (bool) $this->themeSettings->getDefinitionById($id);
  }

  /**
   * Add new definitions to theme settings entity.
   *
   * @param array $values
   *   The defintion as array.
   *
   */
  public function createDefinition($values) {
    $this->themeSettings->style_definitions_containers[$this->containerId]['definitions'][$values['id']] = $values;
    $this->themeSettings->save();
  }


  /**
   * Additional processing to the definition.
   *
   * @param array $values
   *   The defintion as array.
   *
   */
  public function processValues($values) {
    return $values;
  }

}
