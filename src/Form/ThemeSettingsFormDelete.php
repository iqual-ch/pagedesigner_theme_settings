<?php

namespace Drupal\pagedesigner_theme_settings\Form;

use Drupal\Core\Entity\EntityDeleteForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Builds the form to delete a set of theme settings.
 */
class ThemeSettingsFormDelete extends EntityDeleteForm {

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->messenger()->addMessage($this->t('Theme settings %label have been deleted.', ['%label' => $this->entity->label()]));
    $this->entity->delete();
    $form_state->setRedirect('entity.theme_settings.collection');
  }

}
