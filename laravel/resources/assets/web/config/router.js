const lazyLoading = (name) => process.env.NODE_ENV === 'development' ?
    () => import(`../pages/${name}.vue`) : require(`../pages/${name}.vue`);
// const Loading = (name, index = false) => require(`../pages/${name}.vue`);

const DefaultIndex = {template: '<router-view :key="$route.fullpath"></router-view>'};

module.exports = {
    base: '/',
    // history,hash
    mode: 'history',
    routes: [
        {
            path: '/login',
            name: 'Login',
            component: lazyLoading('Welcome'),
        }, {
            path: '/',
            component: require('../components/layout/Container.vue'),
            redirect: {
                name: 'Home',
            },
            children: [
                {
                    name: 'Home',
                    path: 'home',
                    component: lazyLoading('Dashboard'),
                    meta: {
                        title: '主页',
                    },
                },
            ],
        }, {
            path: '*',
            redirect: '/',
        },
    ],
};
