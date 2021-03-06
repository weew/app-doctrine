<?php

namespace Weew\App\Doctrine;

use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Proxy\AbstractProxyFactory;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\SimplifiedYamlDriver;
use Doctrine\ORM\Mapping\NamingStrategy;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Doctrine\ORM\Tools\Setup;
use RuntimeException;
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
        $parameters = $config->getConfig();
        $proxyDir = null;

        $configuration = $this->createConfiguration($config);
        $configuration->setNamingStrategy($this->createNamingStrategy());

        return EntityManager::create($parameters, $configuration);
    }

    /**
     * @param IDoctrineConfig $config
     *
     * @return Configuration
     */
    protected function createConfiguration(
        IDoctrineConfig $config
    ) {
        $configuration = null;

        if ($config->getMetadataFormat() === 'annotations') {
            $configuration = Setup::createAnnotationMetadataConfiguration(
                $config->getEntitiesPaths(),
                $config->getDebug(),
                null,
                $this->getCache($config)
            );
        } else if ($config->getMetadataFormat() === 'yaml') {
            $driver = new SimplifiedYamlDriver($config->getEntitiesMappings());
            $configuration = Setup::createConfiguration(
                $config->getDebug(),
                null,
                $this->getCache($config)
            );
            $configuration->setMetadataDriverImpl($driver);
        }

        if ($configuration instanceof Configuration) {
            $configuration->setAutoGenerateProxyClasses(
                $this->getProxyClassesGenerationStrategy($config)
            );

            $configuration->setProxyDir($config->getProxyClassesPath());

            return $configuration;
        }

        throw new RuntimeException(s(
            'Could not create doctrine configuration for metadata format "%s".',
            $config->getMetadataFormat()
        ));
    }

    /**
     * @param IDoctrineConfig $config
     *
     * @return FilesystemCache|null
     */
    protected function getCache(IDoctrineConfig $config) {
        $cachePath = $config->getCachePath();
        $cache = null;

        if ($cachePath !== null) {
            $cache = new FilesystemCache($cachePath, 'dc');
        }

        return $cache;
    }

    /**
     * @param IDoctrineConfig $config
     *
     * @return int
     */
    protected function getProxyClassesGenerationStrategy(IDoctrineConfig $config) {
        if ($config->getDebug()) {
            return AbstractProxyFactory::AUTOGENERATE_ALWAYS;
        } else {
            return AbstractProxyFactory::AUTOGENERATE_FILE_NOT_EXISTS;
        }
    }

    /**
     * @return NamingStrategy
     */
    protected function createNamingStrategy() {
        return new UnderscoreNamingStrategy();
    }
}
