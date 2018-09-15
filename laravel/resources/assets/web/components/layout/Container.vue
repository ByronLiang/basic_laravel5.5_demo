<template>
    <el-container class="container-fluid">
        <el-header class="flex items-center justify-between" height="44px">
            <header>xxx</header>
            <el-popover
                v-if="my"
                width="255"
                trigger="click"
                placement="bottom-end"
                popper-class="container-setting__wrapper"
                class="setting cursor-pointer"
                v-model="popoverVisible">
                <ul class="list-reset">
                    <li @click="popoverVisible = false;">个人中心</li>
                    <li @click="popoverVisible = false;">消息</li>
                    <li @click="onLogout">退出</li>
                </ul>
                <section slot="reference">
                    <i class="iconfont icon-setting align-middle"></i>
                    <span class="inline-block align-middle">系统设置</span>
                </section>
            </el-popover>
            <router-link to="/login" v-else>
                <el-button type="normal">登录</el-button>
            </router-link>
        </el-header>

        <el-container>
            <!-- <el-aside :width="isCollapse ? '64px' : '240px'">
                <container-menu :collapse="isCollapse"></container-menu>
            </el-aside> -->

            <el-main>
                <!--<breadcrumb></breadcrumb>-->
                <router-view></router-view>
            </el-main>
        </el-container>
    </el-container>
</template>

<script>
import {Container, Header, Aside, Main, Footer, Dropdown, DropdownMenu, DropdownItem, Popover, Button} from 'element-ui';
import {mapState} from 'vuex';
// import debounce from 'lodash/debounce';
// import Breadcrumb from './Breadcrumb';
// import ContainerMenu from './ContainerMenu';

export default {
    components: {
        ElContainer: Container,
        ElHeader: Header,
        ElAside: Aside,
        ElMain: Main,
        ElFooter: Footer,
        ElDropdown: Dropdown,
        ElDropdownMenu: DropdownMenu,
        ElDropdownItem: DropdownItem,
        ElPopover: Popover,
        ElButton: Button,
        // Breadcrumb,
        // ContainerMenu,
    },
    props: [],
    data() {
        return {
            activeMenu: '',
            defaultOpeneds: [],
            isCollapse: false,
            popoverVisible: false,
        };
    },
    computed: {
        ...mapState([
            'my',
        ]),
    },
    methods: {
        onLogout() {
            this.popoverVisible = false;
            this.$router.push({
                name: 'Welcome',
            });
        },
    },
    created() {
        this.activeMenu = this.$route.name;
    },
};
</script>

<style lang="scss">
    .container-fluid {
        min-height: 100vh;
        color: rgba(0, 0, 0, 0.65);

        > .el-header {
            width: 100%;
            height: 44px;
            color: rgba(0, 0, 0, 0.65);
            background: #fff;
            box-shadow: 0 1px 4px rgba(0, 21, 41, 0.08);
            position: sticky;
            top: 0;
            z-index: 10;

            > header {
                color: #000;
                font-size: 16px;
            }

            .setting {
                color: #4A4A4A;
                font-size: 14px;
                line-height: 20px;

                > i {
                    font-size: 20px;
                }
            }
        }

        > .el-container {
            > .el-main{
                padding: 0;
                background: #F4F8F9;
            }
        }
    }

    .container-setting__wrapper {
        ul {
            margin: -12px;
        }

        li {
            height: 3.6rem;
            line-height: 3.6rem;

            color: #666;
            font-size: 1.6rem;
            padding: 0 1.6rem;
            cursor: pointer;

            &:hover {
                color: #fff;
                background-color: #00B4FF;
            }
        }
    }
</style>
