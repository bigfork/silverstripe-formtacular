<?php

namespace Bigfork\SilverstripeFormtacular\Rules;

/**
 * @deprecated kept for compatibility with display-logic, use HasCheckedMoreThanRule instead
 */
class HasCheckedAtLeastRule extends HasCheckedMoreThanRule
{
    public function __construct(string $fieldName, int $minChecked)
    {
        parent::__construct($fieldName, $minChecked - 1);
    }
}
