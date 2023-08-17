<?php

namespace Drupal\demo\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
// Import the interface for the missing service.
use Drupal\Core\Entity\EntityDisplayRepositoryInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;

/**
 * Provides an example block.
 *
 * @Block(
 *   id = "demo_example",
 *   admin_label = @Translation("Example"),
 *   category = @Translation("demo")
 * )
 */
class ExampleBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The config factory service.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The entity display repository service.
   *
   * @var \Drupal\Core\Entity\EntityDisplayRepositoryInterface
   */
  protected $entityDisplayRepository;

  /**
   * Constructs a new ExampleBlock instance.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory service.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Core\Entity\EntityDisplayRepositoryInterface $entity_display_repository
   *   The entity display repository service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigFactoryInterface $config_factory, EntityTypeManagerInterface $entity_type_manager, EntityDisplayRepositoryInterface $entity_display_repository) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->configFactory = $config_factory;
    $this->entityTypeManager = $entity_type_manager;
    // Store the service in the property.
    $this->entityDisplayRepository = $entity_display_repository;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory'),
      $container->get('entity_type.manager'),
    // Add this line to inject the missing service.
      $container->get('entity_display.repository')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'example' => '',
    // Set the default view mode to 'teaser'.
      'view_mode' => 'teaser',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['example'] = [
      '#type' => 'entity_autocomplete',
      '#title' => 'Example',
      '#target_type' => 'node',
    ];

    // Change this to the desired entity type ID.
    $entity_type_id = 'node';

    // Get available view modes for the entity type.
    $view_modes = $this->entityDisplayRepository->getViewModes($entity_type_id);

    $options = [];
    foreach ($view_modes as $view_mode => $info) {
      $options[$view_mode] = $info['label'];
    }

    $form['view_mode'] = [
      '#type' => 'radios',
      '#title' => $this->t('View Mode'),
      '#options' => $options,
      '#default_value' => $this->configuration['view_mode'],

    ];

    if (!empty($this->configuration['example'])) {
      $form['example']['#default_value'] = Node::load($this->configuration['example']);
    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['example'] = $form_state->getValue('example');
    $this->configuration['view_mode'] = $form_state->getValue('view_mode');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $node_id = $this->configuration['example'];
    $view_mode = $this->configuration['view_mode'];

    $node = $this->entityTypeManager->getStorage('node')->load($node_id);
    $build = [];
    if ($node) {
      $view_builder = $this->entityTypeManager->getViewBuilder('node');
      $build = $view_builder->view($node, $view_mode);
    }
    return $build;
  }

}
