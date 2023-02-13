<?php

namespace Bigfork\SilverstripeFormtacular\Rules;

use LogicException;
use SilverStripe\Forms\MultiSelectField;

class HasCheckedMoreThanRule extends AbstractRule
{
    protected int $minChecked;

    public function __construct(string $fieldName, int $minChecked)
    {
        $this->minChecked = $minChecked;
        parent::__construct($fieldName);
    }

    public function getResult(): bool
    {
        $field = $this->getFormField();
        if (!$field instanceof MultiSelectField) {
            throw new LogicException('hasCheckedMoreThan() cannot be used with an instance of ' . get_class($field)
                . '. Affected field name: ' . $this->fieldName);
        }
        return count($field->getValueArray()) > $this->minChecked;
    }

    public function getJavaScriptTestName(): string
    {
        return 'evaluateHasCheckedMoreThan';
    }

    public function getJavaScriptTestArguments(): array
    {
        return [$this->minChecked];
    }
}
