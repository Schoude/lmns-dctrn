<?php

namespace Album\Controller\Factory;

use Album\Controller\AlbumController;
use Album\Service\AlbumManager;
use Interop\Container\Containerinterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class AlbumControllerFactory implements FactoryInterface
{
  public function __invoke(Containerinterface $container, $requestedName, array $options = null)
  {
    $entityManager = $container->get("doctrine.entitymanager.orm_default");
    $albumManager = $container->get(AlbumManager::class);

    return new AlbumController($entityManager, $albumManager);
  }
}
