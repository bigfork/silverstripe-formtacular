<?php

namespace Bigfork\SilverstripeFormtacular\Extensions;

use Bigfork\SilverstripeFormtacular\Rules\RuleSet;
use SilverStripe\Core\Config\Configurable;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormField;

class FormFieldExtension extends Extension
{
    use Configurable;

    protected ?RuleSet $visibilityRuleSet = null;

    protected bool $initiallyVisible = true;

    protected ?RuleSet $validationApplicableRuleSet = null;

    protected bool $initialValidationApplicable = true;

    public function displayIf(string $field): RuleSet
    {
        $ruleSet = RuleSet::create();
        $ruleSet->setFluidSyntaxFieldName($field);
        $ruleSet->setParentFormField($this->owner);
        $this->setVisibilityRuleSet($ruleSet);
        $this->setInitiallyVisible(false);
        return $ruleSet;
    }

    public function hideIf(string $field): RuleSet
    {
        $ruleSet = RuleSet::create();
        $ruleSet->setFluidSyntaxFieldName($field);
        $ruleSet->setParentFormField($this->owner);
        $this->setVisibilityRuleSet($ruleSet);
        $this->setInitiallyVisible(true);
        return $ruleSet;
    }

    public function displayUnless(string $field): RuleSet
    {
        return $this->hideIf($field);
    }

    public function hideUnless(string $field): RuleSet
    {
        return $this->displayIf($field);
    }

    public function getVisibilityRuleSet(): ?RuleSet
    {
        return $this->visibilityRuleSet;
    }

    public function setVisibilityRuleSet(RuleSet $visibilityRuleSet): FormField
    {
        $this->visibilityRuleSet = $visibilityRuleSet;

        /** @var FormField $field */
        $field = $this->owner;
        return $field;
    }

    public function getInitiallyVisible(): bool
    {
        return $this->initiallyVisible;
    }

    public function setInitiallyVisible(bool $visible): FormField
    {
        $this->initiallyVisible = $visible;

        /** @var FormField $field */
        $field = $this->owner;
        return $field;
    }

    public function getIsVisible(Form $form): bool
    {
        $ruleSet = $this->getVisibilityRuleSet();
        if (!$ruleSet) {
            return true;
        }

        $ruleSet->setForm($form);
        return $this->getInitiallyVisible() ? !$ruleSet->getResult() : $ruleSet->getResult();
    }

    public function validateIfVisible(): RuleSet
    {
        $visibilityRuleSet = $this->getVisibilityRuleSet();
        if ($visibilityRuleSet) {
            $ruleSet = clone $visibilityRuleSet;
        } else {
            $ruleSet = RuleSet::create();
        }

        $this->setValidationApplicableRuleSet($ruleSet);
        $this->setInitialValidationApplicable($this->getInitiallyVisible());
        return $ruleSet;
    }

    public function validateIf(string $field): RuleSet
    {
        $ruleSet = RuleSet::create();
        $ruleSet->setFluidSyntaxFieldName($field);
        $ruleSet->setParentFormField($this->owner);
        $this->setValidationApplicableRuleSet($ruleSet);
        $this->setInitialValidationApplicable(false);
        return $ruleSet;
    }

    public function doNotValidateIf(string $field): RuleSet
    {
        $ruleSet = RuleSet::create();
        $ruleSet->setFluidSyntaxFieldName($field);
        $ruleSet->setParentFormField($this->owner);
        $this->setValidationApplicableRuleSet($ruleSet);
        $this->setInitialValidationApplicable(true);
        return $ruleSet;
    }

    public function validateUnless(string $field): RuleSet
    {
        return $this->doNotValidateIf($field);
    }

    public function doNotValidateUnless(string $field): RuleSet
    {
        return $this->validateIf($field);
    }

    public function getValidationApplicableRuleSet(): ?RuleSet
    {
        return $this->validationApplicableRuleSet;
    }

    public function setValidationApplicableRuleSet(RuleSet $validationApplicableRuleSet): FormField
    {
        $this->validationApplicableRuleSet = $validationApplicableRuleSet;

        /** @var FormField $field */
        $field = $this->owner;
        return $field;
    }

    public function getInitialValidationApplicable(): bool
    {
        return $this->initialValidationApplicable;
    }

    public function setInitialValidationApplicable(bool $applicable): FormField
    {
        $this->initialValidationApplicable = $applicable;

        /** @var FormField $field */
        $field = $this->owner;
        return $field;
    }

    public function getIsValidationApplicable(Form $form): bool
    {
        $ruleSet = $this->getValidationApplicableRuleSet();
        if (!$ruleSet) {
            return true;
        }

        $ruleSet->setForm($form);
        return $this->getInitialValidationApplicable() ? !$ruleSet->getResult() : $ruleSet->getResult();
    }
}
