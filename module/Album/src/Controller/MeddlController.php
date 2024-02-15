<?php

declare(strict_types=1);

namespace Album\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class MeddlController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }

    public function testAction()
    {
        return new ViewModel();
    }
}
