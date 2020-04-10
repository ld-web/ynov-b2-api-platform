<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class CsvSeparatorSubscriber implements EventSubscriberInterface
{
  public static function getSubscribedEvents()
  {
    return [
      // Je spécifie l'événement sur lequel je me branche en tant que clé
      // En tant que valeur, je lui indique la méthode à exécuter et sa priorité
      // La priorité me servira à contrôler le moment de l'exécution de la méthode
      KernelEvents::VIEW => ['addCsvSeparator', EventPriorities::POST_SERIALIZE]
    ];
  }

  public function addCsvSeparator(ViewEvent $event)
  {
    $request = $event->getRequest();
    $format = $request->attributes->get('_format');

    if ($format !== 'csv') {
      return;
    }

    $content = $event->getControllerResult();
    $content = 'SEP=,' . PHP_EOL . $content;

    $event->setControllerResult($content);
  }
}
