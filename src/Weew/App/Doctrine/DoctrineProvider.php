<?php

namespace Weew\App\Doctrine;

use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Setup;
use Weew\Config\IConfig;
use Weew\Container\DoctrineIntegration\DoctrineRepositoriesLoader;
use Weew\Container\IContainer;

class DoctrineProvider {
    /**
     * @param IConfig $config
     * @param IContainer $container
     */
    public function initialize(IConfig $config, IContainer $container) {
        $this->ensureConfig($config);
        $objectManager = $this->createObjectManager($config);
        $this->shareObjectManagerInstance($container, $objectManager);
        $this->enableContainerInjectionOfRepositories($container, $objectManager);
    }

    /**
     * Ensure certain configurations are set.
     *
     * @param IConfig $config
     */
    protected function ensureConfig(IConfig $config) {
        $config
            ->ensure(DoctrineConfigKey::DEBUG, 'Missing debug setting.')
            ->ensure(DoctrineConfigKey::CONFIG, 'Missing doctrine configurations.')
            ->ensure(DoctrineConfigKey::ENTITIES_PATH, 'Missing path to directory where entities reside in.')
            ->ensure(DoctrineConfigKey::CACHE_PATH, 'Missing path to doctrine cache directory.');
    }

    /**
     * @param IConfig $config
     *
     * @return EntityManager
     * @throws \Doctrine\ORM\ORMException
     */
    protected function createObjectManager(IConfig $config) {
        $entitiesPath = [$config->get(DoctrineConfigKey::ENTITIES_PATH)];
        $parameters = $config->get(DoctrineConfigKey::CONFIG);
        $debug = $config->get(DoctrineConfigKey::DEBUG);
        $proxyDir = null;
        $cachePath = $config->get(DoctrineConfigKey::CACHE_PATH);
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
