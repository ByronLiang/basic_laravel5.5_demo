/**
 * https://github.com/julmot/mark.js
 * Highlight keywords using JavaScript. Intended for every use case.
 * 使用JavaScript突出显示关键字。适用于每个用例。
 */
import Mark from 'mark.js/dist/mark.es6.min.js';

/**
 * v-mark="keyword"
 * v-mark="{keyword, options}"
 */
export default {
    bind(el, {value}, vnode) {
        let keyword = [];
        let options = {};
        if (value instanceof Object) {
            if (value.length) {
                keyword = value;
            } else if (value.keyword && value.keyword.length) {
                keyword = value.keyword;
            } else if (value.options instanceof Object) {
                options = value.options;
            }
        }
        new Mark(el).mark(keyword, options);
    },
};
