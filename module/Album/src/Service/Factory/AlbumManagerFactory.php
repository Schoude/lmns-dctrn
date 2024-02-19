<?php

namespace Album\Service\Factory;

use Album\Service\AlbumManager;
use Interop\Container\ContainerInterface;

class AlbumManagerFactory
{
  public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
  {
    $entityManager = $container->get("doctrine.entitymanager.orm_default");

    return new AlbumManager($entityManager);
  }
}
