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
 * @see \Drupal\pagedesigner_theme_settings\Annotation\StyleDefinitionContainerPlugin
 * @see \Drupal\pagedesigner_theme_settings\StyleDefinitionContainerPluginInterface
 */
abstract class StyleDefinitionContainerPluginBase extends PluginBase implements StyleDefinitionContainerPluginInterface, ContainerFactoryPluginInterface {
  use StringTranslationTrait;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, TranslationInterface $string_translation) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->stringTranslation = $string_translation;
    $this->pluginManager = \Drupal::service('plugin.manager.pagedesigner_theme_settings.style_definition');
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
  public function getScss($containerData) {
    $scss = "///////////////////////////////" . "\n";
    $scss .= "// " . $this->pluginDefinition['label']->__toString() . "\n";
    $scss .= "///////////////////////////////" . "\n" . "\n";

    foreach ($containerData['definitions'] as $definition) {
      $scss .= $this->pluginManager->createInstance($definition['plugin_id'])->getScss($definition);
    }
    return $scss . "\n";
  }

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
  public function getEditForm(array $configValue, string $themeSettingsId) {
    $form = [];
    $this->getCreateDefinitionButtons($form, $themeSettingsId);
    $this->getDefinitionsList($form, $themeSettingsId, $configValue);
    return $form;
  }

  /**
   * Creates buttons for adding new styling definitions to a given container.
   *
   * @param array $form
   *   Reference to the $form render array that should contain the buttons.
   * @param string $themeSettingsId
   *   The theme setting's machine name.
   */
  public function getCreateDefinitionButtons(array &$form, string $themeSettingsId) {
    $styleDefinitionPlugins = $this->pluginManager->getDefinitionsByGroup($this->pluginDefinition['group']);

    array_multisort(array_map(function ($element) {
      return $element['weight'];
    }, $styleDefinitionPlugins), SORT_ASC, $styleDefinitionPlugins);

    if (\count($styleDefinitionPlugins)) {

      $form['create-definition'] = [
        '#type' => 'container',
        '#attributes' => [
          'class' => 'pts-create-wrapper',
        ],
        '#attached' => [
          'library' => 'pagedesigner_theme_settings/backend-styling',
        ],
      ];

      foreach ($styleDefinitionPlugins as $plugin) {
        $form['create-definition'][$plugin['id']] = [
          '#type' => 'html_tag',
          '#tag' => 'a',
          '#attributes' => [
            'href' => $this->pluginManager->createInstance($plugin['id'])->getCreateLink($themeSettingsId),
            'class' => 'button',
          ],
          '#value' => $this->t('Add new @type', ['@type' => $plugin['label']]),
        ];
      }
    }
  }

  /**
   * Creates a list of a container's styling definitins.
   *
   * @param array $form
   *   Reference to the $form render array that should contain the buttons.
   * @param string $themeSettingsId
   *   The theme setting's machine name.
   * @param array $configValue
   *   All of the container's definitions values.
   */
  public function getDefinitionsList(array &$form, string $themeSettingsId, array $configValue) {
    $form['list-definition'] = [
      '#type' => 'container',
      '#title' => $configValue['label'],
      '#attributes' => [
        'class' => 'pts-definitions-wrapper pts-definition-group-' . $this->pluginDefinition['group'],
      ],
    ];

    $definitions = $configValue['definitions'];
    array_multisort(array_map(function ($element) {
      return $element['weight'];
    }, $definitions), SORT_ASC, $definitions);

    foreach ($definitions as $definition) {
      $definitionsPlugin = $this->pluginManager->createInstance($definition['plugin_id']);
      $form['list-definition'][$definition['id']] = $definitionsPlugin->getPreview($definition, $themeSettingsId);
    }
  }

}
