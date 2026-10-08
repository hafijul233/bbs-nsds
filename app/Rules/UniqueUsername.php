<?php

namespace App\Rules;

use App\Services\Auth\VerifyService;
use Illuminate\Contracts\Validation\Rule;

class UniqueUsername implements Rule
{
    /**
     * @var VerifyService
     */
    protected $verifyService;

    /**
     * Create a new rule instance.
     */
    public function __construct()
    {
        $this->verifyService = new VerifyService;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     */
    public function passes($attribute, $value): bool
    {
        return $this->verifyService->verifyUsername($value);
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return 'Username already exists';
    }
}
