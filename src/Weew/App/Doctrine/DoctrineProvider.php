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
     * @param DoctrineConfig $config
     * @param IContainer $container
     */
    public function initialize(DoctrineConfig $config, IContainer $container) {
        $objectManager = $this->createObjectManager($config);
        $this->shareObjectManagerInstance($container, $objectManager);
        $this->enableContainerInjectionOfRepositories($container, $objectManager);
    }

    /**
     * @param DoctrineConfig
     *
     * @return EntityManager
     * @throws \Doctrine\ORM\ORMException
     */
    protected function createObjectManager(DoctrineConfig $config) {
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

    /**
     * @param IContainer $container
     * @param ObjectManager $objectManager
     */
    protected function shareObjectManagerInstance(
        IContainer $container,
        ObjectManager $objectManager
    ) {
        $container->set(
            [EntityManager::class, ObjectManager::class, EntityManagerInterface::class],
            $objectManager
        );
    }

    /**
     * @param IContainer $container
     * @param ObjectManager $objectManager
     */
    protected function enableContainerInjectionOfRepositories(
        IContainer $container,
        ObjectManager $objectManager
    ) {
        $loader = new DoctrineRepositoriesLoader($container, $objectManager);
        $loader->enable();
    }
}
