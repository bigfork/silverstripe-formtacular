import getFieldValue from '../utils/getFieldValue';

export default (form, config) => {
    const value = getFieldValue(form, config);
    return Array.isArray(value) && value.includes(config.arguments[0]);
}
