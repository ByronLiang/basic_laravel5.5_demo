<template>
    <div class="welcome-wrapper flex flex-col justify-between items-center">
        <div class="py-4"></div>

        <section class="pb-4">
            <header class="gaoqi-leading__header">
                <div>科技管理信息系统</div>
                <div>Science and technology management information system</div>
            </header>

            <!-- login, reset password -->
            <login v-if="type == 0" v-model="type"></login>

            <!-- register -->
            <register v-else-if="type == 1" v-model="type"></register>

            <!-- renew -->
            <renew v-else v-model="type"></renew>
        </section>
    </div>
</template>

<script>
import Login from '../components/page/welcome/Login.vue';
import Register from '../components/page/welcome/Register.vue';
import Renew from '../components/page/welcome/Renew.vue';

export default {
    components: {
        Login,
        Register,
        Renew,
    },
    data() {
        return {
            type: 0, // 0: 登录/忘记密码, 1: 注册, 2: 企业账号登录后进入的页面
        };
    },
    watch: {},
    methods: {},
    created() {},
};
</script>

<style lang="scss">
    @import '../scss/abstracts';

    .welcome {
        &-wrapper {
            width: 100vw;
            height: 100vh;
            min-width: min-content;
            min-height: min-content;
            background: #fff url('/images/login_bg.png') center/cover;

            @keyframes flipin {
                from { transform: rotateY(180deg); }
                to   { transform: rotateY(0); }
            }

            @keyframes flipout {
                from { transform: rotateY(180deg);}
                to   { transform: rotateY(0);}
            }

            @keyframes fadein {
                from { opacity: .2; }
                to   { opacity: 1; }
            }

            .flip-action {
                animation: .45s flipin;
                backface-visibility: hidden;
            }

            .flip-out {
                animation: .6s flipout;
                backface-visibility: hidden;
            }

            .fade-in {
                animation: 1s fadein;
            }
        }
    }
</style>
