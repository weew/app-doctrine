<?php

namespace Weew\App\Doctrine;

use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\Migrations\Configuration\Configuration;
use Doctrine\DBAL\Migrations\Tools\Console\Command\AbstractCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\DiffCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\ExecuteCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\GenerateCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\LatestCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\StatusCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\VersionCommand;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Setup;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;
use Weew\Container\DoctrineIntegration\DoctrineRepositoriesLoader;
use Weew\Container\IContainer;

class DoctrineProvider {
    /**
     * @var DoctrineConfig
     */
    private $config;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param DoctrineConfig $config
     * @param IContainer $container
     */
    public function initialize(DoctrineConfig $config, IContainer $container) {
        $entityManager = $this->createEntityManager($config);
        $this->enableContainerInjectionOfRepositories($container, $entityManager);

        $this->config = $config;
        $this->entityManager = $entityManager;

        $container->set(
            [EntityManager::class, ObjectManager::class, EntityManagerInterface::class],
            $entityManager
        );
    }

    /**
     * @return HelperSet
     */
    public function getConsoleHelperSet() {
        $helperSet = ConsoleRunner::createHelperSet($this->entityManager);
        $helperSet->set(new QuestionHelper(), 'dialog');

        return $helperSet;
    }

    /**
     * @param HelperSet $helperSet
     *
     * @return array
     */
    public function getConsoleCommands(HelperSet $helperSet) {
        $configuration = new Configuration($this->entityManager->getConnection());
        $configuration->setMigrationsNamespace($this->config->getMigrationsNamespace());
        $configuration->setMigrationsDirectory($this->config->getMigrationsPath());
        $configuration->setMigrationsTableName($this->config->getMigrationsTable());

        $commands = [
            new DiffCommand(),
            new ExecuteCommand(),
            new GenerateCommand(),
            new LatestCommand(),
            new MigrateCommand(),
            new StatusCommand(),
            new VersionCommand()
        ];

        /** @var AbstractCommand $command */
        foreach ($commands as $command) {
            $command->setHelperSet($helperSet);
            $command->setMigrationConfiguration($configuration);
        }

        return $commands;
    }

    /**
     * Run doctrine console tool.
     */
    public function runConsoleRunner() {
        $helperSet = $this->getConsoleHelperSet();
        ConsoleRunner::run($helperSet, $this->getConsoleCommands($helperSet));
    }

    /**
     * @param DoctrineConfig
     *
     * @return EntityManager
     * @throws \Doctrine\ORM\ORMException
     */
    protected function createEntityManager(DoctrineConfig $config) {
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
    protected function enableContainerInjectionOfRepositories(
        IContainer $container,
        ObjectManager $objectManager
    ) {
        $loader = new DoctrineRepositoriesLoader($container, $objectManager);
        $loader->enable();
    }
}
