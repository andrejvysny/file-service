<?php

namespace App\StorageProvider;

use App\Entity\File;
use App\Entity\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

interface StorageProvider
{
    public function getHost(): string;

    public function uploadFile(UploadedFile $file, User $user): File;
}
