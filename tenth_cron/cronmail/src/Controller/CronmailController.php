<?php

namespace Drupal\cronmail\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for cronmail routes.
 */
class CronmailController extends ControllerBase {

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
