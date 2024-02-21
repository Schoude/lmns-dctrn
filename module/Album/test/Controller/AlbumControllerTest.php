<?php
namespace AlbumTest\Controller;

use Album\Controller\AlbumController;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class AlbumControllerTest extends AbstractHttpControllerTestCase
{
  protected $traceError = false;

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
  }

  public function testIndexActionCanBeAccessed()
  {
    echo 'testIndexActionCanBeAccessed';
    $this->dispatch('/album');
    $this->assertResponseStatusCode(200);
    $this->assertModuleName('Album');
    $this->assertControllerName(AlbumController::class);
    $this->assertControllerClass('AlbumController');
    $this->assertMatchedRouteName('album');
  }
}
