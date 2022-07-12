<?php

namespace App\Rules;

use Closure;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Translation\PotentiallyTranslatedString;

/**
 * Class ShareTelegramRule
 *
 * @package App\Rules
 */
final class ShareTelegramRule implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param string                                       $attribute
     * @param mixed                                        $value
     * @param Closure(string): PotentiallyTranslatedString $fail
     *
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if (! $this->isValid($attribute, $value)) {
            $fail('rules.fail.telegram')->translate();
        }
    }

    /**
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     * @author sihoullete
     */
    protected function isValid(string $attribute, mixed $value): bool
    {
        $validPhone = Validator::make([$attribute => $value], [
            $attribute => 'required|regex:/^([0-9\s\+\(\)]*)$/|min:10',
        ])->valid();
        $validUser = Validator::make([$attribute => $value], [
            $attribute => 'regex:/^.*\B@(?=\w{5,32}\b)[a-zA-Z0-9]+(?:_[a-zA-Z0-9]+)*.*$/',
        ])->valid();

        return $validPhone || $validUser;
    }
}

