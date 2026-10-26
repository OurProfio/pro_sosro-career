<?php

namespace App\Http\Requests\Concerns;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait UppercasesInput
{
    /**
     * Convert the given input keys (dot notation, `*` wildcard allowed) to uppercase.
     *
     * @param  array<int, string>  $patterns
     */
    protected function uppercaseInput(array $patterns): void
    {
        $uppercased = [];

        foreach (Arr::dot($this->all()) as $key => $value) {
            if (is_string($value) && $value !== '' && Str::is($patterns, $key)) {
                Arr::set($uppercased, $key, Str::upper($value));
            }
        }

        if ($uppercased !== []) {
            $this->merge(array_replace_recursive($this->all(), $uppercased));
        }
    }
}
