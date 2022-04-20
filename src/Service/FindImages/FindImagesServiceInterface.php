<?php

namespace App\Service\FindImages;

use SplFileInfo;

interface FindImagesServiceInterface
{
    /**
     * @return SplFileInfo[]
     */
    public function findImages(): array;
}
