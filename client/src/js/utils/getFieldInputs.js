export default (form, config) => {
    const formEl = form.getFormElement();

    const byFieldID = formEl.querySelector(`#${config.fieldID}`);
    if (byFieldID) {
        return [byFieldID];
    }

    const byHolderAndNameExactMatch = formEl.querySelectorAll(`#${config.holderID} [name="${config.fieldName}"]`);
    if (byHolderAndNameExactMatch.length) {
        return byHolderAndNameExactMatch;
    }

    const byNameExactMatch = formEl.querySelectorAll(`[name="${config.fieldName}"]`);
    if (byNameExactMatch.length) {
        return byNameExactMatch;
    }

    const byHolderAndNameStartsWith = formEl.querySelectorAll(`#${config.holderID} [name^="${config.fieldName}"]`);
    if (byHolderAndNameStartsWith.length) {
        return byHolderAndNameStartsWith;
    }

    return formEl.querySelectorAll(`[name^="${config.fieldName}"]`);
}
