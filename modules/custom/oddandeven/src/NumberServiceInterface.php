<?php
namespace Drupal\oddandeven;
interface NumberServiceInterface {
  /**
   * Check if number is of some property.
   *
   * @return bool
   *   Currently supported, check if number is odd or even
   */
  public function checkNumberProperty(string $property,int $number): ?bool;
}
