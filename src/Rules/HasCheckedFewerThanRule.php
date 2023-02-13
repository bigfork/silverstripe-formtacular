<?php

namespace Bigfork\SilverstripeFormtacular\Rules;

use LogicException;
use SilverStripe\Forms\MultiSelectField;

class HasCheckedFewerThanRule extends AbstractRule
{
    protected int $maxChecked;

    public function __construct(string $fieldName, int $maxChecked)
    {
        $this->maxChecked = $maxChecked;
        parent::__construct($fieldName);
    }

    public function getResult(): bool
    {
        $field = $this->getFormField();
        if (!$field instanceof MultiSelectField) {
            throw new LogicException('hasCheckedFewerThan() cannot be used with an instance of ' . get_class($field)
                . '. Affected field name: ' . $this->fieldName);
        }
        return count($field->getValueArray()) < $this->maxChecked;
    }

    public function getJavaScriptTestName(): string
    {
        return 'evaluateHasCheckedFewerThan';
    }

    public function getJavaScriptTestArguments(): array
    {
        return [$this->maxChecked];
    }
}
