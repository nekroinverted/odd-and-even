<?php

namespace Drupal\oddandeven;

class TimeService implements TimeServiceInterface {

  public function getCurrentMinute(): int {
    $currentTime = \Drupal::time()->getCurrentTime();
    return (int) \Drupal::service('date.formatter')
      ->format($currentTime, 'custom', 'i');
  }

}
