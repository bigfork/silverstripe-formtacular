<?php

namespace Bigfork\SilverstripeFormtacular\Rules;

/**
 * @deprecated kept for compatibility with display-logic, use HasCheckedFewerThanRule instead
 */
class HasCheckedLessThanRule extends HasCheckedFewerThanRule
{
    public function __construct(string $fieldName, int $maxChecked)
    {
        parent::__construct($fieldName, $maxChecked + 1);
    }
}
