<?php

namespace App\Service\CreateThumbnail;

use App\Model\Thumbnail\Thumbnail;
use App\Model\Thumbnail\ThumbnailInterface;
use Liip\ImagineBundle\Imagine\Data\DataManager;
use Liip\ImagineBundle\Imagine\Filter\FilterManager;
use SplFileInfo;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class CreateThumbnailService implements CreateThumbnailServiceInterface
{
    public function __construct(
        private FilterManager $filterManager,
        private DataManager  $dataManager,
        private ParameterBagInterface $parameterBag,
    ) {
    }

    public function create(SplFileInfo $file): ThumbnailInterface
    {
        $filter = 'thumbs_max_150px';
        $imagesDir = $this->parameterBag->get('app.public_images_dir');
        $path = "{$imagesDir}/{$file->getFilename()}";

        $image = $this->dataManager->find($filter, $path);
        $image = $this->filterManager->applyFilter($image, $filter);

        return new Thumbnail(
            content: $image->getContent(),
            format: $image->getFormat(),
        );
    }
}
