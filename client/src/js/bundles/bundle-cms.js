import $ from 'jquery';
import FormtacularForm from '../classes/FormtacularForm';
import evaluationFunctions from '../rules';
import formtacularForms from '../utils/formtacularForms';

window.formtacularForms = formtacularForms;

Object.keys(evaluationFunctions).forEach((key) => {
    window[key] = window[key] || evaluationFunctions[key];
});

$.entwine('ss', ($) => {
    $('form').entwine({
        onmatch() {
            this._super();

            const rules = $(this).attr('data-formtacular-visibility');
            if (!rules) {
                return;
            }

            const formElement = $(this).get(0);

            if (formtacularForms.has(formElement)) {
                return;
            }

            const form = new FormtacularForm(formElement);
            formtacularForms.set(formElement, form);
        }
    })
});
