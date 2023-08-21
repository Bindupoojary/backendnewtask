<?php

namespace Drupal\entity_operations\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for entity_operations routes.
 */
class EntityOperationsController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build($node) {

    return [
      '#markup' => $node->getTitle(),
    ];
  }

}
