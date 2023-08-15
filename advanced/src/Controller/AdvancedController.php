<?php

namespace Drupal\advanced\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for advanced routes.
 */
class AdvancedController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    return $build;
  }

}
