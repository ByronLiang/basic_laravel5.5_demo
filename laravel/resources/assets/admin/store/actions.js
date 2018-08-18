/**
 * http://vuex.vuejs.org/zh-cn/actions.html
 * Action 提交的是 mutation，而不是直接变更状态。
 * Action 可以包含任意异步操作。
 */
import {my} from '../api/Cache';
export default {
    getMy({commit}) {
        return my(commit);
    },
};
