<?php

namespace Gamota\Dashboard\Validator;

use \Illuminate\Validation\Validator;
use Hash;

class HashRule extends Validator
{
    public function validateHash($attribute, $value, $parameters)
    {
        return Hash::check($value, $parameters[0]);
    }
}
