<?php

namespace App\Model\Thumbnail;

class Thumbnail implements ThumbnailInterface
{
    public function __construct(
        private string $content,
        private string $format,
    ) {
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getFormat(): string
    {
        return $this->format;
    }
}
