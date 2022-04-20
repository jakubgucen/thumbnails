<?php

namespace App\Model\Thumbnail;

interface ThumbnailInterface
{
    public function getContent(): string;

    public function getFormat(): string;
}
