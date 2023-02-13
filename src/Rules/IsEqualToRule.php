<?php

namespace Bigfork\SilverstripeFormtacular\Rules;

class IsEqualToRule extends AbstractRule
{
    protected string $value;

    public function __construct(string $fieldName, string $value)
    {
        $this->value = $value;
        parent::__construct($fieldName);
    }

    public function getResult(): bool
    {
        return $this->getFormField()->dataValue() === $this->value;
    }

    public function getJavaScriptTestName(): string
    {
        return 'evaluateIsEqualTo';
    }

    public function getJavaScriptTestArguments(): array
    {
        return [$this->value];
    }
}
