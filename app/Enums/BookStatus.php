<?php

namespace App\Enums;

enum BookStatus: string
{
    case DRAFT = 'draft';

    case SUBMITTED = 'submitted';

    case UNDER_REVIEW = 'under_review';

    case APPROVED = 'approved';

    case REJECTED = 'rejected';

    case PUBLISHED = 'published';
}