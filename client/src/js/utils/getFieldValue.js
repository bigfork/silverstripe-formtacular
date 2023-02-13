import getFieldInputs from './getFieldInputs';

export default (form, config) => {
    const formData = new FormData(form.getFormElement());
    if (formData.get(config.fieldName) !== null) {
        return formData.get(config.fieldName);
    }

    // Fields like checkboxes/multi-selects are stored differently, so we have to extract the values manually
    let value = null;
    for (const pair of formData.entries()) {
        if (pair[0].startsWith(config.fieldName)) {
            value = value || [];
            value.push(pair[1]);
        }
    }

    return value;
}
