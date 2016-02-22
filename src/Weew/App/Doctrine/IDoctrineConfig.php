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
}
