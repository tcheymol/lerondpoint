<?php

namespace App\Domain\Images;

enum ThumbSize: string
{
    case Small = 'small';
    case Medium = 'medium';
    case Big = 'big';
    case Full = 'full';
}
