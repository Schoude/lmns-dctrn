<?php

declare(strict_types=1);

namespace AlbumTest;

use Album\Module;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Application\Module;
 */
class ModuleTest extends TestCase
{
    public function testProvidesConfig(): void
    {
        $module = new Module();
        $config = $module->getConfig();

        self::assertArrayHasKey('controllers', $config);
        self::assertArrayHasKey('service_manager', $config);
        self::assertArrayHasKey('router', $config);
        self::assertArrayHasKey('view_manager', $config);
        self::assertArrayHasKey('doctrine', $config);
    }
}
