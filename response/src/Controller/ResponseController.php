<?php

namespace Drupal\response\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for response routes.
 */
class ResponseController extends ControllerBase {

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
