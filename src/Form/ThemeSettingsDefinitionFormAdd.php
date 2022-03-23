<?php

namespace Drupal\pagedesigner_theme_settings\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form for theme settings.
 */
class ThemeSettingsDefinitionFormAdd extends FormBase {

  /**
   * Theme settings config entity.
   *
   * @var Drupal\pagedesigner_theme_settings\Entity\ThemeSettings
   */
  public $themeSettings;

  /**
   * ID of the currently edited definition.
   *
   * @var string
   */
  public $definitionId;

  /**
   * Plugin of the currently edited definition.
   *
   * @var object
   */
  public $definitionPlugin;

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'pagedesigner_theme_settings_definition_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, string $theme_settings = NULL, string $plugin_id = NULL, string $container_id = NULL) {
    $this->themeSettings = \Drupal::entityTypeManager()->getStorage('theme_settings')->load($theme_settings);
    $this->containerId = $container_id;
    $manager = \Drupal::service('plugin.manager.pagedesigner_theme_settings.style_definition');
    $this->definitionPlugin = $manager->createInstance($plugin_id);
    $this->definitionPlugin->themeSettings = $this->themeSettings;
    $this->definitionPlugin->containerId = $this->containerId;
    $this->definitionPlugin->getEditForm($form, []);
    $form['actions'] = [
      '#type' => 'actions',
    ];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $form_state->cleanValues();
    $values = $this->definitionPlugin->processValues($form_state->getValues());
    $values['plugin_id'] = $this->definitionPlugin->getPluginId();
    $this->definitionPlugin->createDefinition($values);
  }

}
