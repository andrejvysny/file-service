<?php

namespace App\StorageProvider;

use App\Entity\File;
use App\Entity\User;
use App\Manager\FileManager;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Uid\Ulid;
use Symfony\Component\Uid\Uuid;


/**
 * Storage provider for Hosting from Websupport
 */
class HostingStorageProvider implements StorageProvider
{
    private Request $request;
    public function __construct(RequestStack $requestStack, private string $targetDirectory)
    {
        $this->request= $requestStack->getCurrentRequest();
    }

    public function getHost(): string
    {
        return rtrim($this->request->getSchemeAndHttpHost(),'/');
    }

    public function uploadFile(UploadedFile $file, User $user): File
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        $ulid = new Ulid();

        do {
            $path = $this->generateFileName($file, $ulid);
            $exist = file_exists($this->getTargetDirectory() . $path);
        } while ($exist);

        $file->move($this->getTargetDirectory(), $path);

        $this->uploadCheck($path);

        return FileManager::createFile(
            $ulid,
            $originalFilename,
            $file->getClientOriginalExtension(),
            $path,
            $this->getHost() . DIRECTORY_SEPARATOR . $path
        );
    }

    private function generateFileName(UploadedFile $file, Ulid $ulid): string
    {
        return sprintf('%s.%s', $ulid->toRfc4122(), $file->guessExtension());
    }

    public function getTargetDirectory(): string
    {
        $directory = $this->targetDirectory;

        // TODO implement each user separate folder for storage -> use users secret

        if (!file_exists($directory) && !mkdir($directory) && !is_dir($directory)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $directory));
        }

        return rtrim($directory, '/') . DIRECTORY_SEPARATOR;
    }


    private function uploadCheck(string $path): void
    {
        if (!file_exists($this->getTargetDirectory() . $path)) {
            throw new \Exception('File was not uploaded correctly! ' . $path);
        }

        if (!file_exists($this->getHost() . $path)) {
            //  throw new \Exception('File is not visible on host! '.$path);
        }
    }
}
