<?php

namespace Bigfork\SilverstripeFormtacular\Rules;

class IsNotCheckedRule extends AbstractRule
{
    public function getResult(): bool
    {
        return $this->getFormField()->dataValue() !== 1;
    }

    public function getJavaScriptTestName(): string
    {
        return 'evaluateIsNotChecked';
    }

    public function getJavaScriptTestArguments(): array
    {
        return [];
    }
}
