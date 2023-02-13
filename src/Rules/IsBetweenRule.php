<?php

namespace Bigfork\SilverstripeFormtacular\Rules;

class IsBetweenRule extends AbstractRule
{
    protected float $min;

    protected float $max;

    public function __construct(string $fieldName, float $min, float $max)
    {
        $this->min = $min;
        $this->max = $max;
        parent::__construct($fieldName);
    }

    public function getResult(): bool
    {
        $value = (float)$this->getFormField()->dataValue();
        return $value > $this->min && $value < $this->max;
    }

    public function getJavaScriptTestName(): string
    {
        return 'evaluateIsBetween';
    }

    public function getJavaScriptTestArguments(): array
    {
        return [$this->min, $this->max];
    }
}
