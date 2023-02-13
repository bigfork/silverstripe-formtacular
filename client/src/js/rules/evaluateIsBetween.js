import getFieldValue from '../utils/getFieldValue';

export default (form, config) => {
    let value = getFieldValue(form, config);
    if (value === null) {
        return false;
    }

    value = parseFloat(value);
    return value > parseFloat(config.arguments[0]) && value < parseFloat(config.arguments[1]);
}
