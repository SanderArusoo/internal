<?php

namespace Drupal\time_estimation;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a time estimation entity type.
 */
interface TimeEstimationInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
