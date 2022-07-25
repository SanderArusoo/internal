<?php

namespace Drupal\time_estimation\Plugin\rest\resource;


use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Http\RequestStack;
use Drupal\Core\Session\AccountProxy;
use Drupal\datetime\Plugin\Field\FieldType\DateTimeItemInterface;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use phpDocumentor\Reflection\Types\Boolean;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;




/**
 *  Provides a resource to get view modes by entity and bundle.
 *
 * @RestResource (
 *   id = "time_estimation_post",
 *   label = @Translation("Time estimation post"),
 *   uri_paths = {
 *     "canonical" = "/api/time-estimation/post",
 *   }
 * )
 */

class TimeEstimationPostResource extends ResourceBase
{
  /**
   * @var \Drupal\Core\Entity\EntityStorageInterface|mixed|object
   */
  private $availableTimesStorage;

  private ?\Symfony\Component\HttpFoundation\Request $request;

  public function __construct(
    array             $configuration,
    string            $plugin_id,
                      $plugin_definition,
    array             $serializer_formats,
    LoggerInterface   $logger,
    AccountProxy      $accountProxy,
    EntityTypeManager $entityTypeManager,
    RequestStack      $requestStack
  )
  {
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
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
  {
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
   * Responds to PUT requests.
   *
   * @return \Drupal\rest\ResourceResponse
   *   The HTTP response object.
   *
   * @throws \Symfony\Component\HttpKernel\Exception\HttpException
   *   Throws exception expected.
   */
  public function put()
  {
    // You must to implement the logic of your REST Resource here.
    // Use current user after pass authentication to validate access.
    if (!$this->currentUser->hasPermission('access content')) {
      throw new AccessDeniedHttpException();
    }

    $text = $this->createTodoItem() ? 'Item created' : 'No item created';

  //  return new Response($text);
  }

  /**
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  protected function createTodoItem(): bool
  {
    $postData = $this->request->getContent();

    if (!empty($postData)) {
      $postDataDecoded = json_decode($postData);
//      var_dump($postDataDecoded);
      if (!empty($postDataDecoded->task)) {
//        $dateTime = NULL;
//
//        if (!empty($postDataDecoded->due_date)) {
//          $dateTime = DrupalDateTime::createFromFormat('Y-m-d H:i:s', $postDataDecoded->due_date);
//          $dateTime->setTimezone(new \DateTimeZone(DateTimeItemInterface::STORAGE_TIMEZONE));
//          $dateTime = $dateTime->format(DateTimeItemInterface::DATETIME_STORAGE_FORMAT);


        $availableTimesEntity = $this->availableTimesStorage->create([
//
         'field_task_nr_' => $postDataDecoded->task,
          'label'=> $postDataDecoded->label,




//          'field_timestamp'=> $postDataDecoded->timestamp



        ]);

        $availableTimesEntity->save();

        return TRUE;
      }
    }
      return FALSE;
    }
  }

