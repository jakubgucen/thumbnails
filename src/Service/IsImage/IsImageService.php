<?php

namespace App\Service\IsImage;

use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Mime\MimeTypesInterface;

class IsImageService implements IsImageServiceInterface
{
    public function __construct(
        private MimeTypesInterface $mimeTypes
    ) {
    }

    public function check(SplFileInfo $file): bool
    {
        $mimeType = $this->mimeTypes->guessMimeType($file->getRealPath());

        if ($mimeType === null) {
            return false;
        }

        return mb_strpos($mimeType, 'image/') === 0;
    }
}
