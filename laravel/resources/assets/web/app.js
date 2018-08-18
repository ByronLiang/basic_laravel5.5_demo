import 'babel-polyfill';
import 'core-js/modules/es7.promise.finally';

import Vue from 'vue';
import './config/bootstrap';

/**
 * variable | placeholder(type)
 */
Vue.filter('placeholder', require('./filters/placeholder').default);

window.vm = new Vue({
    el: '#content',
    components: require('./components'),
});
