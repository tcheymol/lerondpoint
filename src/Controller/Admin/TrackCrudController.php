<?php

namespace App\Controller\Admin;

use App\Entity\Attachment;
use App\Entity\Track;
use Doctrine\Common\Collections\Collection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class TrackCrudController extends AbstractCrudController
{
    public function __construct(private readonly AdminUrlGenerator $adminUrlGenerator)
    {
    }

    #[\Override]
    public static function getEntityFqcn(): string
    {
        return Track::class;
    }

    #[\Override]
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_DETAIL,
                Action::new('regeneratePreviews', 'RegeneratePreviews', 'fa fa-images')
                ->addCssClass('btn btn-warning')
                ->linkToRoute('track_regenerate_previews', fn (Track $track) => ['id' => $track->getId()])
            );
    }

    #[\Override]
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('name');
        yield BooleanField::new('validated');
        yield BooleanField::new('rejected');
        yield AssociationField::new('validatedBy')->hideOnForm();
        yield AssociationField::new('rejectedBy')->hideOnForm();
        yield CollectionField::new('attachments')->hideOnForm()
            ->formatValue(fn ($value, $track) => $this->formatAttachments($value, $track));
    }

    private function formatAttachments(Collection $value, Track $track): string
    {
        return implode('<br/>', $track->getAttachments()
            ->map(fn (Attachment $attachment) => $this->formatAttachment($attachment))
            ->toArray());
    }

    private function formatAttachment(Attachment $attachment): string
    {
        $attachmentAdminUrl = $this->adminUrlGenerator
            ->setController(AttachmentCrudController::class)
            ->setAction('detail')
            ->setEntityId($attachment->getId())
            ->generateUrl();

        return sprintf('<a href="%s">%s</a>', $attachmentAdminUrl, $attachment->getObjectId());
    }
}
