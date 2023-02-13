<?php

namespace Bigfork\SilverstripeFormtacular\Rules;

class IsNotEmptyRule extends AbstractRule
{
    public function getResult(): bool
    {
        return !empty($this->getFormField()->dataValue());
    }

    public function getJavaScriptTestName(): string
    {
        return 'evaluateIsNotEmpty';
    }

    public function getJavaScriptTestArguments(): array
    {
        return [];
    }
}
