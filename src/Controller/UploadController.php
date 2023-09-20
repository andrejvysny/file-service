<?php

namespace App\Controller;

use App\Entity\File;
use App\Entity\User;
use App\Response\ApiResponse;
use App\StorageProvider\HostingStorageProvider;
use App\StorageProvider\StorageProvider;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class UploadController extends AbstractController
{

    #[Route("/", name: "test", methods: ["GET"])]
    public function test(){

        return new Response('x');
    }


    #[Route("/upload", name: "upload", methods: ["POST"])]
    public function upload(
        Request $request,
        HostingStorageProvider $storageProvider,
        ManagerRegistry $managerRegistry
    ): ApiResponse {
        $files = $request->files->get('files');

        if (empty($files)) {
            return new ApiResponse(null, Response::HTTP_BAD_REQUEST);
        }

        $user = new User(1,'test@test.test');
        $user->setSecret(new Uuid('9fbc2742-a71b-4337-a8a3-6342419abe02'));
        $data = [];


        if ($files instanceof UploadedFile){
            $savedFile = $storageProvider->uploadFile($files,$user);
            $data = $savedFile->getId()->toRfc4122();
        }else{
            foreach ($files as $index => $file) {
                $savedFile = $storageProvider->uploadFile($file,$user);
                $data[$index] = $savedFile->getId()->toRfc4122();
            }
        }



        $managerRegistry->getManager()->flush();

        return new ApiResponse($data);
    }

}
