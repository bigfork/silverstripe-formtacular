<?php

namespace Bigfork\SilverstripeFormtacular\Validators;

use Bigfork\SilverstripeFormtacular\Extensions\FormFieldExtension;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\FormField;
use SilverStripe\Forms\Validation\RequiredFieldsValidator;

class RequiredFields extends RequiredFieldsValidator
{
    public function php($data): bool
    {
        $required = [];
        // Normalise list of required fields
        foreach ($this->required as $key => $fieldName) {
            if (!$fieldName) {
                continue;
            }

            if ($fieldName instanceof FormField) {
                $fieldName = $fieldName->getName();
            }

            $required[$fieldName] = $key;
        }

        /** @var FormField|FormFieldExtension $formField */
        $this->form->Fields()->recursiveWalk(function (FormField $formField) use ($required) {
            if (empty($required)) {
                return;
            }

            $fieldName = $formField->getName();

            // If we've encountered a required field directly, check if validation applies
            if (array_key_exists($fieldName, $required) && !$formField->getIsValidationApplicable($this->form)) {
                $key = $required[$fieldName];
                unset($this->required[$key], $required[$fieldName]);
            }

            // If we've encountered a CompositeField, check if it has validation disabled
            if ($formField instanceof CompositeField && !$formField->getIsValidationApplicable($this->form)) {
                // If validation doesn't apply to this CompositeField, we can disable it on any required fields within
                /** @var FormField $nestedField */
                foreach ($formField->getChildren()->dataFields() as $nestedField) {
                    $fieldName = $nestedField->getName();
                    if (array_key_exists($fieldName, $required)) {
                        $key = $required[$fieldName];
                        unset($this->required[$key], $required[$fieldName]);
                    }
                }
            }
        });

        return parent::php($data);
    }
}
