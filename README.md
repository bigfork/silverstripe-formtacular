# ⚠️ This is alpha software, APIs may change ⚠️

# Silverstripe Formtacular

Name may change. Full docs todo.

## Done

- Combined conditional fields + conditional validation functionality.
- API compatibility with display-logic where possible (effectively complete).
- Dependency-free JavaScript logic.
- Extensible for things like custom display rules.
- "Pluggable" for overriding front-end JavaScript for display rules.
- CMS compatibility. This is functional but hasn't been extensively tested.

## Todo

- Front-end conditional validation is not required as part of this module, only the config - but examples of how to achieve it should be shown.
- Support for AJAX forms / lazily-loaded forms, possibly via MutationObserver. Or at least an example.
- Feature parity with zenvalidator around constraints. Likely only for Silverstripe 5 due to lack of necessary hooks in Silverstripe 4.

## Required CSS

No frontend CSS is provided for this, because it's pretty simple for 99% of usecases.

```css
div.formtacular-hidden {
    display: none;
}
```

If you conditionally show/hide other elements (e.g. via `HeaderField`) you may need to expand the selector list. Try to
avoid using `.formtacular-hidden` directly, as this class will be added to _both_ the field container div and the form
field itself by Silverstripe, so your fields may end up always invisible!

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

- Avoid chaining display rules onto FormField construction. I.e. instead of `TextField::create()->displayIf();`, use
`$field = TextField::create(); $field->displayIf();`
- Switch from `Wrapper::create()` to just using `CompositeField::create()`. However this step can be skipped as a
`Wrapper` class is provided to try to make life a little easier
