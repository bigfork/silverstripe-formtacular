import getFieldValue from '../utils/getFieldValue';

export default (form, config) => {
    const value = getFieldValue(form, config);
    if (Array.isArray(value)) {
        return value.length === 0;
    }

    return (value + '').trim().length === 0;
}
