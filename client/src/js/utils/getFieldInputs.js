/**
 * Given a form element and field configuration data (name, ids etc), get a list of form fields
 * that need to be watched for change events. For a single field, like a select or text input,
 * an array with one element should be returned.
 *
 * Can be overridden by setting window['formtacular_getFieldInputs'] = (form, config) => {}
 */
export default (form, { fieldName, fieldID, holderID }) => {
    const formEl = form.getFormElement();

    const byFieldID = formEl.querySelector(`#${fieldID}`);
    if (byFieldID) {
        return [byFieldID];
    }

    const byHolderAndNameExactMatch = formEl.querySelectorAll(`#${holderID} [name="${fieldName}"]`);
    if (byHolderAndNameExactMatch.length) {
        return byHolderAndNameExactMatch;
    }

    const byNameExactMatch = formEl.querySelectorAll(`[name="${fieldName}"]`);
    if (byNameExactMatch.length) {
        return byNameExactMatch;
    }

    const byHolderAndNameStartsWith = formEl.querySelectorAll(`#${holderID} [name^="${fieldName}"]`);
    if (byHolderAndNameStartsWith.length) {
        return byHolderAndNameStartsWith;
    }

    return formEl.querySelectorAll(`[name^="${fieldName}"]`);
}
