<?php

namespace Drupal\oddandeven;

interface TimeServiceInterface {
  public function getCurrentMinute(): int;
}
