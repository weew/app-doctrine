<?php

namespace Weew\App\Doctrine;

interface IDoctrineConfig {
    /**
     * @return bool
     */
    function getDebug();

    /**
     * @return array
     */
    function getConfig();

    /**
     * @return string
     */
    function getMetadataFormat();

    /**
     * @return array
     */
    function getEntitiesPaths();

    /**
     * @return array
     */
    function getEntitiesMappings();

    /**
     * @param string $identifier
     *
     * @return string
     */
    function getEntitiesMappingsPath($identifier);

    /**
     * @param string $identifier
     *
     * @return string
     */
    function getEntitiesMappingsNamespace($identifier);

    /**
     * @return array
     */
    function getRestructuredEntitiesMappings();

    /**
     * @return string
     */
    function getCachePath();

    /**
     * @return string
     */
    function getMigrationsNamespace();

    /**
     * @return string
     */
    function getMigrationsPath();

    /**
     * @return string
     */
    function getMigrationsTable();
}
