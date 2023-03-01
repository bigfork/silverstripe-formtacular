/**
 * Given a form field element and field configuration data (name, ids etc), bind change events that
 * will trigger conditional visibility checks.
 *
 * Can be overridden by setting window['formtacular_bindChangeEvent'] = (input, handler) => {}
 */
export default (input, handler) => {
    input.addEventListener('input', handler);
    input.addEventListener('change', handler);
}
