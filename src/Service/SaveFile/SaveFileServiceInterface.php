<?php

namespace App\Service\SaveFile;

interface SaveFileServiceInterface
{
    public function getSaveMode(): string;

    public function save(string $fileName, string $content): void;
}
