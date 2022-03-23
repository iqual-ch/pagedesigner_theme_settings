<?php

namespace Drupal\pagedesigner_theme_settings\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form for theme settings.
 */
class ThemeSettingsForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $form['label'] = [
      '#type' => 'textfield',
      '#title' => 'Label',
      '#default_value' => $this->entity->label(),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $this->entity->id(),
      '#required' => TRUE,
      '#machine_name' => [
        'exists' => [$this, 'exists'],
        'replace_pattern' => '[^a-z0-9_.]+',
      ],
      '#disabled' => !$this->entity->isNew(),
    ];

    $form['theme_settings'] = [
      '#type' => 'vertical_tabs',
      '#title' => t('Theme Settings'),
    ];

    // Section base.
    $form['base_settings'] = [
      '#type' => 'details',
      '#title' => t('Base settings'),
      '#open' => TRUE,
      '#group' => 'theme_settings',
    ];

    $form['base_settings']['target_file'] = [
      '#type' => 'textfield',
      '#title' => t('Target file path'),
      '#required' => TRUE,
      '#default_value' => $this->entity->get('target_file'),
    ];

    $manager = \Drupal::service('plugin.manager.pagedesigner_theme_settings.style_definition_container');

    $containers = $manager->getDefinitions();

    array_multisort(array_map(function ($element) {
      return $element['weight'];
    }, $containers), SORT_ASC, $containers);

    foreach ($containers as $container) {

      $containerPlugin = $manager->createInstance($container['id']);

      $form[$container['id']] = [
        '#type' => 'details',
        '#title' => $container['label'],
        '#group' => 'theme_settings',
      ];

      $definition = [];
      if (array_key_exists($container['id'], $this->entity->get('style_definitions_containers'))) {
        $definition = $this->entity->get('style_definitions_containers')[$container['id']];
      }

      $form[$container['id']] += $containerPlugin->getEditForm($definition, $this->entity->id());
    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {

    // Prevent leading and trailing spaces.
    $this->entity->set('label', trim($form_state->getValue('label')));
    $this->entity->set('id', trim($form_state->getValue('id')));
    $this->entity->set('target_file', trim($form_state->getValue('target_file')));

    $status = $this->entity->save();

    // Tell the user we've updated the profile.
    $action = $status == SAVED_UPDATED ? 'updated' : 'added';
    $msg = $this->t('Themes settings %label have been %action.', [
      '%label' => $this->entity->label(),
      '%action' => $action,
    ]);

    \Drupal::messenger()->addStatus($msg);
    $this->logger('pagedesigner_theme_settings')->notice($msg);

    $this->entity->generateScssFile();

    // Redirect back to the list view.
    $form_state->setRedirect('entity.theme_settings.collection');

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
    $entity = $this->entityTypeManager->getStorage('example')->getQuery()
      ->condition('id', $id)
      ->execute();
    return (bool) $entity;
  }

}
