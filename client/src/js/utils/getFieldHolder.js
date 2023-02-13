export default (form, config) => {
    const formEl = form.getFormElement();
    return formEl.querySelector(`#${config.holderID}`)
        || formEl.querySelector(`#${config.fieldID}`)
        || formEl.querySelector(`#${config.fieldName}`);
}
