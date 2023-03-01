/**
 * Override with window['formtacular_evaluateContains'] = (form, config) => {}
 */
export default (form, config) => {
    const value = window.formtacular_getFieldValue(form, config);
    return typeof value === 'string' && value.contains(config.arguments[0]);
}
