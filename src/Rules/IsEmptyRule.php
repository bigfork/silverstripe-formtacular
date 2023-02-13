<?php

namespace Bigfork\SilverstripeFormtacular\Rules;

class IsEmptyRule extends AbstractRule
{
    public function getResult(): bool
    {
        return empty($this->getFormField()->dataValue());
    }

    public function getJavaScriptTestName(): string
    {
        return 'evaluateIsEmpty';
    }

    public function getJavaScriptTestArguments(): array
    {
        return [];
    }
}
