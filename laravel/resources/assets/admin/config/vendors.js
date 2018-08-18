// https://date-fns.org/docs/format
Date.prototype.format = function(dirtyFormatStr, dirtyOptions) {
    return require('date-fns/format/index.js')(this, dirtyFormatStr, dirtyOptions);
};

/* ============
 * fastclick
 * ============
 *
 * Polyfill to remove click delays on browsers with touch UIs
 *
 * https://github.com/ftlabs/fastclick
 */
// import FastClick from 'fastclick'
// FastClick.attach(document.body);

if ('addEventListener' in document && window.FastClick) {
    document.addEventListener('DOMContentLoaded', (e) => {
        FastClick.attach(document.body);
    }, false);
}

/* ============
 * axios
 * ============
 *
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 *
 * https://github.com/mzabriskie/axios
 */
window.axios = require('axios');
window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
};

/* ============
 * store.js
 * ============
 *
 * https://github.com/marcuswestin/store.js
 */
const StoreEngine = require('store/src/store-engine');

/**
 * SessionStore.get('key')
 * SessionStore.set('key', 'value')
 * SessionStore.set('key', 'value', new Date().getTime()+ 2 * 60 * 1000)
 */
window.SessionStore = StoreEngine.createStore([
    require('store/storages/sessionStorage'),
], [
    require('store/plugins/expire'),
]);
/**
 * LocalStore.get('key')
 * LocalStore.set('key', 'value')
 */
// window.LocalStore = StoreEngine.createStore([
//     require('store/storages/localStorage'),
// ]);
