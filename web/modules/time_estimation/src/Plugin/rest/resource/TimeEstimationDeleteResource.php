<?php

namespace Drupal\time_estimation\Plugin\rest\resource;

use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Http\RequestStack;
use Drupal\Core\Session\AccountProxy;
use Drupal\rest\Plugin\ResourceBase;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Provides a resource to get view modes by entity and bundle.
 *
 * @RestResource(
 *   id = "time_estimation_delete",
 *   label = @Translation("Time estimation delete"),
 *   uri_paths = {
 *     "canonical" = "/api/time-estimation/delete/{id}",
 *   }
 * )
 */
class TimeEstimationDeleteResource extends ResourceBase {

  /**
   * @var \Drupal\Core\Entity\EntityStorageInterface|mixed|object
   */
  private $availableTimesStorage;

  private ?\Symfony\Component\HttpFoundation\Request $request;

  public function __construct(
    array $configuration,
    string $plugin_id,
    $plugin_definition,
    array $serializer_formats,
    LoggerInterface $logger,
    AccountProxy $accountProxy,
    EntityTypeManager $entityTypeManager,
    RequestStack $requestStack
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $serializer_formats, $logger);
    $this->currentUser = $accountProxy;
    $this->availableTimesStorage = $entityTypeManager->getStorage('time_estimation');
    $this->request = $requestStack->getCurrentRequest();
  }

  /**
   * A current user instance.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->getParameter('serializer.formats'),
      $container->get('logger.factory')->get('rest'),
      $container->get('current_user'),
      $container->get('entity_type.manager'),
      $container->get('request_stack')
    );
  }


  /**
   * @return \Symfony\Component\HttpFoundation\Response
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function delete() {
    // You must to implement the logic of your REST Resource here.
    // Use current user after pass authentication to validate access.
    if (!$this->currentUser->hasPermission('access content')) {

      throw new AccessDeniedHttpException();
    }


    $returnText = $this->deleteEstimation() ? $this->t('Time estimation has been deleted.') :
      $this->t('Unable to delete time estimation.');


    return new Response($returnText);
  }

  /**
   * @return bool
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  protected function deleteEstimation(): bool {
    $availableTimesEntityId = $this->request->get('time_estimation');

    if (!empty($availableTimesEntityId)) {
      $availableTimesEntity = $this->availableTimesStorage->load($availableTimesEntityId);

      if ($availableTimesEntity) {
        $availableTimesEntity->delete();

        return TRUE;
      }
    }

    return FALSE;
  }

}
