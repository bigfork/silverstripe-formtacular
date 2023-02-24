import $ from 'jquery';
import FormtacularForm from '../classes/FormtacularForm';
import evaluationFunctions from '../rules';
import utils from '../utils';

// Use jQuery's input change tracking - ensures select2 dropdowns work for example
window['formtacular_bindChangeEvent'] = (input, handler) => {
    $(input).on('change input', handler);
}

Object.keys(evaluationFunctions).forEach((key) => {
    const globalKey = `formtacular_${key}`;
    window[globalKey] = window[globalKey] || evaluationFunctions[key];
});

Object.keys(utils).forEach((key) => {
    const globalKey = `formtacular_${key}`;
    window[globalKey] = window[globalKey] || utils[key];
});

$.entwine('ss', ($) => {
    $('form').entwine({
        onadd() {
            this._super();

            const rules = $(this).attr('data-formtacular-visibility');
            if (!rules) {
                return;
            }

            const forms = window['formtacular_forms'];
            const formElement = $(this).get(0);
            if (forms.has(formElement)) {
                return;
            }

            const form = new FormtacularForm(formElement);
            forms.set(formElement, form);
        },

        onremove() {
            this._super();

            const forms = window['formtacular_forms'];
            const formElement = $(this).get(0);
            forms.remove(formElement);
        }
    });
});
