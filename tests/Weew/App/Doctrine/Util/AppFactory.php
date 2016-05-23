<?php

namespace Tests\Weew\App\Doctrine\Util;

use Weew\App\App;
use Weew\App\Doctrine\DoctrineConfig;
use Weew\App\Doctrine\DoctrineProvider;
use Weew\Config\Config;

class AppFactory {
    /**
     * @param string $metadataFormat
     *
     * @return App
     */
    public function createApp($metadataFormat = 'yaml') {
        $app = new App();
        $config = new Config();
        $config->set(DoctrineConfig::DEBUG, true);
        $config->set(DoctrineConfig::CONFIG, [
            'driver' => 'pdo_sqlite',
            'memory' => true,
        ]);
        $config->set(DoctrineConfig::ENTITIES_MAPPINGS, []);
        $config->set(DoctrineConfig::ENTITIES_PATHS, []);
        $config->set(DoctrineConfig::METADATA_FORMAT, $metadataFormat);
        $config->set(DoctrineConfig::CACHE_PATH, '/tmp');
        $config->set(DoctrineConfig::MIGRATIONS_PATH, '/tmp');
        $config->set(DoctrineConfig::MIGRATIONS_NAMESPACE, 'migrations');
        $config->set(DoctrineConfig::MIGRATIONS_TABLE, 'migrations');
        $app->getConfigLoader()->addConfig($config);

        $app->getKernel()->addProvider(DoctrineProvider::class);

        return $app;
    }
}
