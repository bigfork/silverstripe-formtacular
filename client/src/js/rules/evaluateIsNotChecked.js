import getFieldValue from '../utils/getFieldValue';

export default (form, config) => {
    return !getFieldValue(form, config);
}
