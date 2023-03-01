/**
 * Override with window['formtacular_evaluateIsNotEmpty'] = (form, config) => {}
 */
export default (form, config) => {
    const value = window.formtacular_getFieldValue(form, config);
    if (Array.isArray(value)) {
        return value.length > 0;
    }

    return (value + '').trim().length !== 0;
}
