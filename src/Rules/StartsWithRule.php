<?php

namespace Bigfork\SilverstripeFormtacular\Rules;

class StartsWithRule extends AbstractRule
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

        return strncmp($this->getFormField()->dataValue(), $this->value, strlen($this->value)) === 0;
    }

    public function getJavaScriptTestName(): string
    {
        return 'evaluateStartsWith';
    }

    public function getJavaScriptTestArguments(): array
    {
        return [$this->value];
    }
}
