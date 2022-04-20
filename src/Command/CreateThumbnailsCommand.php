<?php

namespace App\Command;

use App\Service\CreateThumbnail\CreateThumbnailService;
use App\Service\FindImages\FindImagesService;
use App\Service\SaveFile\SaveFileServiceProvider;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpKernel\KernelInterface;

#[AsCommand(
    name: 'app:create-thumbnails',
)]
class CreateThumbnailsCommand extends Command
{
    public function __construct(
        private CreateThumbnailService $createThumbnailService,
        private FindImagesService $findImagesService,
        private KernelInterface $kernel,
        private SaveFileServiceProvider $saveFileServiceProvider,
        private ParameterBagInterface $parameterBag,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $saveModes = $this->saveFileServiceProvider->getSaveModes();
        $this->addArgument('save-mode', InputArgument::REQUIRED, $saveModes);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $images = $this->findImagesService->findImages();

        $saveMode = $input->getArgument('save-mode');
        $saveFileService = $this->saveFileServiceProvider->getService($saveMode);

        $progressBar = new ProgressBar($output, count($images));
        $progressBar->start();

        foreach ($images as $image) {
            $thumbnail = $this->createThumbnailService->create($image);
            $saveFileService->save("{$image->getBasename()}.{$thumbnail->getFormat()}", $thumbnail->getContent());

            $progressBar->advance();
        }

        $progressBar->finish();

        return Command::SUCCESS;
    }
}
