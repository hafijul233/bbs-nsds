<?php

namespace App\Services\Backend\Common;

use App\Abstracts\Service\Service;

class ValidationService extends Service
{
    public function UniqueEmail(string $value, bool $update = false): bool
    {
        return true;
    }
}
