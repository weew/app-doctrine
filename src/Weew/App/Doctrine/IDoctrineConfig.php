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
    function getEntitiesPath();

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
