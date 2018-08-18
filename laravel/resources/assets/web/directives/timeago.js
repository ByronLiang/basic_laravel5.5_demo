/* ============
 * timeago
 * ============
 *
 * https://github.com/hustcc/timeago.js/blob/master/README_zh.md
 */
import timeago from 'timeago.js/dist/timeago';

const timeagoInstance = timeago();
/**
 * 实时变动
 * v-timeago="2017-12-16 7:8:9"
 */
export default {
    bind(el, binding, vnode) {
        el.setAttribute('data-timeago', binding.value);
        timeagoInstance.render(el, 'zh_CN');
    },
    unbind(el, binding, vnode) {
        timeagoInstance.cancel(el);
    },
};
