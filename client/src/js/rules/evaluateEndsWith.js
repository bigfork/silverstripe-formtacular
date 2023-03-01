/**
 * Override with window['formtacular_evaluateEndsWith'] = (form, config) => {}
 */
export default (form, config) => {
    const value = window.formtacular_getFieldValue(form, config);
    return typeof value === 'string' && value.endsWith(config.arguments[0]);
}
