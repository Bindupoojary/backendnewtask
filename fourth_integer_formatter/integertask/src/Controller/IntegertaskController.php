<?php

namespace Drupal\integertask\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for integertask routes.
 */
class IntegertaskController extends ControllerBase {

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
