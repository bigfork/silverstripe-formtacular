/**
 * Given a form element and field configuration data (name, ids etc), get the field holder
 * element. Typically this is fetched using the holderID (#Form_FieldName_holder) but we fall
 * back to using the field itself in case that element doesn't exist in bespoke templates
 *
 * Can be overridden by setting window['formtacular_getFieldHolder'] = (form, config) => {}
 */
export default (form, { fieldName, fieldID, holderID }) => {
    const formEl = form.getFormElement();
    return formEl.querySelector(`#${holderID}`)
        || formEl.querySelector(`#${fieldID}`)
        || formEl.querySelector(`#${fieldName}`);
}
