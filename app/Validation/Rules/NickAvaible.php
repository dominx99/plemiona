<?php

namespace App\Validation\Rules;

use App\Models\User;
use Respect\Validation\Rules\AbstractRule;

class NickAvaible extends AbstractRule
{
    /**
     * @param string $input
     * @return boolean
     */
    public function validate($input)
    {
        return !User::where('nick', $input)->exists();
    }
}
