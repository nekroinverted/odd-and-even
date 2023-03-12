<?php

namespace Drupal\oddandeven;

class NumberService implements NumberServiceInterface {

  const OPTION_ODD = 'odd';

  const OPTION_EVEN = 'even';

  const OPTIONS = [self::OPTION_ODD, self::OPTION_EVEN];

  /**
   * @inheritDoc
   */
  public function checkNumberProperty(string $property, int $number): ?bool {
    if (!in_array($property, self::OPTIONS)) {
      return NULL;
    }

    $methodName = 'isNumber' . ucfirst($property);

    if (!method_exists($this, $methodName)) {
      return NULL;
    }

    return $this->$methodName($number);
  }

  private function isNumberOdd(int $number): bool {
    return $number % 2 !== 0;
  }

  private function isNumberEven(int $number): bool {
    return $number % 2 === 0;
  }

}
