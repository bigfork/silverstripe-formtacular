/**
 * Given a form element and field configuration data (name, ids etc), get the value of the field
 * for evaluation by visibility rules. The value could be a string for text fields, or an array
 * of data for fields like checkboxes
 *
 * Can be overridden by setting window['formtacular_getFieldValue'] = (form, config) => {}
 */
export default (form, config) => {
    const formData = new FormData(form.getFormElement());
    if (formData.get(config.fieldName) !== null) {
        return formData.get(config.fieldName);
    }

    // Fields like checkboxes/multi-selects are stored differently, so we have to extract the values manually
    let value = null;
    for (const pair of formData.entries()) {
        // Array values like FieldName[]
        if (pair[0].startsWith(`${config.fieldName}[`)) {
            value = value || [];
            value.push(pair[1]);
        }
    }

    return value;
}
