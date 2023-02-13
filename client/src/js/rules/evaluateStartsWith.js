import getFieldValue from '../utils/getFieldValue';

export default (form, config) => {
    const value = getFieldValue(form, config);
    return typeof value === 'string' && value.startsWith(config.arguments[0]);
}
