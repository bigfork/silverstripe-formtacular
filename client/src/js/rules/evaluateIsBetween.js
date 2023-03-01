/**
 * Override with window['formtacular_evaluateIsBetween'] = (form, config) => {}
 */
export default (form, config) => {
    let value = window.formtacular_getFieldValue(form, config);
    if (value === null) {
        return false;
    }

    value = parseFloat(value);
    return value > parseFloat(config.arguments[0]) && value < parseFloat(config.arguments[1]);
}
