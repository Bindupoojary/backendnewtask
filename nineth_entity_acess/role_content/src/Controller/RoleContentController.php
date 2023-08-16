<?php

namespace Drupal\role_content\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for role_content routes.
 */
class RoleContentController extends ControllerBase {

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
