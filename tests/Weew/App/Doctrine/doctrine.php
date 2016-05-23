<?php

use Weew\App\App;
use Weew\App\Doctrine\DoctrineConfig;
use Weew\App\Doctrine\DoctrineProvider;

require __DIR__ . '/../../../../vendor/autoload.php';

$app = new App();
$config = $app->getConfig();
$config->set(DoctrineConfig::DEBUG, true);
$config->set(DoctrineConfig::CONFIG, [
    'driver' => 'pdo_sqlite',
    'memory' => true,
]);

$config->set(DoctrineConfig::ENTITIES_PATHS, '');
$config->set(DoctrineConfig::CACHE_PATH, '/tmp');
$config->set(DoctrineConfig::MIGRATIONS_PATH, '/tmp');
$config->set(DoctrineConfig::MIGRATIONS_NAMESPACE, 'migrations');
$config->set(DoctrineConfig::MIGRATIONS_TABLE, 'migrations');

$app->getKernel()->addProvider(DoctrineProvider::class);

$app->start();

/** @var DoctrineProvider $doctrineProvider */
$doctrineProvider = $app->getContainer()->get(DoctrineProvider::class);
$doctrineProvider->runConsoleRunner();


