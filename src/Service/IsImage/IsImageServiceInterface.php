<?php

namespace App\Service\IsImage;

use Symfony\Component\Finder\SplFileInfo;

interface IsImageServiceInterface
{
    public function check(SplFileInfo $file): bool;
}
