export default {
    _key: 'formtacularForm',

    _storage: new WeakMap(),

    set: function (element, form) {
        if (!this._storage.has(element)) {
            this._storage.set(element, new Map());
        }
        this._storage.get(element).set(this._key, form);
    },

    get: function (element) {
        return this._storage.has(element) ? this._storage.get(element).get(this._key) : undefined;
    },

    has: function (element) {
        return this._storage.has(element) && this._storage.get(element).has(this._key);
    },

    remove: function (element) {
        if (!this._storage.has(element)) {
            return false;
        }

        return this._storage.get(element).delete(this._key) && this._storage.delete(element);
    }
}
