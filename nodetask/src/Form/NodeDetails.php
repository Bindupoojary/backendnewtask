<?php

namespace Drupal\response\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Undocumented class.
 */
class NodeDetails extends FormBase {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * Constructs a new NodeDetailsForm object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger service.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, MessengerInterface $messenger) {
    $this->entityTypeManager = $entity_type_manager;
    $this->messenger = $messenger;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager'),
      $container->get('messenger')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_node_details_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $node = NULL) {
    // Get the node and current user.
    $node_title = $node ? $node->getTitle() : '';
    $user = \Drupal::currentUser();

    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#default_value' => $node_title,
      '#required' => TRUE,
    ];
    $form['user'] = [
      '#type' => 'entity_autocomplete',
      '#title' => $this->t('User'),
      '#target_type' => 'user',
      '#default_value' => $this->entityTypeManager->getStorage('user')->load($user->id()),
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Submit',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Get the form values.
    $node_title = $form_state->getValue('title');
    $user_id = $form_state->getValue('user');

    // Save the data in the custom table.
    $data = [
      'node_title' => $node_title,
      'user_id' => $user_id,
    ];
    $this->entityTypeManager->getStorage('custom_node_data')->insert($data)->execute();

    // Show a message to the user.
    $this->messenger->addStatus($this->t('Form data saved successfully.'));
  }

}
