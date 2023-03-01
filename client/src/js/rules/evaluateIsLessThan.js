/**
 * Override with window['formtacular_evaluateIsLessThan'] = (form, config) => {}
 */
export default (form, config) => {
    let value = window.formtacular_getFieldValue(form, config);
    if (value === null) {
        return false;
    }

    return parseFloat(value) < parseFloat(config.arguments[0]);
}
