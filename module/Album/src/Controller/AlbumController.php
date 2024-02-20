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

        $this->albumManager->addNewAlbum($form->getData());
        return $this->redirect()->toRoute('album');
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('album', ['action' => 'index']);
        }

        try {
            /** @var Album $album */
            $album = $this->entityManager->getRepository(Album::class)->findOneBy(['id' => $id]);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('album', ['action' => 'index']);
        }

        $form = new AlbumForm();
        $form->bind($album);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (!$request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($album->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return $viewData;
        }

        try {
            $this->albumManager->updateAlbum($album, [
                'title' => $request->getPost('title'),
                'artist' => $request->getPost('artist'),
            ]);
        } catch (\Exception $e) {
        }

        // Redirect to album list
        return $this->redirect()->toRoute('album', ['action' => 'index']);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('album');
        }

        $album = $this->entityManager->getRepository(Album::class)->findOneBy(['id' => $id]);

        $request = $this->getRequest();

        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->albumManager->deleteAlbum($album);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('album');
        }

        return [
            'id' => $id,
            'album' => $album,
        ];
    }
}
