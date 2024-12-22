<?php

namespace App\Controller;

use App\Domain\Images\AttachmentHelper;
use App\Entity\Attachment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/attachment')]
class AttachmentController extends AbstractController
{
    #[Route('', name: 'upload_attachment', methods: ['POST'])]
    public function index(Request $request, AttachmentHelper $helper): Response
    {
        /** @var UploadedFile $file */
        $file = $request->files->get('file');
        $attachment = $helper->createAttachment($file);

        return $this->json(['id' => $attachment?->getId()]);
    }
}
