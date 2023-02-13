import FormtacularForm from '../classes/FormtacularForm';
import evaluationFunctions from '../rules';
import formtacularForms from '../utils/formtacularForms';

window.formtacularForms = formtacularForms;

Object.keys(evaluationFunctions).forEach((key) => {
    window[key] = window[key] || evaluationFunctions[key];
});

const setup = () => {
    document.querySelectorAll('form').forEach((formElement) => {
        if (!formElement.hasAttribute('data-formtacular-visibility')) {
            return;
        }

        const form = new FormtacularForm(formElement);
        formtacularForms.set(formElement, form);
    });
};

addEventListener('DOMContentLoaded', (event) => {
    setup();
});
