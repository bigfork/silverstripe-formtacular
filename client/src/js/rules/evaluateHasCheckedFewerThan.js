/**
 * Override with window['formtacular_evaluateHasCheckedFewerThan'] = (form, config) => {}
 */
export default (form, config) => {
    const value = window.formtacular_getFieldValue(form, config);

    // Special case - value will be "null" if no options have been checked
    if (value === null) {
        return true;
    }

    return Array.isArray(value) && value.length < config.arguments[0];
}
