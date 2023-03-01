<?php

namespace Bigfork\SilverstripeFormtacular\Extensions;

use Bigfork\SilverstripeFormtacular\Rules\RuleSet;
use LogicException;
use SilverStripe\Core\Config\Configurable;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormField;
use SilverStripe\View\Requirements;

class FormExtension extends Extension
{
    use Configurable;

    protected array $fieldVisibilityConfig = [];

    protected array $fieldValidationConfig = [];

    public function CallOnBeforeRenderHook(): void
    {
        $context = $this->owner;
        $this->owner->extend('onBeforeRender', $context);
    }

    public function onBeforeRender(Form $form): void
    {
        /** @var FormField|FormFieldExtension $field */
        foreach ($form->Fields()->flattenFields() as $field) {
            $ruleSet = $field->getVisibilityRuleSet();
            if ($ruleSet) {
                $this->addFieldVisibilityRuleSetToConfig($form, $field, $ruleSet);

                if (!$field->getIsVisible($form)) {
                    $field->addExtraClass('formtacular-hidden');
                }
            }
        }
        /** @var FormField|FormFieldExtension $field */
        foreach ($form->Fields()->flattenFields() as $field) {
            $ruleSet = $field->getValidationApplicableRuleSet();
            if ($ruleSet) {
                $this->addFieldValidationApplicableRuleSetToConfig($form, $field, $ruleSet);
            }
        }

        if ($this->fieldVisibilityConfig) {
            $json = json_encode($this->fieldVisibilityConfig, JSON_THROW_ON_ERROR);
            $form->setAttribute('data-formtacular-visibility', $json);
            Requirements::javascript('bigfork/silverstripe-formtacular: client/dist/js/bundle.js');
        }

        if ($this->fieldValidationConfig) {
            $json = json_encode($this->fieldValidationConfig, JSON_THROW_ON_ERROR);
            $form->setAttribute('data-formtacular-validation', $json);
        }
    }

    /**
     * @param Form $form
     * @param FormField|FormFieldExtension $field
     * @param RuleSet $ruleSet
     * @return void
     */
    protected function addFieldVisibilityRuleSetToConfig(Form $form, $field, RuleSet $ruleSet)
    {
        $ruleSet->setForm($form);

        if (!$field->getName()) {
            $class = get_class($field);
            throw new LogicException("Form field encountered with no name: {$class}. Please call setName()");
        }

        $this->fieldVisibilityConfig[] = [
            'fieldName' => $field->getName(),
            'fieldID' => $field->ID(),
            'holderID' => $field->HolderID(),
            'initiallyVisible' => $field->getInitiallyVisible(),
            'ruleset' => $ruleSet->getJavaScriptConfig()
        ];
    }

    /**
     * @param Form $form
     * @param FormField|FormFieldExtension $field
     * @param RuleSet $ruleSet
     * @return void
     */
    protected function addFieldValidationApplicableRuleSetToConfig(Form $form, $field, RuleSet $ruleSet)
    {
        $ruleSet->setForm($form);

        if (!$field->getName()) {
            $class = get_class($field);
            throw new LogicException("Form field encountered with no name: {$class}. Please call setName()");
        }

        $this->fieldValidationConfig[] = [
            'fieldName' => $field->getName(),
            'fieldID' => $field->ID(),
            'holderID' => $field->HolderID(),
            'initiallyVisible' => $field->getInitiallyVisible(),
            'ruleset' => $ruleSet->getJavaScriptConfig()
        ];
    }
}
