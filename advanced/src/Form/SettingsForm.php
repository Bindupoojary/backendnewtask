<?php

namespace Drupal\advanced\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure advanced settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'advanced_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['advanced.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state,) {

    $config = \Drupal::config('advanced.settings');
    $tag_value = $config->get('tags');


    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('title'),
      '#default_value' => $config->get('title'),

    ];
    $form['advanced'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('advanced'),
      '#default_value' => $config->get('advanced'),

    ];
    $form['tags'] = [
      '#type' => 'entity_autocomplete',
      '#title' => $this->t('tags'),
      '#target_type' => 'taxonomy_term',
      '#default_value' => \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($tag_value),
      '#required' => TRUE,
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('advanced.settings')
      ->set('title', $form_state->getValue('title'))
      ->set('advanced', $form_state->getValue('advanced'))
      ->set('tags', $form_state->getValue('tags'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
