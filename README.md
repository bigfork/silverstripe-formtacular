# ⚠️ This is alpha software, APIs may change ⚠️

# Silverstripe Formtacular

A work-in-progress attempt at replacing/combining the functionalities of
[display-logic](https://github.com/unclecheese/silverstripe-display-logic) and
[zenvalidator](https://github.com/sheadawson/silverstripe-zenvalidator), with the goal of removing the jQuery and jQuery
Entwine dependencies.

## Done

- Combined conditional fields + conditional validation functionality.
- API compatibility with display-logic where possible (effectively complete).
- Dependency-free JavaScript logic.
- Extensible for things like custom display rules.
- "Pluggable" for overriding front-end JavaScript for display rules.
- CMS compatibility. This is functional but hasn't been extensively tested.

## Todo

- Front-end conditional validation is not required as part of this module, only the config - but examples of how to
achieve it should be shown.
- Support for AJAX forms / lazily-loaded forms, possibly via MutationObserver. Or at least an example.
- Feature parity with zenvalidator around constraints. Likely only for Silverstripe 5 due to lack of necessary hooks in
Silverstripe 4.

## Required CSS

No frontend CSS is provided for this, because it's pretty simple for 99% of usecases and loading it from a separate CSS
file seems wasteful when its so easy to add to an existing project:

```css
div.formtacular-hidden {
    display: none;
}
```

If you conditionally show/hide other elements, e.g. `HeaderField`, you may need to expand the selector list. Try to
avoid using the `.formtacular-hidden` class selector alone (i.e. without an element), as this class will be added to
_both_ the field holder div and the form field itself by Silverstripe, so your fields may end up always invisible!

## Quick example

```php
$fields = FieldList::create(
    TextField::create('FirstName', 'First name'),
    TextField::create('Surname', 'Surname'),
    TextField::create('ContactMethod', 'Contact method', [
        'Email' => 'Email',
        'Telephone' => 'Telephone'
    ]),
    $email = EmailField::create('Email', 'Email'),
    $telephone = TextField::create('Telephone', 'Telephone')
);

$email->displayIf('ContactMethod')->isEqualTo('Email');
$email->validateIfVisible();

$telephone->displayIf('ContactMethod')->isEqualTo('Telephone');
$telephone->validateIfVisible();

// This subclass of RequiredFields is currently necessary
// It may be possible in Silverstripe 5 to remove this by utilising field validation extension hooks
$validator = \Bigfork\SilverstripeFormtacular\Validators\RequiredFields::create([
    'Name',
    'Surname',
    'ContactMethod',
    'Email',
    'Telephone'
])
```

## Switching from display-logic

- Add this module to your composer requirements, it’ll automatically replace `display-logic` in any dependencies or
sub-dependencies that require it
- Switch from `Wrapper::create()` to just using `CompositeField::create()`. This step can be skipped as a `Wrapper`
class is provided to try to make life a little easier

## Customisation

If you need to change how field values are fetched or how events are bound, like if you’re using a JavaScript library to
decorate form fields, you can do so by overriding global functions registered against `window`. For example in the CMS
bundle for this module, as jQuery is available we utilise it to fetch field values:

```js
window['formtacular_bindChangeEvent'] = (input, handler) => {
    $(input).on('change input', handler);
};
```

Check out the source JavaScript in `client/src/js/rules` and `client/src/js/utils` directories for a full list of
functions that can be overridden and when you might wish to do so.

## Adding checks/rules

You can write your own checks by extending `Bigfork\SilverstripeFormtacular\Rules\AbstractRule`, registering it in YAML
and writing an accompanying JavaScript function:

```php
<?php

use Bigfork\SilverstripeFormtacular\Rules\AbstractRule;

class IsStringLongerThanRule extends AbstractRule
{
    protected int $length;

    public function __construct(string $fieldName, int $length)
    {
        $this->length = $length;
        parent::__construct($fieldName);
    }

    public function getResult(): bool
    {
        return strlen($this->getFormField()->dataValue()) > $this->length;
    }

    public function getJavaScriptTestName(): string
    {
        return 'evaluateIsStringLongerThan';
    }

    public function getJavaScriptTestArguments(): array
    {
        return [$this->length];
    }
}

// ...

$field = TextField::create('TestField', 'Test field');
$field->displayIf('AnotherTestField')->isStringLongerThan(5);
```

```yml
Bigfork\SilverstripeFormtacular\Rules\RuleSet:
  fluid_syntax_rules:
    isStringLongerThan: 'IsStringLongerThanRule'
```

```js
window['formtacular_evaluateIsStringLongerThan'] = (form, config) => {
    const value = window.formtacular_getFieldValue(form, config);
    return typeof value === 'string' && value.length > config.arguments[0];
}
```
