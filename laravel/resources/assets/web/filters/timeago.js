/* ============
 * timeago
 * ============
 *
 * https://github.com/hustcc/timeago.js/blob/master/README_zh.md
 */
import timeago from 'timeago.js/dist/timeago.min';

/**
 * 固定值
 * variable | timeago
 */
export default (value) => {
    return timeago().format(value, 'zh_CN');
};
