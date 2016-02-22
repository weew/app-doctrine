<?php

namespace Tests\Weew\App\Doctrine;

use PHPUnit_Framework_TestCase;
use Weew\App\Doctrine\DoctrineConfig;
use Weew\Config\Config;

class DoctrineConfigTest extends PHPUnit_Framework_TestCase {
    public function test_getters() {
        $config = new Config();
        $config->set(DoctrineConfig::DEBUG, 'debug');
        $config->set(DoctrineConfig::ENTITIES_PATH, 'entities_path');
        $config->set(DoctrineConfig::CACHE_PATH, 'cache_path');
        $config->set(DoctrineConfig::CONFIG, 'config');

        $doctrineConfig = new DoctrineConfig($config);
        $this->assertEquals('debug', $doctrineConfig->getDebug());
        $this->assertEquals('entities_path', $doctrineConfig->getEntitiesPath());
        $this->assertEquals('cache_path', $doctrineConfig->getCachePath());
        $this->assertEquals('config', $doctrineConfig->getConfig());
    }
}
