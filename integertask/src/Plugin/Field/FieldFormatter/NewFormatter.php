<?php

namespace Drupal\integertask\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'new_integer_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "new_integer_formatter",
 *   label = @Translation("New Integer Formatter"),
 *   field_types = {
 *     "integer"
 *   }
 * )
 */
class NewFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    foreach ($items as $delta => $item) {
      // Get the integer value from the field item.
      $integer_value = $item->value;

      // Divide the integer value by 100.
      $output = $integer_value / 100;

      // Create the output inside a <p> tag.
      $elements[$delta] = [
        '#markup' => '<p>' . $output . '</p>',
      ];
    }
    return $elements;
  }
}
