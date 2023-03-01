/**
 * Override with window['formtacular_evaluateIsNotEqualTo'] = (form, config) => {}
 */
export default (form, config) => {
    return window.formtacular_getFieldValue(form, config) !== config.arguments[0];
}
