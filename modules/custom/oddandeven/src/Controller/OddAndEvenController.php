<?php
/**
 * @file
 * Does something
 */

namespace Drupal\oddandeven\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\PageCache\ResponsePolicy\KillSwitch;
use Drupal\node\Entity\Node;
use Drupal\oddandeven\NumberServiceInterface;
use Drupal\oddandeven\TimeServiceInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class OddAndEvenController extends ControllerBase {

  public function __construct(
    protected readonly NumberServiceInterface $numberService,
    protected readonly TimeServiceInterface   $timeService,
    protected readonly KillSwitch             $killSwitch
  ) {
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('oddandeven.number_service'),
      $container->get('oddandeven.time_service'),
      $container->get('page_cache_kill_switch')
    );
  }

  public function checkMinute(): array {
    $this->killSwitch->trigger();

    $timeInMinutes = $this->timeService->getCurrentMinute();

    $oddOrEven = $this->numberService->checkNumberProperty('odd', $timeInMinutes) ? 'odd' : 'even';
    $resultString = t('Current minute is @oddOrEven', ['@oddOrEven' => $oddOrEven]);

    $nodeId = $oddOrEven === 'odd' ? 1 : 2;
    $node = Node::load($nodeId);

    $render_controller = \Drupal::entityTypeManager()
      ->getViewBuilder($node->getEntityTypeId());
    $render_node = $render_controller->view($node, 'teaser_prt_mdm_a');
    $node_markup = render($render_node);

    return [
      '#type' => 'markup',
      '#markup' => $resultString . $node_markup,
    ];
  }

}
