<?php

/**
 * @file
 * Contains \Drupal\read_more_formatter\Plugin\Field\FieldFormatter\ReadMoreFormatter.
 */

namespace Drupal\read_more_formatter\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;

/**
 * Plugin implementation of the 'read_more_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "read_more_formatter",
 *   label = @Translation("Read more"),
 *   field_types = {
 *     "text_with_summary"
 *   },
 *   settings = {
 *     "expand_name" = "Read more",
 *     "collapse_name" = "Read less",
 *     "expand_class" = "",
 *     "collapse_class" = "",
 *     "use_text_summary_delimiter" = FALSE
 *   }
 * )
 */
class ReadMoreFormatter extends FormatterBase {

    /**
     * {@inheritdoc}
     */
    public static function defaultSettings() {
        return array(
          'expand_name' => t('Read more'),
          'collapse_name' => t('Read less'),
          'expand_class' => '',
          'collapse_class' => '',
          'use_text_summary_delimiter' => FALSE,
            ) + parent::defaultSettings();
    }

    /**
     * {@inheritdoc}
     */
    public function settingsForm(array $form, FormStateInterface $form_state) {
        $element = parent::settingsForm($form, $form_state);

        $element['expand_name'] = array(
          '#title' => t('Expand button name'),
          '#type' => 'textfield',
          '#size' => 20,
          '#default_value' => $this->getSetting('expand_name'),
          '#required' => TRUE,
        );

        $element['collapse_name'] = array(
          '#title' => t('Collapse button name'),
          '#type' => 'textfield',
          '#size' => 20,
          '#default_value' => $this->getSetting('collapse_name'),
          '#required' => TRUE,
        );

        $element['expand_class'] = array(
          '#title' => t('Expand button class'),
          '#type' => 'textfield',
          '#size' => 20,
          '#default_value' => $this->getSetting('expand_class'),
        );

        $element['collapse_class'] = array(
          '#title' => t('Collapse button class'),
          '#type' => 'textfield',
          '#size' => 20,
          '#default_value' => $this->getSetting('collapse_class'),
        );

        $element['use_text_summary_delimiter'] = array(
          '#title' => t("Use text summary delimiter @delimiter", array('@delimiter' => '<!--break-->')),
          '#description' => t('If checked then all the text above the delimiter will be treated as summary. <br/> Otherwise text from "summary" field will be used.'),
          '#type' => 'checkbox',
          '#default_value' => $this->getSetting('use_text_summary_delimiter'),
        );

        return $element;
    }

    /**
     * {@inheritdoc}
     */
    public function settingsSummary() {
        $summary = array();

        $summary[] = t('Expand button name: @name', array('@name' => $this->getSetting('expand_name')));
        $summary[] = t('Collapse button name: @name', array('@name' => $this->getSetting('collapse_name')));
        $summary[] = t('Expand button class: @name', array('@name' => $this->getSetting('expand_class')));
        $summary[] = t('Collapse button class: @name', array('@name' => $this->getSetting('collapse_class')));
        $summary[] = t('Using delimiter: @setting', array('@setting' => $this->getSetting('use_text_summary_delimiter') ? 'Yes' : 'No'));


        return $summary;
    }

    /**
     * {@inheritdoc}
     */
    public function viewElements(FieldItemListInterface $items, $langcode) {

        $entity = $items->getEntity();

        $uri = $entity->toUrl();
        $expand_link_name = $this->getSetting('expand_name');
        $collapse_link_name = $this->getSetting('collapse_name');

        $expand_link = Link::fromTextAndUrl($expand_link_name, $uri);
        $collapse_link = Link::fromTextAndUrl($collapse_link_name, $uri);

        $expand_link = $expand_link->toRenderable();
        $expand_link['#attributes'] = array(
          'class' => array(
            'expand-link',
            $this->getSetting('expand_class'),
          ),
        );

        $collapse_link = $collapse_link->toRenderable();
        $collapse_link['#attributes'] = array(
          'class' => array(
            'collapse-link',
            $this->getSetting('collapse_class'),
          ),
        );


        $elements = array();

        foreach ($items as $delta => $item) {
            $elements[$delta] = array(
              '#theme' => 'read_more_formatter',
              '#full_text' => $item->value,
              '#summary' => $this->getSetting('use_text_summary_delimiter') ? text_summary($item->value) : $item->summary,
              '#expand_link' => $expand_link,
              '#collapse_link' => $collapse_link,
            );
        }
        $elements['#attached']['library'][] = 'read_more_formatter/read_more_formatter.default';

        return $elements;
    }

}
