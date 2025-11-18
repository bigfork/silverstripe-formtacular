<?php

namespace Bigfork\SilverstripeFormtacular\Rules;

use LogicException;
use SilverStripe\Core\Injector\Injectable;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormField;

abstract class AbstractRule
{
    use Injectable;

    protected string $fieldName;

    protected ?Form $form = null;

    public function __construct(string $fieldName)
    {
        $this->fieldName = $fieldName;
    }

    abstract public function getResult(): bool;

    abstract public function getJavaScriptTestName(): string;

    abstract public function getJavaScriptTestArguments(): array;

    public function setForm(Form $form): AbstractRule
    {
        $this->form = $form;
        return $this;
    }

    public function getFormField(): FormField
    {
        if (!$this->form || !$field = $this->form->Fields()->dataFieldByName($this->fieldName)) {
            throw new LogicException("Form field {$this->fieldName} not found");
        }

        return $field;
    }

    public function getJavaScriptConfig(): array
    {
        $field = $this->getFormField();

        if (!$field->getName()) {
            $class = get_class($field);
            throw new LogicException("Form field encountered with no name: {$class}. Please call setName()");
        }

        return [
            'fieldName' => $field->getName(),
            'fieldID' => $field->ID(),
            'holderID' => $field->HolderID(),
            'test' => $this->getJavaScriptTestName(),
            'arguments' => $this->getJavaScriptTestArguments()
        ];
    }

    public function canBeApplied(): bool
    {
        if (!$this->form || !$field = $this->form->Fields()->dataFieldByName($this->fieldName)) {
            return false;
        }
        return true;
    }
}
