<?php

namespace App\Service\SaveFile;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;

class SaveFileOnDiskService implements SaveFileServiceInterface
{
    public function __construct(
        private Filesystem $filesystem,
        private ParameterBagInterface $parameterBag,
        private KernelInterface $kernel,
    ) {
    }

    public function getSaveMode(): string
    {
        return 'disk';
    }

    public function save(string $fileName, string $content): void
    {
        $dir = "{$this->kernel->getProjectDir()}/public/thumbnails";

        $this->filesystem->dumpFile("{$dir}/{$fileName}", $content);
    }
}
