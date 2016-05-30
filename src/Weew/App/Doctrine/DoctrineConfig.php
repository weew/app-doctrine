<?php

namespace Weew\App\Doctrine;

use Weew\Config\Exceptions\InvalidConfigValueException;
use Weew\Config\IConfig;

class DoctrineConfig implements IDoctrineConfig {
    const DEBUG = 'doctrine.debug';
    const CONFIG = 'doctrine.config';
    const METADATA_FORMAT = 'doctrine.metadata_format';
    const ENTITIES_PATHS = 'doctrine.entities_paths';
    const ENTITIES_MAPPINGS = 'doctrine.entities_mappings';
    const CACHE_PATH = 'doctrine.cache_path';
    const PROXY_CLASSES_PATH = 'doctrine.proxy_classes_path';
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
     *
     * @throws InvalidConfigValueException
     */
    public function __construct(IConfig $config) {
        $this->config = $config;

        $config
            ->ensure(self::DEBUG, 'Missing debug setting.')
            ->ensure(self::CONFIG, 'Missing doctrine config block.')
            ->ensure(self::METADATA_FORMAT, 'Missing metadata format, supported formats are "annotations" and "yaml".')
            ->ensure(self::CACHE_PATH, 'Missing doctrine cache directory path.')
            ->ensure(self::MIGRATIONS_NAMESPACE, 'Missing namespace for doctrine migrations.')
            ->ensure(self::MIGRATIONS_PATH, 'Missing directory path for doctrine migrations.')
            ->ensure(self::MIGRATIONS_TABLE, 'Missing table name for doctrine migrations.');

        if ($this->getMetadataFormat() === 'annotations') {
            $config
                ->ensure(self::ENTITIES_PATHS, 'Missing doctrine entities paths for annotations format.', 'array');
        } else if ($this->getMetadataFormat() === 'yaml') {
            $config
                ->ensure(self::ENTITIES_MAPPINGS, 'Missing doctrine entities mappings for yaml format.', 'array');
        } else {
            throw new InvalidConfigValueException(s(
                'Invalid format "%s", supported formats are "annotations" and "yaml".',
                $this->getMetadataFormat()
            ));
        }
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
    public function getMetadataFormat() {
        return $this->config->get(self::METADATA_FORMAT);
    }

    /**
     * @return array
     */
    public function getEntitiesPaths() {
        return $this->config->get(self::ENTITIES_PATHS);
    }

    /**
     * @return array
     */
    public function getEntitiesMappings() {
        return $this->config->get(self::ENTITIES_MAPPINGS);
    }

    /**
     * @return string
     */
    public function getCachePath() {
        return $this->config->get(self::CACHE_PATH);
    }

    public function getProxyClassesPath() {
        $path = $this->config->get(self::PROXY_CLASSES_PATH);

        if ($path === null) {
            $path = $this->getCachePath();
        }

        return $path;
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
