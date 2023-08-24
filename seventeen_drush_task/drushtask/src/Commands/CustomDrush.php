<?php

namespace Drupal\drushtask\Commands;

use Drush\Commands\DrushCommands;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\State\StateInterface;

/**
 * Drush command.
 */
class CustomDrush extends DrushCommands {

  /**
   * The messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * The state service.
   *
   * @var \Drupal\Core\State\StateInterface
   */
  protected $state;

  /**
   * Constructor for the CustomDrush class.
   *
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger service.
   * @param \Drupal\Core\State\StateInterface $state
   *   The state service.
   */
  public function __construct(MessengerInterface $messenger, StateInterface $state) {
    $this->messenger = $messenger;
    $this->state = $state;
  }

  /**
   * Put the site into maintenance mode.
   *
   * @command site-maintenance:enable
   * @aliases sme
   * @usage drush site-maintenance:enable
   */
  public function enableMaintenance() {
    $this->state->set('system.maintenance_mode', TRUE);
    $this->messenger->addStatus('Site is now in maintenance mode.');
  }

  /**
   * Take the site out of maintenance mode.
   *
   * @command site-maintenance:disable
   * @aliases smd
   * @usage drush site-maintenance:disable
   */
  public function disableMaintenance() {
    $this->state->set('system.maintenance_mode', FALSE);
    $this->messenger->addStatus('Site is no longer in maintenance mode.');
  }

}
