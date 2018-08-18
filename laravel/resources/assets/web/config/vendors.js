// https://date-fns.org/docs/format
Date.prototype.format = function(dirtyFormatStr, dirtyOptions) {
    return require('date-fns/format/index.js')(this, dirtyFormatStr, dirtyOptions);
};

// const mathjs = require('mathjs/core').create();
//
// // mathjs.import(require('mathjs/lib/expression/function/eval'));
// mathjs.import(require('mathjs/lib/function/arithmetic/add'));
// mathjs.import(require('mathjs/lib/function/arithmetic/subtract'));
// mathjs.import(require('mathjs/lib/function/arithmetic/multiply'));
// mathjs.import(require('mathjs/lib/function/arithmetic/divide'));
// mathjs.import(require('mathjs/lib/function/arithmetic/mod'));
//
// Math.add = mathjs.add;
// Math.subtract = mathjs.subtract;
// Math.multiply = mathjs.multiply;
// Math.divide = mathjs.divide;
// Math.mod = mathjs.mod;

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
        window.FastClick.attach(document.body);
    }, false);
}

/* ============
 * detector
 * ============
 *
 * 浏览环境判断
 *
 * https://github.com/hotoo/detector
 */
// window.detector = require('detector/web/web-detector');

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
    require('store/plugins/observe'),
]);
/**
 * LocalStore.get('key')
 * LocalStore.set('key', 'value')
 */
// window.LocalStore = StoreEngine.createStore([
//     require('store/storages/localStorage'),
// ]);
