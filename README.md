# Silverstripe Formtacular

Name may change. Docs todo.

## Done

- Combined conditional fields + conditional validation functionality
- API compatibility with display-logic (effectively complete)
- Dependency-free JavaScript logic
- Extensible for things like custom display rules
- "Pluggable" for overriding front-end JavaScript for display rules

## Todo

- CMS compatibility (this part doesn't need to be dependency free). If this is not achievable, it might be prudent to abandon API compatibility with display-logic
- Front-end conditional validation is not required as part of this module, only the config - but examples of how to achieve it should be shown
- Support for AJAX forms / lazily-loaded forms, possibly via MutationObserver
- Feature parity with zenvalidator? I.e. constraints

## Quick example

```php
$fields = FieldList::create(
    TextField::create('FirstName', 'First name'),
    TextField::create('Surname', 'Surname'),
    TextField::create('ContactMethod', 'Contact method', [
        'Email' => 'Email',
        'Ttelephone' => 'Telephone'
    ]),
    $email = EmailField::create('Email', 'Email'),
    $telephone = TextField::create('Telephone', 'Telephone')
);

$email->displayIf('ContactMethod')->isEqualTo('Email');
$email->validateIfVisible();

$telephone->displayIf('ContactMethod')->isEqualTo('Telephone');
$telephone->validateIfVisible();

$validator = \Bigfork\SilverstripeFormtacular\Validators\RequiredFields::create([
    'Name',
    'Surname',
    'ContactMethod',
    'Email',
    'Telephone'
])
```
