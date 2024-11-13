<?php

namespace App\Controller;

use App\Domain\Images\AttachmentHelper;
use App\Entity\Attachment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/attachment')]
class AttachmentController extends AbstractController
{
    #[Route('', name: 'upload_attachment', methods: ['POST'])]
    public function index(Request $request, AttachmentHelper $helper): Response
    {
        $attachment = $helper->createAttachment($request->files->get('file'));

        return $this->json(['id' => $attachment->getId()]);
    }

    #[Route('/{id<\d+>}/show', name: 'show_attachment', methods: ['GET'])]
    public function show(Attachment $attachment, AttachmentHelper $helper): Response
    {
        $helper->hydrateWithUrl($attachment);

        return $this->render('attachment/show.html.twig', ['attachment' => $attachment]);
    }
}
