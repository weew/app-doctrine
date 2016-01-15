<?php

namespace Tests\Weew\App\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit_Framework_TestCase;
use Weew\App\App;
use Weew\App\Doctrine\DoctrineProvider;

class DoctrineProviderTest extends PHPUnit_Framework_TestCase {
    protected function createApp() {
        $app = new App();
        $app->loadConfig()->merge([
            'debug' => true,
            'db' => [
                'driver' => 'pdo_sqlite',
                'memory' => true,
                'entities_paths' => []
            ],
        ]);

        $app->getKernel()->addProvider(DoctrineProvider::class);

        return $app;
    }

    public function test_create() {
        $app = $this->createApp();
        $app->run();
    }

    public function test_object_manager_is_shared_in_the_container() {
        $app = $this->createApp();
        $app->start();

        $this->assertTrue(
            $app->getContainer()->get(ObjectManager::class) instanceof ObjectManager
        );

        $this->assertTrue(
            $app->getContainer()->get(EntityManager::class) instanceof EntityManager
        );

        $this->assertTrue(
            $app->getContainer()->get(EntityManagerInterface::class) instanceof EntityManagerInterface
        );
    }
}
