<?php

namespace Tests\Weew\App\Doctrine;

use PHPUnit_Framework_TestCase;
use Symfony\Component\Console\Helper\HelperSet;
use Tests\Weew\App\Doctrine\Util\AppFactory;
use Weew\App\Doctrine\DoctrineConsoleRunner;

class DoctrineConsoleRunnerTest extends PHPUnit_Framework_TestCase {
    private function createApp() {
        $factory = new AppFactory();

        return $factory->createApp();
    }

    public function test_get_console_helper_set() {
        $app = $this->createApp();
        $app->start();
        /** @var DoctrineConsoleRunner $runner */
        $runner = $app->getContainer()->get(DoctrineConsoleRunner::class);
        $helperSet = $runner->getConsoleHelperSet();
        $this->assertTrue($helperSet instanceof HelperSet);
    }

    public function test_get_console_commands() {
        $app = $this->createApp();
        $app->start();
        /** @var DoctrineConsoleRunner $runner */
        $runner = $app->getContainer()->get(DoctrineConsoleRunner::class);
        $commands = $runner->getConsoleCommands($runner->getConsoleHelperSet());
        $this->assertTrue(is_array($commands));
    }
}
