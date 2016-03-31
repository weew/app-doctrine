<?php

namespace Tests\Weew\App\Doctrine\Util;

use Weew\App\App;
use Weew\App\Doctrine\DoctrineConfig;
use Weew\App\Doctrine\DoctrineProvider;

class AppFactory {
    /**
     * @return App
     */
    public function createApp() {
        $app = new App();
        $config = $app->getConfig();
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
}
