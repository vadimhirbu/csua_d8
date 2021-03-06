<?php

/**
 * @file
 * Contains \Drupal\aggregator\AggregatorItemViewsData.
 */

namespace Drupal\aggregator;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides the views data for the aggregator item entity type.
 */
class AggregatorItemViewsData extends EntityViewsData implements EntityViewsDataInterface {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['aggregator_item']['table']['base']['help'] = $this->t('Aggregator items are imported from external RSS and Atom news feeds.');


    $data['aggregator_item']['iid']['help'] = $this->t('The unique ID of the aggregator item.');
    $data['aggregator_item']['iid']['argument']['id'] = 'aggregator_iid';
    $data['aggregator_item']['iid']['argument']['name field'] = 'title';
    $data['aggregator_item']['iid']['argument']['numeric'] = TRUE;

    $data['aggregator_item']['title']['help'] = $this->t('The title of the aggregator item.');
    $data['aggregator_item']['title']['field']['id'] = 'aggregator_title_link';
    $data['aggregator_item']['title']['field']['extra'] = 'link';

    $data['aggregator_item']['link']['help'] = $this->t('The link to the original source URL of the item.');

    $data['aggregator_item']['author']['help'] = $this->t('The author of the original imported item.');
    $data['aggregator_item']['author']['field']['id'] = 'aggregator_xss';

    $data['aggregator_item']['guid']['help'] = $this->t('The guid of the original imported item.');

    $data['aggregator_item']['description']['help'] = $this->t('The actual content of the imported item.');
    $data['aggregator_item']['description']['field']['id'] = 'aggregator_xss';
    $data['aggregator_item']['description']['field']['click sortable'] = FALSE;

    $data['aggregator_item']['timestamp']['help'] = $this->t('The date the original feed item was posted. (With some feeds, this will be the date it was imported.)');

    return $data;
  }

}

