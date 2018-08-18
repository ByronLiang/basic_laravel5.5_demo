<template>
    <el-menu router class="container-menu" ref="menu"
             :collapse="collapse"
             :default-openeds="defaultOpeneds"
             :default-active="activeMenu">
        <template>
            <router-link class="site" to="/" tag="li">
                <i class="fab fa-bandcamp" aria-hidden="true"></i>
                <span class="title">{{ $store.state.site_title }}</span>
            </router-link>
        </template>
        <template v-for="(route, index) in menus">
            <template v-if="route.children">
                <el-submenu :index="route.name" :key="index">
                    <template slot="title">
                        <i :class="route.meta.ico || 'fa fa-list-ul'" aria-hidden="true"></i>
                        <span>{{route.meta.title}}</span>
                    </template>
                    <el-menu-item v-for="(cRoute, cIndex) in route.children"
                                  :key="cIndex"
                                  :index="cRoute.name"
                                  :route="cRoute">
                        <span slot="title">{{cRoute.meta.title}}</span>
                    </el-menu-item>
                </el-submenu>
            </template>

            <template v-if="!route.children">
                <el-menu-item :index="route.name" :route="route" :key="index">
                    <i class="fa fa-list-ul" aria-hidden="true"></i>
                    <span slot="title">{{route.meta.title}}</span>
                </el-menu-item>
            </template>
        </template>
    </el-menu>
</template>

<script>
import {MenuItem, Menu, Submenu} from 'element-ui';
import {mapState} from 'vuex';
import RouterMenusFilter from 'admin/config/RouterMenusFilter';

export default {
    components: {
        ElMenu: Menu,
        ElMenuItem: MenuItem,
        ElSubmenu: Submenu,
    },
    props: ['collapse'],
    data() {
        return {
            activeMenu: '',
            defaultOpeneds: [],
            isCollapse: false,
        };
    },
    computed: {
        ...mapState([
            'my',
        ]),
        menus() {
            return (new RouterMenusFilter(this.my, this.$router.options.routes)).menus();
        },
    },
    watch: {
        '$route.matched'(val, oldVal) {
            this.setActiveMenu();
        },
    },
    methods: {
        setActiveMenu() {
            const matched = this.$route.matched.filter((i) => i.meta && i.meta.title);
            if (matched.length) {
                this.activeMenu = matched[matched.length - 1].name;
                return;
            }
            this.activeMenu = this.$route.name;
        },
    },
    created() {
        this.setActiveMenu();
    },
};
</script>

<style lang="scss">
    .container-menu {
        flex-grow: 0;
        flex-shrink: 0;
        border-right: 0;
        background: #001529;
        overflow-y: auto;
        height: 100vh;
        position: sticky;
        top: 0;
        z-index: 1;

        .site {
            height: 60px;
            line-height: 60px;
            padding-left: 20px;
            transition: all .3s;
            background: #002140;
            overflow: hidden;
            white-space: nowrap;
            color: #fff;
            font-size: 20px;
            font-weight: bold;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        &.el-menu--collapse {
            .site .title {
                opacity: 0;
            }

            .el-submenu .el-menu-item {
                background: #001529;
            }
        }

        &:not(.el-menu--collapse) {
            width: 256px;
        }

        .el-menu, .el-footer {
            background-color: transparent;
        }

        .el-submenu {
            &__title {
                &, & i {
                    color: rgba(255, 255, 255, 0.65);

                    &:hover, &:hover i {
                        color: #fff;
                        background-color: transparent;
                    }
                }
            }

            &.is-active {
                .el-submenu__title {
                    &, & i {
                        color: #fff;
                    }
                }
            }
        }

        .el-menu-item {
            color: rgba(255, 255, 255, 0.65);

            &:hover, &:hover i, &:focus {
                color: #fff;
                background-color: transparent;
            }
            &.is-active {
                color: #fff;
                background-color: #1890ff;
            }
        }

        .el-menu-item, .el-submenu__title {
            height: 40px;
            line-height: 40px;
        }
    }
</style>
