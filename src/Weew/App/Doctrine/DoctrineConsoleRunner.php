<?php

namespace Weew\App\Doctrine;

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
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;
use Weew\Container\IContainer;

class DoctrineConsoleRunner {
    /**
     * @var IContainer
     */
    private $container;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var IDoctrineConfig
     */
    private $config;

    /**
     * DoctrineConsoleRunner constructor.
     *
     * @param IContainer $container
     * @param EntityManager $em
     * @param IDoctrineConfig $config
     */
    public function __construct(
        IContainer $container,
        EntityManager $em,
        IDoctrineConfig $config
    ) {
        $this->container = $container;
        $this->em = $em;
        $this->config = $config;
    }

    /**
     * @return HelperSet
     */
    public function getConsoleHelperSet() {
        $helperSet = ConsoleRunner::createHelperSet($this->em);
        $helperSet->set(new QuestionHelper(), 'dialog');

        return $helperSet;
    }

    /**
     * @param HelperSet $helperSet
     *
     * @return array
     */
    public function getConsoleCommands(HelperSet $helperSet) {
        $configuration = new Configuration($this->em->getConnection());
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
    public function run() {
        $helperSet = $this->getConsoleHelperSet();
        ConsoleRunner::run($helperSet, $this->getConsoleCommands($helperSet));
    }
}
