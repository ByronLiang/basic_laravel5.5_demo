<template>
    <el-menu router class="container-menu" ref="menu"
             :default-openeds="defaultOpeneds"
             :default-active="activeMenu">
        <template v-for="(route, index) in menus">
            <el-menu-item :index="route.name" :route="route" :key="index" v-if="route.meta && route.meta.showNav">
                <i class="iconfont" :class="[route.meta.ico]" aria-hidden="true"></i>
                <span slot="title">{{route.meta.title}}</span>
            </el-menu-item>
        </template>
    </el-menu>
</template>

<script>
import {MenuItem, Menu} from 'element-ui';
import {mapState} from 'vuex';
import RouterMenusFilter from 'web/config/RouterMenusFilter';

export default {
    components: {
        ElMenu: Menu,
        ElMenuItem: MenuItem,
    },
    props: ['collapse'],
    data() {
        return {
            activeMenu: '',
            defaultOpeneds: [],
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
        background: #001529 url('/images/nav_bg.png') bottom/cover no-repeat;
        overflow-y: auto;
        height: calc(100vh - 44px);
        position: sticky;
        top: 0;
        z-index: 1;

        &:not(.el-menu--collapse) {
            width: 240px;
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
            &, i {
                color: #fff;
                font-weight: bold;
            }

            span {
                font-size: 14px;
                margin-left: 10px;
            }

            &:hover, &:hover i, &:focus {
                color: #fff;
                background-color: transparent;
            }
            &.is-active {
                color: #fff;
                background-color: #0A439B;
            }

            height: 62px;
            line-height: 62px;
            padding-left: 74px !important;
        }
    }
</style>
