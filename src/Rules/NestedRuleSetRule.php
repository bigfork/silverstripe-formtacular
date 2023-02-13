<?php

namespace Bigfork\SilverstripeFormtacular\Rules;

use SilverStripe\Forms\Form;

class NestedRuleSetRule extends AbstractRule
{
    protected RuleSet $ruleSet;

    public function __construct(RuleSet $ruleSet)
    {
        $this->ruleSet = $ruleSet;
        parent::__construct('');
    }

    public function setForm(Form $form): AbstractRule
    {
        $this->ruleSet->setForm($form);
        return parent::setForm($form);
    }

    public function getResult(): bool
    {
        return $this->ruleSet->getResult();
    }

    public function getJavaScriptTestName(): string
    {
        return '';
    }

    public function getJavaScriptTestArguments(): array
    {
        return [];
    }

    public function getJavaScriptConfig(): array
    {
        return $this->ruleSet->getJavaScriptConfig();
    }
}
