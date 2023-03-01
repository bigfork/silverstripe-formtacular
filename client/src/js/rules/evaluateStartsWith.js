/**
 * Override with window['formtacular_evaluateStartsWith'] = (form, config) => {}
 */
export default (form, config) => {
    const value = window.formtacular_getFieldValue(form, config);
    return typeof value === 'string' && value.startsWith(config.arguments[0]);
}
