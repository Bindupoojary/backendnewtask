<?php

namespace Drupal\reference\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

/**
 * Returns responses for demo routes.
 */
class ReferenceNew extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build($nodeId) {
    $node = Node::load($nodeId);
    $node_title = $node->getTitle();
    $term = $node->get('field_colors')->entity;
    $term_name = $term->getName();
    $user = $term->get('field_user')->entity->getDisplayName();
    return [
      '#markup' => $node_title . $term_name . $user,
    ];
  }

}
