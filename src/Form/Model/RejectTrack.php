<?php

namespace App\Form\Model;

use App\Entity\RejectionCause;

class RejectTrack
{
    public ?RejectionCause $rejectionCause = null;
    public ?string $rejectionMessage = null;
}
