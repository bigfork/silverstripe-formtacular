<?php

namespace Bigfork\SilverstripeFormtacular\Rules;

use LogicException;
use SilverStripe\Forms\MultiSelectField;

class HasCheckedOptionRule extends AbstractRule
{
    protected string $value;

    public function __construct(string $fieldName, $value)
    {
        $this->value = (string)$value;
        parent::__construct($fieldName);
    }

    public function getResult(): bool
    {
        $field = $this->getFormField();
        if (!$field instanceof MultiSelectField) {
            throw new LogicException('hasCheckedOption() cannot be used with an instance of ' . get_class($field)
                . '. Affected field name: ' . $this->fieldName);
        }
        return in_array($this->value, $field->getValueArray());
    }

    public function getJavaScriptTestName(): string
    {
        return 'evaluateHasCheckedOption';
    }

    public function getJavaScriptTestArguments(): array
    {
        return [$this->value];
    }
}
