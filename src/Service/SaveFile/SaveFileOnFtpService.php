<?php

namespace App\Service\SaveFile;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SaveFileOnFtpService implements SaveFileServiceInterface
{
    public function __construct(
        private ParameterBagInterface $parameterBag,
    ) {
    }

    public function getSaveMode(): string
    {
        return 'ftp';
    }

    public function save(string $fileName, string $content): void
    {
        $server = $this->parameterBag->get('app.save_file.ftp.server');
        $user = $this->parameterBag->get('app.save_file.ftp.user');
        $password = $this->parameterBag->get('app.save_file.ftp.password');

        file_put_contents("ftp://{$user}:{$password}@{$server}/{$fileName}", $content);
    }
}
