import state from './state';
import mutations from './mutations';
import actions from './actions';
import getters from './getters';

export default {
    state,
    getters,
    actions,
    mutations,
    strict: process.env.NODE_ENV !== 'production',
    plugins: [
    ],
};
