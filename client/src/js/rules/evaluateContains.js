import getFieldValue from '../utils/getFieldValue';

export default (form, config) => {
    const value = getFieldValue(form, config);
    return typeof value === 'string' && value.contains(config.arguments[0]);
}
