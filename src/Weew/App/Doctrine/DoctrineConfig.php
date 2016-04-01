<?php

namespace Weew\App\Doctrine;

use Weew\Config\IConfig;

class DoctrineConfig implements IDoctrineConfig {
    const DEBUG = 'doctrine.debug';
    const CONFIG = 'doctrine.config';
    const ENTITIES_PATH = 'doctrine.entities_path';
    const CACHE_PATH = 'doctrine.cache_path';
    const MIGRATIONS_NAMESPACE = 'doctrine.migrations.namespace';
    const MIGRATIONS_PATH = 'doctrine.migrations.path';
    const MIGRATIONS_TABLE = 'doctrine.migrations.table';

    /**
     * @var IConfig
     */
    protected $config;

    /**
     * DoctrineConfig constructor.
     *
     * @param IConfig $config
     */
    public function __construct(IConfig $config) {
        $this->config = $config;

        $config
            ->ensure(self::DEBUG, 'Missing debug setting.')
            ->ensure(self::CONFIG, 'Missing doctrine config block.')
            ->ensure(self::ENTITIES_PATH, 'Missing doctrine entities path.')
            ->ensure(self::CACHE_PATH, 'Missing doctrine cache directory path.')
            ->ensure(self::MIGRATIONS_NAMESPACE, 'Missing namespace for doctrine migrations.')
            ->ensure(self::MIGRATIONS_PATH, 'Missing directory path for doctrine migrations.')
            ->ensure(self::MIGRATIONS_TABLE, 'Missing table name for doctrine migrations.');
    }

    /**
     * @return bool
     */
    public function getDebug() {
        return $this->config->get(self::DEBUG);
    }

    /**
     * @return array
     */
    public function getConfig() {
        return $this->config->get(self::CONFIG);
    }

    /**
     * @return string
     */
    public function getEntitiesPath() {
        return $this->config->get(self::ENTITIES_PATH);
    }

    /**
     * @return string
     */
    public function getCachePath() {
        return $this->config->get(self::CACHE_PATH);
    }

    /**
     * @return string
     */
    public function getMigrationsNamespace() {
        return $this->config->get(self::MIGRATIONS_NAMESPACE);
    }

    /**
     * @return string
     */
    public function getMigrationsPath() {
        return $this->config->get(self::MIGRATIONS_PATH);
    }

    /**
     * @return string
     */
    public function getMigrationsTable() {
        return $this->config->get(self::MIGRATIONS_TABLE);
    }
}
