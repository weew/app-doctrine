<?php

namespace Weew\App\Doctrine;

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
            ->ensure('debug', 'Missing debug setting.')
            ->ensure('db', 'Missing doctrine configurations.')
            ->ensure('db.entity_paths', 'Missing list of directory paths where entities reside in.');
    }

    /**
     * @param IConfig $config
     *
     * @return EntityManager
     * @throws \Doctrine\ORM\ORMException
     */
    protected function createObjectManager(IConfig $config) {
        $entitiesPath = [$config->get('db.entity_paths')];
        $parameters = $config->get('db');
        $debug = $config->get('debug');

        $configuration = Setup::createAnnotationMetadataConfiguration(
            $entitiesPath, $debug
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
