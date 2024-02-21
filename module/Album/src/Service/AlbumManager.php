<?php

namespace Album\Service;

use Album\Entity\Album;

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

  public function findAll()
  {
    return $this->entityManager
      ->getRepository(Album::class)
      ->findAll() ?? [];
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
