<?php

namespace Drupal\cronmail\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Messenger\MessengerInterface;

/**
 * Configuration form for cron mail settings.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * The module handler service.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * The messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * Constructs a new SettingsForm object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The configuration factory.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler service.
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger service.
   */
  public function __construct(ConfigFactoryInterface $config_factory, ModuleHandlerInterface $module_handler, MessengerInterface $messenger) {
    parent::__construct($config_factory);
    $this->moduleHandler = $module_handler;
    $this->messenger = $messenger;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('module_handler'),
      $container->get('messenger')
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['custom_mailer.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_mailer_settings_form';
  }

  /**
   * {@inheritdoc}
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
      '#type' => 'textfield',
      '#title' => $this->t('Email Message'),
      '#default_value' => $config->get('message') ?? '',
      '#required' => TRUE,
    ];

    // Token support.
    if ($this->moduleHandler->moduleExists('token')) {
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
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('custom_mailer.settings')
      ->set('subject', $form_state->getValue('subject'))
    // Use ['value'] to get the formatted text.
      ->set('message', $form_state->getValue('message'))
      ->save();

    $this->messenger->addStatus($this->t('Configuration saved successfully.'));
    parent::submitForm($form, $form_state);
  }

}
