/**
 * Override with window['formtacular_evaluateIsNotChecked'] = (form, config) => {}
 */
export default (form, config) => {
    return !window.formtacular_getFieldValue(form, config);
}
