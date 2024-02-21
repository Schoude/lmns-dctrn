<?php
namespace AlbumTest\Controller;

use Album\Entity\Album;
use Album\Service\AlbumManager;
use Album\Controller\AlbumController;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Laminas\ServiceManager\ServiceManager;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

class AlbumControllerTest extends AbstractHttpControllerTestCase
{
  use ProphecyTrait;

  protected $traceError = false;

  protected $albumManager;

  protected function configureServiceManager(ServiceManager $services)
  {
    $services->setAllowOverride(true);

    // Add mocked AlbumManager service
    $services->setService(AlbumManager::class, $this->mockAlbumManager()->reveal());

    $services->setAllowOverride(false);
  }

  protected function mockAlbumManager()
  {
    $this->albumManager = $this->prophesize(AlbumManager::class);
    return $this->albumManager;
  }

  protected function setUp(): void
  {
    // The module configuration should still be applicable for tests.
    // You can override configuration here with test case specific values,
    // such as sample view templates, path stacks, module_listener_options,
    // etc.
    $configOverrides = [];

    $this->setApplicationConfig(
      ArrayUtils::merge(
        // Grabbing the full application configuration:
        include __DIR__ . '/../../../../config/application.config.php',
        $configOverrides
      )
    );

    parent::setUp();

    $this->configureServiceManager($this->getApplicationServiceLocator());
  }

  public function testIndexActionCanBeAccessed()
  {
    // Mocked album manager with stubbed function findAll
    $this->albumManager->findAll()->willReturn([]);

    $this->dispatch('/album');
    $this->assertResponseStatusCode(200);
    $this->assertModuleName('Album');
    $this->assertControllerName(AlbumController::class);
    $this->assertControllerClass('AlbumController');
    $this->assertMatchedRouteName('album');
  }

  public function testAddActionRedirectsAfterValidPost()
  {
    $this->albumManager
      ->addNewAlbum(Argument::type('array'))
      ->shouldBeCalled();

    $postData = [
      'title' => 'Led Zeppelin III',
      'artist' => 'Led Zeppelin',
      'id' => '',
    ];

    $this->dispatch('/album/add', 'POST', $postData);
    $this->assertResponseStatusCode(302);
    $this->assertRedirectTo('/album');
  }

  public function testDeleteActionRedirectsAfterPositiveConfirmation()
  {
    $this->albumManager
      ->findById(Argument::type('int'))
      ->willReturn(new Album());

    $this->albumManager
      ->deleteAlbum(Argument::type(Album::class))
      ->shouldBeCalled();

    $postData = [
      'del' => 'Yes',
    ];

    $this->dispatch('/album/delete/1', 'POST', $postData);
    $this->assertResponseStatusCode(302);
    $this->assertRedirectTo('/album');
  }

  public function testDeleteActionRedirectsAfterNegativeConfirmation()
  {
    $this->albumManager
      ->findById(Argument::type('int'))
      ->willReturn(new Album());

    $this->albumManager
      ->deleteAlbum(Argument::type(Album::class))
      ->shouldNotBeCalled();

    $postData = [
      'del' => 'No',
    ];

    $this->dispatch('/album/delete/1', 'POST', $postData);
    $this->assertResponseStatusCode(302);
    $this->assertRedirectTo('/album');
  }
}
