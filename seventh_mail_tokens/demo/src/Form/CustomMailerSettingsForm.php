<?php

namespace Drupal\demo\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Document.
 */
class CustomMailerSettingsForm extends ConfigFormBase {

  /**
   * Document.
   */
  protected function getEditableConfigNames() {
    return ['custom_mailer.settings'];
  }

  /**
   * Document.
   */
  public function getFormId() {
    return 'custom_mailer_settings_form';
  }

  /**
   * Document.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('custom_mailer.settings');

    $form['subject'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Email Subject'),
      '#default_value' => $config->get('subject') ?? '',
      '#required' => TRUE,
    ];

    $form['message'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Email Message'),
      '#default_value' => $config->get('message') ?? '',
      '#required' => TRUE,
    // Set the CKEditor format here.
      '#format' => 'full_html',
    ];

    // Token support.
    if (\Drupal::moduleHandler()->moduleExists('token')) {
      $form['tokens'] = [
        '#title' => $this->t('Tokens'),
        '#type' => 'container',
      ];
      $form['tokens']['help'] = [
        '#theme' => 'token_tree_link',
        '#token_types' => [
          'node',
        ],
        '#global_types' => FALSE,
        '#dialog' => TRUE,
      ];
    }

    return parent::buildForm($form, $form_state);
  }

  /**
   * Document.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('custom_mailer.settings')
      ->set('subject', $form_state->getValue('subject'))
    // Use ['value'] to get the formatted text.
      ->set('message', $form_state->getValue('message')['value'])
      ->save();

    parent::submitForm($form, $form_state);
  }

}
