<?php

namespace App\Twig\Runtime;

use App\Entity\Action;
use App\Repository\ActionRepository;
use Twig\Extension\RuntimeExtensionInterface;

readonly class ActionIconExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct(private ActionRepository $repository)
    {
    }

    /** @return string[] */
    public function getActionsIconsPaths(): array
    {
        return array_unique(array_map(
            fn (Action $action) => $action->getIconPublicPath(true),
            $this->repository->findAll(),
        ));
    }
}
