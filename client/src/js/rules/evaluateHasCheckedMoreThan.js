/**
 * Override with window['formtacular_evaluateHasCheckedMoreThan'] = (form, config) => {}
 */
export default (form, config) => {
    const value = window.formtacular_getFieldValue(form, config);
    return Array.isArray(value) && value.length > config.arguments[0];
}
