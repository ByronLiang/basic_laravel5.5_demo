export default class {
    constructor(my, routes) {
        this.my = my;
        this.routes = routes;
    }

    /**
     * 返回右侧菜单项
     * @returns {*}
     */
    menus() {
        if (!this.my) return [];
        const base = this.routes.find((i) => i.path === '/');
        return this.filterMenus(base.children);
    }

    /**
     * 判断是否可以访问，不可以则返回可以访问的路由
     * @param route
     * @returns {*}
     */
    notAccess(route) {
        if (!this.roleJudgment(route)) {
            return this.menus()[0];
        }
        return false;
    }

    /**
     * 角色权限判断
     * @param route
     * @returns {boolean}
     */
    roleJudgment(route) {
        if (!this.my) return false;
        if (this.my.id === 1) return true;

        if (!route.meta) return false;
        if (!route.meta.roles) return true;
        if (!route.meta.roles.length) return false;

        return route.meta.roles.includes(this.my.role_id);
    }

    /**
     * 过滤返回可以显示的菜单
     * @param arr
     */
    filterMenus(arr) {
        return arr.filter((route) => {
            if (!route.meta) return false;
            if (!route.meta.title) return false;
            if (route.meta.disabled) return false;

            return this.roleJudgment(route);
        }).map((v, index) => {
            if (v.children && v.children.length) {
                v.children = this.filterMenus(v.children);
            }
            if (v.children && !v.children.length) {
                delete v.children;
            }
            if (v.component) delete v.component;

            // 设定默认展开
            // if (index <= 2 && v.children && v.children.length) this.defaultOpeneds.push(v.name);
            return v;
        });
    }
}
