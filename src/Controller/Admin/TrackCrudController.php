<?php

namespace App\Controller\Admin;

use App\Entity\Track;
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

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    #[\Override]
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('name');
        yield BooleanField::new('disabled');
        yield BooleanField::new('validated');
        yield BooleanField::new('rejected');
        yield AssociationField::new('validatedBy')->hideOnForm();
        yield AssociationField::new('rejectedBy')->hideOnForm();
        yield CollectionField::new('attachments')
            ->formatValue(function ($value, $entity) {
                $attachments = $entity->getAttachments(); // ou $value
                if (count($attachments) === 0) {
                    return 'Aucun document';
                }

                $links = [];
                foreach ($attachments as $attachment) {
                    $url = $this->adminUrlGenerator
                        ->setController(AttachmentCrudController::class)
                        ->setAction('detail')
                        ->setEntityId($attachment->getId())
                        ->generateUrl();

                    $links[] = sprintf("<a href=\"%s\">%s</a>", $url, htmlspecialchars($attachment->getObjectId()));
                }

                return implode('<br>', $links);
            })
            ->onlyOnDetail();
    }
}
