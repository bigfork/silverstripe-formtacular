<?php

namespace Bigfork\SilverstripeFormtacular\Rules;

class EndsWithRule extends AbstractRule
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

        return substr($this->getFormField()->dataValue(), -strlen($this->value)) === $this->value;
    }

    public function getJavaScriptTestName(): string
    {
        return 'evaluateEndsWith';
    }

    public function getJavaScriptTestArguments(): array
    {
        return [$this->value];
    }
}
