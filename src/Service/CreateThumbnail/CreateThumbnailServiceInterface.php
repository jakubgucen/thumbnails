<?php

namespace App\Service\CreateThumbnail;

use App\Model\Thumbnail\ThumbnailInterface;
use SplFileInfo;

interface CreateThumbnailServiceInterface
{
    public function create(SplFileInfo $file): ThumbnailInterface;
}
