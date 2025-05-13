/**
 * Override with window['formtacular_evaluateHasNotCheckedOption'] = (form, config) => {}
 */
export default (form, config) => {
    const value = window.formtacular_getFieldValue(form, config);
    return !Array.isArray(value) || !value.includes(config.arguments[0]);
}
