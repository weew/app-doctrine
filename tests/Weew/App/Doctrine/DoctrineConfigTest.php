<?php

namespace Tests\Weew\App\Doctrine;

use PHPUnit_Framework_TestCase;
use Weew\App\Doctrine\DoctrineConfig;
use Weew\Config\Config;

class DoctrineConfigTest extends PHPUnit_Framework_TestCase {
    private function createConfig() {
        $config = new Config();
        $config->set(DoctrineConfig::DEBUG, true);
        $config->set(DoctrineConfig::METADATA_FORMAT, 'yaml');
        $config->set(DoctrineConfig::ENTITIES_PATHS, ['entities_path']);
        $config->set(DoctrineConfig::ENTITIES_MAPPINGS, [
            '/path' => 'some\namespace',
        ]);
        $config->set(DoctrineConfig::CACHE_PATH, 'cache_path');
        $config->set(DoctrineConfig::PROXY_CLASSES_PATH, 'proxy_path');
        $config->set(DoctrineConfig::CONFIG, []);
        $config->set(DoctrineConfig::MIGRATIONS_NAMESPACE, 'migrations_namespace');
        $config->set(DoctrineConfig::MIGRATIONS_PATH, 'migrations_path');
        $config->set(DoctrineConfig::MIGRATIONS_TABLE, 'migrations_table');

        return $config;
    }

    public function test_getters() {
        $config = $this->createConfig();
        $doctrineConfig = new DoctrineConfig($config);
        $this->assertEquals(true, $doctrineConfig->getDebug());
        $this->assertEquals('yaml', $doctrineConfig->getMetadataFormat());
        $this->assertEquals(['entities_path'], $doctrineConfig->getEntitiesPaths());
        $this->assertEquals(['/path' => 'some\namespace'], $doctrineConfig->getEntitiesMappings());
        $this->assertEquals('cache_path', $doctrineConfig->getCachePath());
        $this->assertEquals('proxy_path', $doctrineConfig->getProxyClassesPath());
        $this->assertEquals([], $doctrineConfig->getConfig());
        $this->assertEquals('migrations_namespace', $doctrineConfig->getMigrationsNamespace());
        $this->assertEquals('migrations_path', $doctrineConfig->getMigrationsPath());
        $this->assertEquals('migrations_table', $doctrineConfig->getMigrationsTable());
    }

    public function test_get_proxy_classes_path_returns_cache_path_by_default() {
        $config = $this->createConfig();
        $config->set(DoctrineConfig::PROXY_CLASSES_PATH, null);
        $doctrineConfig = new DoctrineConfig($config);

        $this->assertEquals('cache_path', $doctrineConfig->getProxyClassesPath());
    }
}
