import getFieldValue from '../utils/getFieldValue';

export default (form, config) => {
    return getFieldValue(form, config) === config.arguments[0];
}
