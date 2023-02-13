<?php

namespace Bigfork\SilverstripeFormtacular\Rules;

class IsGreaterThanRule extends AbstractRule
{
    protected float $value;

    public function __construct(string $fieldName, float $value)
    {
        $this->value = $value;
        parent::__construct($fieldName);
    }

    public function getResult(): bool
    {
        return (float)$this->getFormField()->dataValue() > $this->value;
    }

    public function getJavaScriptTestName(): string
    {
        return 'evaluateIsGreaterThan';
    }

    public function getJavaScriptTestArguments(): array
    {
        return [$this->value];
    }
}
