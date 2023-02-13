import getFieldValue from '../utils/getFieldValue';

export default (form, config) => {
    let value = getFieldValue(form, config);
    if (value === null) {
        return false;
    }

    return parseFloat(value) > parseFloat(config.arguments[0]);
}
