<?php

namespace Weew\App\Doctrine;

use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Setup;
use Weew\Container\DoctrineIntegration\DoctrineRepositoriesLoader;
use Weew\Container\IContainer;

class DoctrineProvider {
    /**
     * @param IContainer $container
     */
    public function initialize(IContainer $container) {
        $container->set(IDoctrineConfig::class, DoctrineConfig::class);
        $container->set(
            [EntityManager::class, ObjectManager::class, EntityManagerInterface::class],
            [$this, 'createEntityManager']
        )->singleton();
    }

    /**
     * @param IContainer $container
     * @param EntityManager $em
     */
    public function boot(IContainer $container, EntityManager $em) {
        $loader = new DoctrineRepositoriesLoader($container, $em);
        $loader->enable();
    }

    /**
     * @param IDoctrineConfig $config
     *
     * @return EntityManager
     * @throws \Doctrine\ORM\ORMException
     */
    public function createEntityManager(IDoctrineConfig $config) {
        $entitiesPath = [$config->getEntitiesPath()];
        $parameters = $config->getConfig();
        $debug = $config->getDebug();
        $proxyDir = null;
        $cachePath = $config->getCachePath();
        $cache = null;

        if ($cachePath !== null) {
            $cache = new FilesystemCache($cachePath, 'dc');
        }

        $configuration = Setup::createAnnotationMetadataConfiguration(
            $entitiesPath, $debug, null, $cache
        );

        return EntityManager::create($parameters, $configuration);
    }
}
