<?php

namespace Bigfork\SilverstripeFormtacular\Rules;

class ContainsRule extends AbstractRule
{
    protected string $value;

    public function __construct(string $fieldName, string $value)
    {
        $this->value = $value;
        parent::__construct($fieldName);
    }

    public function getResult(): bool
    {
        if ($this->value === '') {
            return false;
        }

        return mb_strpos($this->getFormField()->dataValue(), $this->value) !== false;
    }

    public function getJavaScriptTestName(): string
    {
        return 'evaluateContains';
    }

    public function getJavaScriptTestArguments(): array
    {
        return [$this->value];
    }
}
