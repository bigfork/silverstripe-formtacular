<?php

namespace Bigfork\SilverstripeFormtacular\Rules;

class IsLessThanRule extends AbstractRule
{
    protected float $value;

    public function __construct(string $fieldName, float $value)
    {
        $this->value = $value;
        parent::__construct($fieldName);
    }

    public function getResult(): bool
    {
        return (float)$this->getFormField()->dataValue() < $this->value;
    }

    public function getJavaScriptTestName(): string
    {
        return 'evaluateIsLessThan';
    }

    public function getJavaScriptTestArguments(): array
    {
        return [$this->value];
    }
}
