<?php

namespace App\Service\SaveFile;

use InvalidArgumentException;

class SaveFileServiceProvider
{
    /**
     * @var SaveFileServiceInterface[]
     */
    private array $services;

    public function __construct(
        SaveFileOnDiskService $saveFileOnDiskService,
        SaveFileOnFtpService $saveFileOnFtpService,
    ) {
        $this->services = [
            $saveFileOnDiskService,
            $saveFileOnFtpService,
        ];
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getService(string $saveMode): SaveFileServiceInterface
    {
        foreach ($this->services as $service) {
            if ($service->getSaveMode() === $saveMode) {
                return $service;
            }
        }

        throw new InvalidArgumentException("Unsupported save-mode: {$saveMode}");
    }

    public function getSaveModes(): string
    {
        $saveModes = array_map(
            fn (SaveFileServiceInterface $saveFileService) => $saveFileService->getSaveMode(),
            $this->services
        );

        return implode('|', $saveModes);
    }
}
