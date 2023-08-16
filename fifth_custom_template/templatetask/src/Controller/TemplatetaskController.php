<?php

namespace Drupal\templatetask\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for template_task routes.
 */
class TemplatetaskController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {
    $config = $this->config('templatetask.settings');
    $title = $config->get('title');
    $text = $config->get('text')['value'];
    $text_value = strip_tags($text);
    $color = $config->get('color');

    return [
      '#theme' => 'templatetask_new',
      '#text' => $text_value,
      '#title' => $title,
      '#color' => $color,
    ];
  }

}
