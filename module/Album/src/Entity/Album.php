<?php

namespace Album\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\Album\Repository\AlbumRepository")
 * @ORM\Table(name="album")
 */
class Album
{
  /**
   * @ORM\Id
   * @ORM\Column(name="id")
   * @ORM\GeneratedValue
   */
  protected $id;
  /**
   * @ORM\Column(name="artist")
   */
  protected $artist;
  /**
   * @ORM\Column(name="title")
   */
  protected $title;

  public function getId()
  {
    return $this->id;
  }

  public function getArtist()
  {
    return $this->artist;
  }

  public function getTitle()
  {
    return $this->title;
  }

  public function setId($id)
  {
    return $this->id = $id;
  }

  public function setArtist($artist)
  {
    return $this->artist = $artist;
  }

  public function setTitle($title)
  {
    return $this->title = $title;
  }
}
