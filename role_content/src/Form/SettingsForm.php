<?php

namespace Drupal\role_content\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configuration form for content access control.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_content_access_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['custom_content_access.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $roles = user_roles();
    $content_types = \Drupal::entityTypeManager()->getStorage('node_type')->loadMultiple();

    $config = $this->config('custom_content_access.settings');

    $form['roles'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Roles'),
      '#options' => array_map(function ($role) {
        return $role->label();
      }, $roles),
      '#default_value' => $config->get('roles') ?? [],
    ];

    $form['content_types'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Content Types'),
      '#options' => array_map(function ($content_type) {
        return $content_type->label();
      }, $content_types),
      '#default_value' => $config->get('content_types') ?? [],
    ];


    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();

    $this->config('custom_content_access.settings')
      ->set('roles', $values['roles'])
      ->set('content_types', $values['content_types'])
      ->save();

    \Drupal::messenger()->addStatus($this->t('Configuration saved successfully.'));
  }
}
