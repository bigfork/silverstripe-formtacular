<?php

namespace Bigfork\SilverstripeFormtacular\Rules;

class IsNotEqualToRule extends AbstractRule
{
    protected string $value;

    public function __construct(string $fieldName, string $value)
    {
        $this->value = $value;
        parent::__construct($fieldName);
    }

    public function getResult(): bool
    {
        return $this->getFormField()->dataValue() !== $this->value;
    }

    public function getJavaScriptTestName(): string
    {
        return 'evaluateIsNotEqualTo';
    }

    public function getJavaScriptTestArguments(): array
    {
        return [$this->value];
    }
}
