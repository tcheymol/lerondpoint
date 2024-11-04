<?php

namespace App\Domain\Location;

use Symfony\Contracts\Translation\TranslatableInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

enum Region: string implements TranslatableInterface
{
    case AuvergneRhoneAlpes ='Auvergne-Rhône-Alpes';
    case BourgogneFrancheComte ='Bourgogne-Franche-Comté';
    case Bretagne ='Bretagne';
    case CentreValDeLoire ='Centre-Val de Loire';
    case Corse ='Corse';
    case GrandEst ='Grand Est';
    case HautsDeFrance ='Hauts-de-France';
    case IleDeFrance ='Île-de-France';
    case Normandie ='Normandie';
    case NouvelleAquitaine = 'Nouvelle-Aquitaine';
    case Occitanie = 'Occitanie';
    case PaysDeLaLoire = 'Pays de la Loire';
    case ProvenceAlpesCoteDazur = "Provence-Alpes-Côte d'Azur";
    case Droms = 'DROMS';

    public function trans(TranslatorInterface $translator, ?string $locale = null): string
    {
        return $translator->trans($this->name, locale: $locale);
    }
}