/**
 * Override with window['formtacular_evaluateIsChecked'] = (form, config) => {}
 */
export default (form, config) => {
    return !!window.formtacular_getFieldValue(form, config);
}
