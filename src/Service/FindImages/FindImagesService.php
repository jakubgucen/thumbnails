<?php

namespace App\Service\FindImages;

use App\Service\IsImage\IsImageService;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Finder\SplFileInfo;

class FindImagesService implements FindImagesServiceInterface
{
    public function __construct(
        private IsImageService $isImageService,
        private KernelInterface $kernel,
        private ParameterBagInterface $parameterBag,
    ) {
    }

    public function findImages(): array
    {
        $dir = $this->getDir();

        $finder = new Finder();
        $finder->files()->in($dir);

        $files = iterator_to_array($finder->getIterator());

        return array_filter(
            $files,
            fn (SplFileInfo $file) => $this->isImageService->check($file)
        );
    }

    private function getDir(): string
    {
        $projectDir = $this->kernel->getProjectDir();
        $imagesDir = $this->parameterBag->get('app.public_images_dir');

        return "{$projectDir}/public/{$imagesDir}";
    }
}
