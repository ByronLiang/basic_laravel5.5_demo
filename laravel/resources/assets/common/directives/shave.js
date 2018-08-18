/**
 * https://github.com/dollarshaveclub/shave/
 * Shave is a zero dependency javascript plugin that truncates multi-line text to fit within an html element based on
 * a set max-height.
 * It then stores the diff of the original text string in a hidden <span> element following the visible text.
 * This means the original text remains intact!
 * Shave是一个零依赖javascript插件，它根据set max-height截断多行文本以适应html元素。
 * 然后，它将原始文本字符串的diff存储在可见文本后面的隐藏<span>元素中。
 * 这意味着原始文本保持不变！
 */
import shave from 'shave/dist/shave.es.js';

/**
 * v-shave:maxheight="options"
 * v-shave:48="{classname: 'js-hidden', character: '...'}"
 */
export default {
    bind(el, binding, vnode) {
        shave(el, binding.arg || 24, binding.value);
    },
};
