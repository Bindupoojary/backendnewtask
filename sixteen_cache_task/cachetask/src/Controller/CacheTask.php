<?php

namespace Drupal\cachetask\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Drupal\Core\Cache\Cache;

/**
 * Returns responses for entity_operations routes.
 */
class CacheTask extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build(Node $node) {
    $nid = $node->id();
    $cid = 'markten:' . $nid;

    if ($item = \Drupal::cache()->get($cid)) {
      return $item->data;
    }

    $node = Node::load($nid);
    $title = $node->getTitle();
    $markten = [
      '#markup' => $title,

    ];

    \Drupal::cache()->set($cid, $markten, Cache::PERMANENT, $node->getCacheTags());

    return $markten;
  }

}
