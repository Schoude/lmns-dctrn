<?php

namespace Album\Service;

use Album\Entity\Album;
use DoctrineModule\Paginator\Adapter\Selectable as SelectableAdapter;
use Laminas\Paginator\Paginator;

class AlbumManager
{
  /**
   * @var \Doctrine\ORM\EntityManager
   */
  private $entityManager;

  public function __construct($entityManager)
  {
    $this->entityManager = $entityManager;
  }

  public function findAll(bool $paginated = false)
  {
    if ($paginated) {
      return $this->fetchPaginatedResults();
    }

    return $this->entityManager
      ->getRepository(Album::class)
      ->findAll() ?? [];
  }

  private function fetchPaginatedResults()
  {
    // There are two ways to create paginated results with doctrine

    // 1) With a collection adapter -> this need a DoctrineCollection with already fetched resulsts
    // Create a Doctrine 2 Collection
    // $doctrineCollection = new ArrayCollection($results);

    // Create the adapter
    // $adapter = new CollectionAdapter($doctrineCollection);

    // 2) With the selectable adapter
    // This works with the Entity repository
    $objectRepository = $this->entityManager
      ->getRepository(Album::class);
    $adapter = new SelectableAdapter($objectRepository);

    // Create the paginator itself
    $paginator = new Paginator($adapter);
    $paginator->setCurrentPageNumber(1)
      ->setItemCountPerPage(5);

    return $paginator;
  }

  public function findById($id)
  {
    return $this->entityManager->getRepository(Album::class)->findOneBy(['id' => $id]);
  }

  public function addNewAlbum(array $data)
  {
    $album = new Album();
    $album->setTitle($data["title"]);
    $album->setArtist($data["artist"]);

    $this->entityManager->persist($album);
    $this->entityManager->flush();
  }

  public function updateAlbum(Album $album, $data)
  {
    $album->setTitle($data["title"]);
    $album->setArtist($data["artist"]);

    $this->entityManager->flush();
  }

  public function deleteAlbum($album)
  {
    $this->entityManager->remove($album);
    $this->entityManager->flush();
  }
}
