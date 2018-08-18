<template>
    <el-container class="container-fluid">
        <container-menu :collapse="isCollapse"></container-menu>
        <el-container>
            <el-header class="flex items-center justify-between">
                <el-button type="text" @click="isCollapse = !isCollapse">
                    <i class="fa " :class="isCollapse ? 'fa-indent' : 'fa-outdent'" aria-hidden="true"></i>
                </el-button>
                <el-dropdown trigger="click" v-if="my">
                    <div class="click-area flex ">
                        <!--<div><img class="avatar" src="https://picsum.photos/50/?random"></div>-->
                        <div class="flex flex-col justify-around">
                            <div>{{ my.account || 'admin' }}</div>
                        </div>
                    </div>
                    <el-dropdown-menu slot="dropdown">
                        <el-dropdown-item @click.native="$router.push('/my-profile')">个人信息</el-dropdown-item>
                        <el-dropdown-item @click.native="logout">注销</el-dropdown-item>
                    </el-dropdown-menu>
                </el-dropdown>
            </el-header>

            <el-main>
                <!--<breadcrumb></breadcrumb>-->
                <router-view></router-view>
            </el-main>

            <el-footer height="auto">Copyright © 2018 Ganguo</el-footer>
        </el-container>
    </el-container>
</template>

<script>
import {Container, Header, Main, Footer, Dropdown, DropdownMenu, DropdownItem} from 'element-ui';
import {mapState} from 'vuex';
import debounce from 'lodash/debounce';
// import Breadcrumb from './Breadcrumb';
import ContainerMenu from './ContainerMenu';

export default {
    components: {
        ElContainer: Container,
        ElHeader: Header,
        ElMain: Main,
        ElFooter: Footer,
        ElDropdown: Dropdown,
        ElDropdownMenu: DropdownMenu,
        ElDropdownItem: DropdownItem,

        // Breadcrumb,
        ContainerMenu,
    },
    props: [],
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
    },
    methods: {
        logout() {
            const loadingInstance = $ele.$loading();
            API.get('my/logout').then((res) => {
                loadingInstance.close();
                this.$router.push('/login');
            });
        },
    },
    created() {
        this.activeMenu = this.$route.name;

        this.isCollapse = document.body.clientWidth < 1400;
        window.onresize = debounce(() => {
            const screenWidth = document.body.clientWidth;
            this.isCollapse = screenWidth < 1400;
        }, 150);
    },
};
</script>

<style lang="scss">
    .container-fluid {
        min-height: 100vh;
        color: rgba(0, 0, 0, 0.65);

        > .el-container {
            > .el-header {
                width: 100%;
                height: 60px;
                color: rgba(0, 0, 0, 0.65);
                background: #fff;
                box-shadow: 0 1px 4px rgba(0, 21, 41, 0.08);
                position: sticky;
                top: 0;
                z-index: 1;

                .hamburger{
                    margin-left: -20px;
                }

                .click-area {
                    cursor: pointer;
                }
                .avatar {
                    display: inline-block;
                    width: 40px;
                    height: 40px;
                    padding: 2px;
                    margin-right: 10px;
                    border-radius: 50%;
                    cursor: pointer;
                    overflow: hidden;
                    vertical-align: middle;
                    border: 1px solid #ddd;
                }
            }

            > .el-main, > .el-footer{
                background: #f0f2f5;
            }
        }
    }
</style>
