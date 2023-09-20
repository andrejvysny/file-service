<?php

namespace App\Manager;

use App\Entity\File;
use App\Repository\FileRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Ulid;

final class FileManager
{
    public function __construct(private readonly ManagerRegistry $em, private readonly FileRepository $fileRepository)
    {
    }


    public static function createFile(Ulid $ulid, string $originalName, string $extension, string $path, string $url): File
    {
        $file = new File();
        $file->setId($ulid);
        $file->setOriginalName($originalName);
        $file->setPath($path);
        $file->setExtension($extension);
        $file->setUploadedAt(new \DateTimeImmutable());
        $file->setUrl($url);
        $file->setRemoveAt((new \DateTime('tomorrow'))->setTime(0, 0));
        return $file;
    }

    public function removeFile(File $file): File
    {
        $file->setRemoveAt((new \DateTime('next week'))->setTime(0, 0));

        return $this->saveFile($file);
    }


    private function saveFile(File $file): File
    {
        $this->em->getManager()->persist($file);
        $this->em->getManager()->flush();
        return $file;
    }
}
