import FormtacularField from './FormtacularField';

/**
 * An object representing a form which contains fields with conditional visibility rules applied
 */
class FormtacularForm {
    constructor(formElement) {
        this.formElement = formElement;
        this.rules = JSON.parse(formElement.getAttribute('data-formtacular-visibility')) || [];

        this.fields = [];
        this.rules.forEach((rule) => {
            const holderElement = window.formtacular_getFieldHolder(this, rule);
            if (!holderElement) {
                console.error(`Field holder not found for field: ${rule.fieldName}`);
                return;
            }

            const field = new FormtacularField(this, holderElement, rule.ruleset, rule.initiallyVisible);
            this.fields.push(field);
        });
        this.refresh();
    }

    getFormElement() {
        return this.formElement;
    }

    getRules() {
        return this.rules;
    }

    getFields() {
        return this.fields;
    }

    refresh() {
        this.getFields().forEach((field) => {
            field.refresh();
        });
    }
}

export default FormtacularForm;
