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

    /** @return Action[] */
    public function getActions(): array
    {
        return $this->repository->findAll();
    }
}
