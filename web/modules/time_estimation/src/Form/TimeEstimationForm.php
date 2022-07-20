<?php

namespace Drupal\time_estimation\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the time estimation entity edit forms.
 */
class TimeEstimationForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $result = parent::save($form, $form_state);

    $entity = $this->getEntity();

    $message_arguments = ['%label' => $entity->toLink()->toString()];
    $logger_arguments = [
      '%label' => $entity->label(),
      'link' => $entity->toLink($this->t('View'))->toString(),
    ];

    switch ($result) {
      case SAVED_NEW:
        $this->messenger()->addStatus($this->t('New time estimation %label has been created.', $message_arguments));
        $this->logger('time_estimation')->notice('Created new time estimation %label', $logger_arguments);
        break;

      case SAVED_UPDATED:
        $this->messenger()->addStatus($this->t('The time estimation %label has been updated.', $message_arguments));
        $this->logger('time_estimation')->notice('Updated time estimation %label.', $logger_arguments);
        break;
    }

    $form_state->setRedirect('entity.time_estimation.canonical', ['time_estimation' => $entity->id()]);

    return $result;
  }

}
