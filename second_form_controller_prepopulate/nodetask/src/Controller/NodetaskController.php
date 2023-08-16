<?php

namespace Drupal\nodetask\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Undocumented class.
 */
class NodetaskController extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static($container->get('entity_type.manager'));
  }

  /**
   * Displays the form for node details.
   */
  public function build($node) {
    $form = \Drupal::formBuilder()->getForm('\Drupal\demo\Form\NodeDetails', $node);
    return $form;

  }

}
