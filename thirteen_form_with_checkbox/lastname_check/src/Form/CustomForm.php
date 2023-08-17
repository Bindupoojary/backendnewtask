<?php

namespace Drupal\lastname_check\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Psr\Log\LoggerInterface;
// Import the ContainerInterface.
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Configure .
 */
class CustomForm extends FormBase {

  /**
   * The logger service.
   *
   * @var \Psr\Log\LoggerInterface
   */
  protected $logger;

  /**
   * Constructs a new CustomForm object.
   *
   * @param \Psr\Log\LoggerInterface $logger
   *   The logger service.
   */
  public function __construct(LoggerInterface $logger) {
    $this->logger = $logger;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
    // Use the appropriate logger channel name.
      $container->get('logger.factory')->get('default')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'lastname_check_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['#attached']['library'][] = "lastname_check/custom";
    $form['first_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('First Name'),
      '#required' => TRUE,
    ];
    $form['last_name_present'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Check if lastname not present'),
      '#attributes' => ['id' => 'last-name-present'],
    ];

    $form['last_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Lastname'),
      // '#states' => [
        // 'visible' => [
          // ':input[name="last_name_present"]' => ['checked' => TRUE],
        // ],
      // ],
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->logger->warning('Form submitted');
    $this->logger->notice('new Form  submitted');
    $this->logger->error(' Form submitted!!');
    $messenger = \Drupal::messenger();
    $messenger->addMessage('Form submitted');
  }

}
