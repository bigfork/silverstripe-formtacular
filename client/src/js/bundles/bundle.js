import FormtacularForm from '../classes/FormtacularForm';
import evaluationFunctions from '../rules';
import utils from '../utils';

Object.keys(evaluationFunctions).forEach((key) => {
    const globalKey = `formtacular_${key}`;
    window[globalKey] = window[globalKey] || evaluationFunctions[key];
});

Object.keys(utils).forEach((key) => {
    const globalKey = `formtacular_${key}`;
    window[globalKey] = window[globalKey] || utils[key];
});

const setup = () => {
    document.querySelectorAll('form').forEach((formElement) => {
        if (!formElement.hasAttribute('data-formtacular-visibility')) {
            return;
        }

        const forms = window['formtacular_forms'];
        const form = new FormtacularForm(formElement);
        forms.set(formElement, form);
    });
};

addEventListener('DOMContentLoaded', (event) => {
    setup();
});
