<?php

namespace App\Controller;

use App\Domain\Images\AttachmentHelper;
use App\Entity\Attachment;
use App\Repository\AttachmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AttachmentController extends AbstractController
{
    #[Route('/attachments', name: 'upload_attachment', methods: ['POST'])]
    public function index(Request $request, AttachmentHelper $helper): Response
    {
        /** @var UploadedFile $file */
        $file = $request->files->get('file');
        $attachment = $helper->createAttachment($file);

        return $this->json(['id' => $attachment?->getId()]);
    }

    #[Route('/attachments/{id<\d+>}/delete', name: 'delete_attachment', methods: ['GET'])]
    public function delete(Request $request, Attachment $attachment, EntityManagerInterface $em): RedirectResponse
    {
        $removedAttachmentId = $attachment->getId();
        $existingAttachmentIds = explode(',', (string) $request->query->get('attachmentIds'));
        $em->remove($attachment);
        $em->flush();

        if ($attachment->getTrack()) {
            $existingAttachmentIds = array_unique([
                ...$existingAttachmentIds,
                ...$attachment->getTrack()->getAttachments()->map(
                    static fn (Attachment $attachment) => (string) $attachment->getId()
                )->toArray(),
            ]);
        }

        $remainingAttachmentIds = array_filter($existingAttachmentIds, static fn ($id) => $id !== (string) $removedAttachmentId);

        return $this->redirectToRoute('attachments_previews', [
            'ids' => implode(',', $remainingAttachmentIds),
        ]);
    }

    #[Route('/attachments/previews', name: 'attachments_previews', methods: ['GET'])]
    public function previews(Request $request, AttachmentRepository $repository): Response
    {
        $ids = explode(',', $request->query->get('ids') ?? '');
        $attachments = $repository->findByIdIn($ids);

        return $this->render('components/upload/_attachments_previews.html.twig', [
            'attachments' => $attachments,
        ]);
    }
}
