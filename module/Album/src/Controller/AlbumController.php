<?php

declare(strict_types=1);

namespace Album\Controller;

use Album\Entity\Album;
use Album\Form\AlbumForm;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class AlbumController extends AbstractActionController
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * @var \Album\Service\AlbumManager
     */
    private $albumManager;

    public function __construct($entityManager, $albumManager)
    {
        $this->entityManager = $entityManager;
        $this->albumManager = $albumManager;
    }

    public function indexAction()
    {
        $albums = $this->entityManager->getRepository(Album::class)->findAll();

        return new ViewModel([
            'albums' => $albums
        ]);
    }

    public function addAction()
    {
        $form = new AlbumForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        $album = new Album();
        $form->setInputFilter($album->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        // var_dump($form->getData());
        // die();

        $this->albumManager->addNewAlbum($form->getData());
        return $this->redirect()->toRoute('album');
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('album', ['action' => 'index']);
        }

        $album = $this->entityManager->getRepository(Album::class)->findOneBy(['id' => $id]);

        return new ViewModel([
            'album' => $album,
        ]);
    }

    public function deleteAction()
    {
        return new ViewModel();
    }
}
