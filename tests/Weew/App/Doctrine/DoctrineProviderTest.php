<?php

namespace Tests\Weew\App\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit_Framework_TestCase;
use Symfony\Component\Console\Helper\HelperSet;
use Weew\App\App;
use Weew\App\Doctrine\DoctrineConfig;
use Weew\App\Doctrine\DoctrineProvider;

class DoctrineProviderTest extends PHPUnit_Framework_TestCase {
    protected function createApp() {
        $app = new App();
        $config = $app->loadConfig();
        $config->set(DoctrineConfig::DEBUG, true);
        $config->set(DoctrineConfig::CONFIG, [
            'driver' => 'pdo_sqlite',
            'memory' => true,
        ]);
        $config->set(DoctrineConfig::ENTITIES_PATH, '');
        $config->set(DoctrineConfig::CACHE_PATH, '/tmp');
        $config->set(DoctrineConfig::MIGRATIONS_PATH, '/tmp');
        $config->set(DoctrineConfig::MIGRATIONS_NAMESPACE, 'migrations');
        $config->set(DoctrineConfig::MIGRATIONS_TABLE, 'migrations');

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

    public function test_get_console_helper_set() {
        $app = $this->createApp();
        $app->start();
        /** @var DoctrineProvider $provider */
        $provider = $app->getContainer()->get(DoctrineProvider::class);
        $helperSet = $provider->getConsoleHelperSet();
        $this->assertTrue($helperSet instanceof HelperSet);
    }

    public function test_get_console_commands() {
        $app = $this->createApp();
        $app->start();
        /** @var DoctrineProvider $provider */
        $provider = $app->getContainer()->get(DoctrineProvider::class);
        $commands = $provider->getConsoleCommands($provider->getConsoleHelperSet());
        $this->assertTrue(is_array($commands));
    }

    public function test_run_console_runner() {
        $app = $this->createApp();
        $app->start();

        // reset global arguments for the doctrine console runner
        $_SERVER['argv'] = [];

        /** @var DoctrineProvider $provider */
        $provider = $app->getContainer()->get(DoctrineProvider::class);
        $provider->runConsoleRunner();
    }
}
