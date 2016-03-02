<?php

namespace Tests\Weew\App\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit_Framework_TestCase;
use Tests\Weew\App\Doctrine\Util\AppFactory;

class DoctrineProviderTest extends PHPUnit_Framework_TestCase {
    protected function createApp() {
        $factory = new AppFactory();

        return $factory->createApp();
    }

    public function test_create() {
        $this->createApp()->run();
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
