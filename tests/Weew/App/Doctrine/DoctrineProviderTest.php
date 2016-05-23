<?php

namespace Tests\Weew\App\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit_Framework_TestCase;
use RuntimeException;
use Tests\Weew\App\Doctrine\Util\AppFactory;
use Tests\Weew\App\Doctrine\Util\FakeDoctrineConfig;
use Weew\App\Doctrine\DoctrineProvider;


class DoctrineProviderTest extends PHPUnit_Framework_TestCase {
    public function test_create() {
        $factory = new AppFactory();
        $factory->createApp('annotations')->run();
        $factory->createApp('yaml')->run();
    }

    public function test_provider_throws_error_if_doctrine_configuration_cant_be_created() {
        $provider = new DoctrineProvider();
        $config = new FakeDoctrineConfig();
        $this->setExpectedException(RuntimeException::class);
        $provider->createEntityManager(new $config);
    }

    public function test_object_manager_is_shared_in_the_container() {
        $factory = new AppFactory();
        $app = $factory->createApp();
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
