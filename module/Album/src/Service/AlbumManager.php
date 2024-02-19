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

  public function addNewAlbum($data)
  {
    $album = new Album();
    $album->setTitle($data["title"]);
    $album->setArtist($data["artist"]);

    $this->entityManager->persist($album);
    $this->entityManager->flush();
  }

  public function updateAlbum($album, $data)
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
