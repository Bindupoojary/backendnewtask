<?php

namespace Drupal\moduletask\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Returns responses for moduletask routes.
 */
class ModuletaskController extends ControllerBase {
  /**
   * Database.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * Constructor.
   *
   * @param \Drupal\Core\Database\Connection $database
   */
  public function __construct(Connection $database) {
    $this->database = $database;
  }

  /**
   * @inhertdoc
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database')
    );

  }

  /**
   * Builds the response.
   */
  public function build() {
    $query = $this->database->select('moduletask_new', 'mn')
      ->fields('mn')
      ->execute();

    $rows = [];
    foreach ($query as $row) {
      $rows[] = [
        'first_name' => $row->first_name,
        'last_name' => $row->last_name,
        'email' => $row->email,
        'phone_number' => $row->phone_number,
        'gender' => $row->gender,

      ];
    }

    $build = [
      '#theme' => 'table_new',
      '#rows' => $rows,
    ];
    return $build;

  }

}
