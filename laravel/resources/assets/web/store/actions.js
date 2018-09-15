/**
 * http://vuex.vuejs.org/zh-cn/actions.html
 * Action 提交的是 mutation，而不是直接变更状态。
 * Action 可以包含任意异步操作。
 */
export default {
    async getMy({commit}) {
        let my = SessionStore.get('my');

        if (!my) {
            await API.get('profile')
                .then((res) => {
                    my = res;
                    SessionStore.set('my', res);
                })
                .catch(() => my = null);
        }

        if (my) commit('setMy', my);
        return my;
    },
};
