export default (input, handler) => {
    input.addEventListener('input', handler);
    input.addEventListener('change', handler);
}
