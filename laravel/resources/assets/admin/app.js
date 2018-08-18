import 'babel-polyfill';
import 'core-js/modules/es7.promise.finally';

import Vue from 'vue';
import App from './App.vue';
import * as bootstrap from './config/bootstrap';

/**
 * variable | placeholder(type)
 */
Vue.filter('placeholder', require('./filters/placeholder').default);

window.vm = new Vue({
    ...App,
    ...bootstrap,
}).$mount('#app');
