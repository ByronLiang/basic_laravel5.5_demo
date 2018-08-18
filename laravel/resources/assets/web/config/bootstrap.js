import './vendors';

/* ============
 * Vue
 * ============
 *
 * Vue.js is a library for building interactive web interfaces.
 * It provides data-reactive components with a simple and flexible API.
 *
 * http://vuejs.org/guide/
 */
import Vue from 'vue';

/* ============
 * Vuex Store
 * ============
 *
 * The store of the application
 *
 * http://vuex.vuejs.org/en/index.html
 */
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store(require('../store').default);

/* ============
 * Vue Router
 * ============
 *
 * The official Router for Vue.js. It deeply integrates with Vue.js core
 * to make building Single Page Applications with Vue.js a breeze.
 *
 * http://router.vuejs.org/en/index.html
 */
import VueRouter from 'vue-router';

Vue.use(VueRouter);

export const router = new VueRouter(require('./router'));
router.beforeEach(async (to, from, next) => {
    // 调整校验路径方式
    let checkRoute = ['/chat_room', '/my_profile', '/my_setting'];
    const res = checkRoute.find((item) => to.path == item);
    // const checkRoute = from.path === '/' && !from.name && to.path !== '/login';
    // await store.dispatch('getMy');

    // if (checkRoute && !store.state.my) {
    //     next('/login');
    // }
    await store.dispatch('getMy');
    if (res && !store.state.my) {
        next('/login');
    }
    next();
});
router.afterEach((to, from) => {
    if (to.name === from.name) return;

    window.scrollTo(0, 1);
});
Vue.prototype.$location = require('common/helpers/location');

/* ============
 * element-ui
 * ============
 *
 * A Vue.js 2.0 UI Toolkit for Web.
 *
 * https://github.com/ElemeFE/element
 */

import {Loading, MessageBox, Message} from 'element-ui';

Vue.use(Loading.directive);

window.$ele = {
    $loading: Loading.service,
    $msgbox: MessageBox,
    $alert: MessageBox.alert,
    $confirm: MessageBox.confirm,
    $prompt: MessageBox.prompt,
    $message: Message,
};

// 全局api接口请求处理
import Api from '../api';

/**
 * @type {AxiosInstance}
 */
window.API = new Api();

// 微信签名，进入页面是签一次
// import {wxConfig} from '../api/Wechat';
// wxConfig();
