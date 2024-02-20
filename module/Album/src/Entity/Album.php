<?php

namespace Album\Entity;

use Doctrine\ORM\Mapping as ORM;
use DomainException;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Filter\ToInt;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Validator\StringLength;

/**
 * @ORM\Entity(repositoryClass="\Album\Repository\AlbumRepository")
 * @ORM\Table(name="album")
 */
class Album implements InputFilterAwareInterface
{
  private $inputFilter;

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

  public function setInputFilter(InputFilterInterface $inputFilter)
  {
    throw new DomainException(
      sprintf(
        '%s does not allow injection of an alternate input filter',
        __CLASS__
      )
    );
  }

  public function getInputFilter()
  {
    if ($this->inputFilter) {
      return $this->inputFilter;
    }

    $inputFilter = new InputFilter();

    $inputFilter->add([
      'name' => 'id',
      'required' => true,
      'filters' => [
        ['name' => ToInt::class],
      ],
    ]);

    $inputFilter->add([
      'name' => 'artist',
      'required' => true,
      'filters' => [
        ['name' => StripTags::class],
        ['name' => StringTrim::class],
      ],
      'validators' => [
        [
          'name' => StringLength::class,
          'options' => [
            'encoding' => 'UTF-8',
            'min' => 1,
            'max' => 100,
          ],
        ],
      ],
    ]);

    $inputFilter->add([
      'name' => 'title',
      'required' => true,
      'filters' => [
        ['name' => StripTags::class],
        ['name' => StringTrim::class],
      ],
      'validators' => [
        [
          'name' => StringLength::class,
          'options' => [
            'encoding' => 'UTF-8',
            'min' => 1,
            'max' => 100,
          ],
        ],
      ],
    ]);

    $this->inputFilter = $inputFilter;
    return $this->inputFilter;
  }

  public function exchangeArray($data)
  {
    $this->id = isset($data['id']) ? $data['id'] : null;
    $this->artist = isset($data['artist']) ? $data['artist'] : null;
    $this->title = isset($data['title']) ? $data['title'] : null;
  }

  public function getArrayCopy()
  {
    return [
      'id' => $this->id,
      'artist' => $this->artist,
      'title' => $this->title,
    ];
  }
}
