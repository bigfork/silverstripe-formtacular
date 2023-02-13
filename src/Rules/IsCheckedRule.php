<?php

namespace Bigfork\SilverstripeFormtacular\Rules;

class IsCheckedRule extends AbstractRule
{
    public function getResult(): bool
    {
        return $this->getFormField()->dataValue() === 1;
    }

    public function getJavaScriptTestName(): string
    {
        return 'evaluateIsChecked';
    }

    public function getJavaScriptTestArguments(): array
    {
        return [];
    }
}
