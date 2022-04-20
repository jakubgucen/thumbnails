<?php

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class CreateThumbnailsCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);
        $filesystem = new Filesystem();

        // remove thumbnails dir
        $thumbnailsDir = "{$kernel->getProjectDir()}/public/thumbnails";
        $filesystem->remove($thumbnailsDir);

        // check if dir was removed
        $this->assertFalse($filesystem->exists($thumbnailsDir));

        $command = $application->find('app:create-thumbnails');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'save-mode' => 'disk',
        ]);

        $commandTester->assertCommandIsSuccessful();

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('100%', $output);

        // check if dir exists
        $this->assertTrue($filesystem->exists($thumbnailsDir));

        $finder = new Finder();
        $finder->files()->in($thumbnailsDir);

        $thumbnails = iterator_to_array($finder->getIterator());
        $this->assertGreaterThan(0, count($thumbnails));
    }
}
