<?php

namespace Drupal\reference\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

/**
 * Returns responses for demo routes.
 */
class ReferenceController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {
    $nodeId = 1;
    $node = Node::load($nodeId);
    $title = $node->getTitle();
    if ($node->hasField('field_colors')) {
      $term = $node->get('field_colors')->referencedEntities()[0];
      $colors = $term->getName();
    }
    if ($term->hasField('field_user')) {
      $user = $term->get('field_user')->referencedEntities()[0];
      $users = $user->getDisplayName();
    }
    $content = $title . '.' . $colors . '.' . $users;
    return [
      '#markup' => $content,
    ];
  }

}
