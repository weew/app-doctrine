<?php

namespace Tests\Weew\App\Doctrine\Util;

use Weew\App\Doctrine\IDoctrineConfig;

class FakeDoctrineConfig implements IDoctrineConfig {
    /**
     * @return bool
     */
    function getDebug() {
        // TODO: Implement getDebug() method.
    }

    /**
     * @return array
     */
    function getConfig() {
        // TODO: Implement getConfig() method.
    }

    /**
     * @return string
     */
    function getMetadataFormat() {
        // TODO: Implement getMetadataFormat() method.
    }

    /**
     * @return array
     */
    function getEntitiesPaths() {
        // TODO: Implement getEntitiesPaths() method.
    }

    /**
     * @return array
     */
    function getEntitiesMappings() {
        // TODO: Implement getEntitiesMappings() method.
    }

    /**
     * @param string $identifier
     *
     * @return string
     */
    function getEntitiesMappingsPath($identifier) {
        // TODO: Implement getEntitiesMappingsPath() method.
    }

    /**
     * @param string $identifier
     *
     * @return string
     */
    function getEntitiesMappingsNamespace($identifier) {
        // TODO: Implement getEntitiesMappingsNamespace() method.
    }

    /**
     * @return array
     */
    function getRestructuredEntitiesMappings() {
        // TODO: Implement getRestructuredEntitiesMappings() method.
    }

    /**
     * @return string
     */
    function getCachePath() {
        // TODO: Implement getCachePath() method.
    }

    /**
     * @return string
     */
    function getMigrationsNamespace() {
        // TODO: Implement getMigrationsNamespace() method.
    }

    /**
     * @return string
     */
    function getMigrationsPath() {
        // TODO: Implement getMigrationsPath() method.
    }

    /**
     * @return string
     */
    function getMigrationsTable() {
        // TODO: Implement getMigrationsTable() method.
    }
}
