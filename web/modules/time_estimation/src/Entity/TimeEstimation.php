<?php

namespace Drupal\time_estimation\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\time_estimation\TimeEstimationInterface;
use Drupal\user\EntityOwnerTrait;

/**
 * Defines the time estimation entity class.
 *
 * @ContentEntityType(
 *   id = "time_estimation",
 *   label = @Translation("Time estimation"),
 *   label_collection = @Translation("Time estimations"),
 *   label_singular = @Translation("time estimation"),
 *   label_plural = @Translation("time estimations"),
 *   label_count = @PluralTranslation(
 *     singular = "@count time estimations",
 *     plural = "@count time estimations",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\time_estimation\TimeEstimationListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "add" = "Drupal\time_estimation\Form\TimeEstimationForm",
 *       "edit" = "Drupal\time_estimation\Form\TimeEstimationForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   base_table = "time_estimation",
 *   admin_permission = "administer time estimation",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *     "owner" = "uid",
 *   },
 *   links = {
 *     "collection" = "/admin/content/time-estimation",
 *     "add-form" = "/time-estimation/add",
 *     "canonical" = "/time-estimation/{time_estimation}",
 *     "edit-form" = "/time-estimation/{time_estimation}/edit",
 *     "delete-form" = "/time-estimation/{time_estimation}/delete",
 *   },
 *   field_ui_base_route = "entity.time_estimation.settings",
 * )
 */
class TimeEstimation extends ContentEntityBase implements TimeEstimationInterface {

  use EntityChangedTrait;
  use EntityOwnerTrait;

  /**
   * {@inheritdoc}
   */
  public function preSave(EntityStorageInterface $storage) {
    parent::preSave($storage);
    if (!$this->getOwnerId()) {
      // If no owner has been set explicitly, make the anonymous user the owner.
      $this->setOwnerId(0);
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['field_id'] = \Drupal\Core\Field\BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t(''))

  ->setDisplayOptions('form', [
      'type' => 'number',
      'weight' => '21',
      'settings' => [
        'placeholder' => '',
      ],
    ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'type' => 'number_integer',
        'weight' => '21',
        'label' => 'above',
        'settings' => [
          'thousand_separator' => '',
          'prefix_suffix' => '1',
        ],
      ])
      ->setDisplayConfigurable('view', TRUE);

$fields['field_task_nr_'] = \Drupal\Core\Field\BaseFieldDefinition::create('text')
  ->setLabel(t('Task nr '))
  ->setDescription(t(''))
  ->setDisplayOptions('form', [
      'type' => 'text_textfield',
      'weight' => '23',
      'settings' => [
        'size' => '60',
        'placeholder' => '',
      ],
    ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'type' => 'text_default',
        'weight' => '23',
        'label' => 'above',
      ])
      ->setDisplayConfigurable('view', TRUE);

$fields['field_timestamp'] = \Drupal\Core\Field\BaseFieldDefinition::create('timestamp')
  ->setLabel(t('Timestamp'))
  ->setDescription(t(''))
  ->setDisplayOptions('form', [
    'type' => 'datetime_timestamp',
    'weight' => '22',
  ])
  ->setDisplayConfigurable('form', TRUE)
  ->setDisplayOptions('view', [
    'type' => 'timestamp',
    'weight' => '22',
    'label' => 'above',
    'settings' => [
      'date_format' => 'short',
      'custom_date_format' => '',
      'timezone' => 'Europe/Tallinn',
    ],
  ])
  ->setDisplayConfigurable('view', TRUE);

$fields['field_code_review'] = \Drupal\Core\Field\BaseFieldDefinition::create('float')
  ->setLabel(t('code review'))
  ->setDescription(t(''))
  ->setDisplayOptions('form', [
      'type' => 'number',
      'weight' => '27',
      'settings' => [
        'placeholder' => '',
      ],
    ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'type' => 'number_decimal',
        'weight' => '27',
        'label' => 'above',
        'settings' => [
          'thousand_separator' => '',
          'decimal_separator' => '.',
          'scale' => '2',
          'prefix_suffix' => '1',
        ],
      ])
      ->setDisplayConfigurable('view', TRUE);

$fields['field_development'] = \Drupal\Core\Field\BaseFieldDefinition::create('float')
  ->setLabel(t('development'))
  ->setDescription(t(''))
  ->setDisplayOptions('form', [
      'type' => 'number',
      'weight' => '25',
      'settings' => [
        'placeholder' => '',
      ],
    ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'type' => 'number_decimal',
        'weight' => '25',
        'label' => 'above',
        'settings' => [
          'thousand_separator' => '',
          'decimal_separator' => '.',
          'scale' => '2',
          'prefix_suffix' => '1',
        ],
      ])
      ->setDisplayConfigurable('view', TRUE);

$fields['field_jira_management'] = \Drupal\Core\Field\BaseFieldDefinition::create('float')
  ->setLabel(t('jira management'))
  ->setDescription(t(''))
  ->setDisplayOptions('form', [
      'type' => 'number',
      'weight' => '28',
      'settings' => [
        'placeholder' => '',
      ],
    ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'type' => 'number_decimal',
        'weight' => '28',
        'label' => 'above',
        'settings' => [
          'thousand_separator' => '',
          'decimal_separator' => '.',
          'scale' => '2',
          'prefix_suffix' => '1',
        ],
      ])
      ->setDisplayConfigurable('view', TRUE);

$fields['field_live_deploy'] = \Drupal\Core\Field\BaseFieldDefinition::create('float')
  ->setLabel(t('live deploy'))
  ->setDescription(t(''))
  ->setDisplayOptions('form', [
      'type' => 'number',
      'weight' => '30',
      'settings' => [
        'placeholder' => '',
      ],
    ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'type' => 'number_decimal',
        'weight' => '30',
        'label' => 'above',
        'settings' => [
          'thousand_separator' => '',
          'decimal_separator' => '.',
          'scale' => '2',
          'prefix_suffix' => '1',
        ],
      ])
      ->setDisplayConfigurable('view', TRUE);

$fields['field_qa_deploy'] = \Drupal\Core\Field\BaseFieldDefinition::create('float')
  ->setLabel(t('qa deploy'))
  ->setDescription(t(''))
  ->setDisplayOptions('form', [
      'type' => 'number',
      'weight' => '29',
      'settings' => [
        'placeholder' => '',
      ],
    ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'type' => 'number_decimal',
        'weight' => '29',
        'label' => 'above',
        'settings' => [
          'thousand_separator' => '',
          'decimal_separator' => '.',
          'scale' => '2',
          'prefix_suffix' => '1',
        ],
      ])
      ->setDisplayConfigurable('view', TRUE);

$fields['field_setup'] = \Drupal\Core\Field\BaseFieldDefinition::create('float')
  ->setLabel(t('setup'))
  ->setDescription(t(''))
  ->setDisplayOptions('form', [
      'type' => 'number',
      'weight' => '24',
      'settings' => [
        'placeholder' => '',
      ],
    ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'type' => 'number_decimal',
        'weight' => '24',
        'label' => 'above',
        'settings' => [
          'thousand_separator' => '',
          'decimal_separator' => '.',
          'scale' => '2',
          'prefix_suffix' => '1',
        ],
      ])
      ->setDisplayConfigurable('view', TRUE);

$fields['field_testing'] = \Drupal\Core\Field\BaseFieldDefinition::create('float')
  ->setLabel(t('testing'))
  ->setDescription(t(''))
  ->setDisplayOptions('form', [
      'type' => 'number',
      'weight' => '26',
      'settings' => [
        'placeholder' => '',
      ],
    ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'type' => 'number_decimal',
        'weight' => '26',
        'label' => 'above',
        'settings' => [
          'thousand_separator' => '',
          'decimal_separator' => '.',
          'scale' => '2',
          'prefix_suffix' => '1',
        ],
      ])
      ->setDisplayConfigurable('view', TRUE);

$fields['field_total'] = \Drupal\Core\Field\BaseFieldDefinition::create('float')
  ->setLabel(t('total'))
  ->setDescription(t(''))
  ->setDisplayOptions('form', [
      'type' => 'number',
      'weight' => '31',
      'settings' => [
        'placeholder' => '',
      ],
    ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'type' => 'number_decimal',
        'weight' => '31',
        'label' => 'above',
        'settings' => [
          'thousand_separator' => '',
          'decimal_separator' => '.',
          'scale' => '2',
          'prefix_suffix' => '1',
        ],
      ])
      ->setDisplayConfigurable('view', TRUE);



    $fields['label'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Label'))
      ->setRequired(TRUE)
      ->setSetting('max_length', 255)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Status'))
      ->setDefaultValue(TRUE)
      ->setSetting('on_label', 'Enabled')
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
        'settings' => [
          'display_label' => FALSE,
        ],
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'type' => 'boolean',
        'label' => 'above',
        'weight' => 0,
        'settings' => [
          'format' => 'enabled-disabled',
        ],
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['description'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Description'))
      ->setDisplayOptions('form', [
        'type' => 'text_textarea',
        'weight' => 10,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'type' => 'text_default',
        'label' => 'above',
        'weight' => 10,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['uid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Author'))
      ->setSetting('target_type', 'user')
      ->setDefaultValueCallback(static::class . '::getDefaultEntityOwner')
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => 60,
          'placeholder' => '',
        ],
        'weight' => 15,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'author',
        'weight' => 15,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Authored on'))
      ->setDescription(t('The time that the time estimation was created.'))
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'timestamp',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('form', [
        'type' => 'datetime_timestamp',
        'weight' => 20,
      ])

      ->setDisplayConfigurable('view', TRUE);





    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the time estimation was last edited.'));

    return $fields;
  }

}
