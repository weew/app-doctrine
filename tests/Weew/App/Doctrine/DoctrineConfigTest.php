<?php

namespace Tests\Weew\App\Doctrine;

use PHPUnit_Framework_TestCase;
use Weew\App\Doctrine\DoctrineConfig;
use Weew\Config\Config;
use Weew\Config\Exceptions\InvalidConfigValueException;

class DoctrineConfigTest extends PHPUnit_Framework_TestCase {
    private function createConfig() {
        $config = new Config();
        $config->set(DoctrineConfig::DEBUG, 'debug');
        $config->set(DoctrineConfig::METADATA_FORMAT, 'yaml');
        $config->set(DoctrineConfig::ENTITIES_PATHS, ['entities_path']);
        $config->set(DoctrineConfig::ENTITIES_MAPPINGS, [
            ['path' => '/path', 'namespace' => 'some/namespace']
        ]);
        $config->set(DoctrineConfig::CACHE_PATH, 'cache_path');
        $config->set(DoctrineConfig::CONFIG, 'config');
        $config->set(DoctrineConfig::MIGRATIONS_NAMESPACE, 'migrations_namespace');
        $config->set(DoctrineConfig::MIGRATIONS_PATH, 'migrations_path');
        $config->set(DoctrineConfig::MIGRATIONS_TABLE, 'migrations_table');

        return $config;
    }

    public function test_getters() {
        $config = $this->createConfig();
        $doctrineConfig = new DoctrineConfig($config);
        $this->assertEquals('debug', $doctrineConfig->getDebug());
        $this->assertEquals('yaml', $doctrineConfig->getMetadataFormat());
        $this->assertEquals(['entities_path'], $doctrineConfig->getEntitiesPaths());
        $this->assertEquals([['path' => '/path', 'namespace' => 'some/namespace']], $doctrineConfig->getEntitiesMappings());
        $this->assertEquals(['/path' => 'some/namespace'], $doctrineConfig->getRestructuredEntitiesMappings());
        $this->assertEquals('cache_path', $doctrineConfig->getCachePath());
        $this->assertEquals('config', $doctrineConfig->getConfig());
        $this->assertEquals('migrations_namespace', $doctrineConfig->getMigrationsNamespace());
        $this->assertEquals('migrations_path', $doctrineConfig->getMigrationsPath());
        $this->assertEquals('migrations_table', $doctrineConfig->getMigrationsTable());
    }

    public function test_throws_error_with_invalid_metadata_format() {
        $config = $this->createConfig();
        $config->set(DoctrineConfig::METADATA_FORMAT, 'invalid');
        $this->setExpectedException(InvalidConfigValueException::class);
        new DoctrineConfig($config);
    }
}
