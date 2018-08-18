const lazyLoading = (name) => process.env.NODE_ENV === 'development' ?
    () => import(`../pages/${name}.vue`) : require(`../pages/${name}.vue`);
// const Loading = (name, index = false) => require(`../pages/${name}.vue`);

const DefaultIndex = {template: '<router-view :key="$route.fullpath"></router-view>'};

module.exports = {
    base: '/admin/',
    // history,hash
    mode: 'history',
    routes: [
        {
            path: '/login',
            component: lazyLoading('Login'),
        }, {
            path: '/',
            component: require('../components/layout/Container.vue'),
            redirect: {
                name: 'Dashboard',
            },
            children: [
                {
                    name: 'Dashboard',
                    path: 'dashboard',
                    component: lazyLoading('Dashboard'),
                    meta: {
                        title: '信息面板',
                    },
                }, {
                    name: 'U',
                    path: 'users',
                    component: lazyLoading('Users'),
                    meta: {
                        title: '用户管理',
                    },
                }, {
                    name: 'From',
                    path: 'from',
                    component: DefaultIndex,
                    redirect: {
                        name: 'From.List',
                    },
                    meta: {
                        title: '表单例子',
                    },
                    children: [
                        {
                            name: 'From.List',
                            path: 'editor',
                            component: lazyLoading('From/Editor'),
                            meta: {
                                title: '编辑器',
                            },
                        },
                    ],
                }, {
                    name: 'MyProfile',
                    path: 'my-profile',
                    component: lazyLoading('MyProfile'),
                },
            ],
        }, {
            path: '*',
            redirect: '/',
        },
    ],
};
