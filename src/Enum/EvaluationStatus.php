<?php

namespace App\Enum;

enum EvaluationStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
}
