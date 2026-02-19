<?php

namespace App\Controller;

use App\Domain\Images\AttachmentHelper;
use App\Entity\Attachment;
use App\Repository\AttachmentRepository;
use App\Security\Voter\Constants;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

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

    #[IsGranted(attribute: Constants::EDIT, subject: 'attachment')]
    #[Route('/attachments/{id<\d+>}/rotate', name: 'rotate_attachment', methods: ['GET'])]
    public function rotate(Request $request, Attachment $attachment, AttachmentHelper $helper): JsonResponse
    {
        return new JsonResponse(['success' => $helper->rotate($attachment) !== null]);
    }

    #[IsGranted(attribute: Constants::EDIT, subject: 'attachment')]
    #[Route('/attachments/{id<\d+>}/delete', name: 'delete_attachment', methods: ['GET'])]
    public function delete(Request $request, Attachment $attachment, EntityManagerInterface $em): RedirectResponse
    {
        $removedAttachmentId = $attachment->getId();
        $existingAttachmentIds = explode(',', (string) $request->query->get('attachmentIds'));
        $track = $attachment->getTrack();

        $track?->removeAttachment($attachment);
        $em->remove($attachment);
        $em->flush();

        if ($track) {
            $existingAttachmentIds = array_unique([
                ...$existingAttachmentIds,
                ...$track->getAttachments()->map(
                    static fn (Attachment $attachment) => (string) $attachment->getId()
                )->toArray(),
            ]);
        }

        $remainingAttachmentIds = array_filter($existingAttachmentIds, static fn ($id) => $id !== (string) $removedAttachmentId && is_numeric($id));

        return $this->redirectToRoute('attachments_previews', [
            'ids' => implode(',', $remainingAttachmentIds),
        ]);
    }

    #[Route('/attachments/previews', name: 'attachments_previews', methods: ['GET'])]
    public function previews(Request $request, AttachmentRepository $repository): Response
    {
        $ids = explode(',', $request->query->get('ids') ?? '');
        $attachments = $repository->findByIdIn($ids);
        $cover = null;

        if (count($attachments) > 0) {
            $track = $attachments[0]->getTrack();

            $cover = $track ? $track->getCover() : $attachments[0];
        }

        return $this->render('components/upload/_attachments_previews.html.twig', [
            'attachments' => $attachments,
            'cover' => $cover,
        ]);
    }
}
