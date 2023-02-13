<?php

namespace Bigfork\SilverstripeFormtacular\Validators;

use Bigfork\SilverstripeFormtacular\Extensions\FormFieldExtension;
use SilverStripe\Forms\FormField;
use SilverStripe\Forms\RequiredFields as SilverstripeRequiredFields;

class RequiredFields extends SilverstripeRequiredFields
{
    public function php($data): bool
    {
        foreach ($this->required as $i => $fieldName) {
            if (!$fieldName) {
                continue;
            }

            if ($fieldName instanceof FormField) {
                $fieldName = $fieldName->getName();
            }

            /** @var FormField|FormFieldExtension $formField */
            $formField = $this->form->Fields()->dataFieldByName($fieldName);
            if (!$formField) {
                continue;
            }

            if (!$formField->getIsValidationApplicable($this->form)) {
                unset($this->required[$i]);
            }
        }

        return parent::php($data);
    }
}
