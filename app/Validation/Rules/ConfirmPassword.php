<?php

namespace App\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;

class ConfirmPassword extends AbstractRule
{
    /**
     * @var string
     */
    protected $password;

    /**
     * @param string $password
     */
    public function __construct(string $password)
    {
        $this->password = $password;
    }

    /**
     * @param string $input
     * @return boolean
     */
    public function validate(string $input): bool
    {
        return $input === $this->password;
    }
}
