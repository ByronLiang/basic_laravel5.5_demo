<template>
    <form class="login-form">
        <fieldset class="pb-6">
        <legend align="center" class="text-center">欢迎注册</legend>
        <div class="flex line items-center relative">
            <label for="phone" class="iconfont icon-phone"></label>
            <input type="text" id="phone" placeholder="请输入手机号" v-model="form.phone">
        </div>

        <div class="flex line items-center relative">
            <label for="password" class="iconfont icon-password"></label>
            <input type="password" id="password" placeholder="请输入密码" v-model="form.password">
        </div>

        <div role="submit" class="btn-auth-submit" @click="onSubmit" style="margin-top: 20px">
            <template v-if="logging">
                <i class="el-icon-loading mr-2"></i>注册中...
            </template>
            <template v-else>注册</template>
        </div>
        </fieldset>
    </form>
</template>

<script>
import {Input, Form, FormItem, Cascader} from 'element-ui';

export default {
    components: {
        ElInput: Input,
        ElForm: Form,
        ElFormItem: FormItem,
        ElCascader: Cascader,
    },
    data() {
        return {
            districtOptions: [],
            logging: false,
            form: {
                phone: '',
                captcha: '',
                password: '',
                password_confirmation: '',
            },
            step: 0,
            interval: null,
            seconds: 60,
        };
    },
    methods: {
        /**
         * submit form
         * @api: register
         * @return null
         */
        onSubmit() {
            this.logging = true;
            API.post('register', this.form).then((res) => {
                $ele.$message.success('注册成功');
                SessionStore.set('my', res);
                this.$store.commit('setMy', res);
                this.$router.push('/');
            }).catch((err) => {
                $ele.$message.error('注册失败， 原因：' + err);
            }).finally(() => {this.logging = false});
        },
    },
};
</script>

<style lang="scss">
    @import '../../../scss/abstracts';

    .login-form {
        width: 44rem;
        padding: 2.6rem 4rem 3rem;
        margin-bottom: 12rem;
        border-radius: .5rem;
        background: #fff;
        transition: .6s;

        fieldset {
            position: relative;

            legend {
                position: relative;
                color: #000;
                font-size: 2rem;
                margin-bottom: 5rem;

                &::after {
                    position: absolute;
                    left: 10%;
                    bottom: -1rem;
                    width: 80%;
                    height: .3rem;
                    background-color: $main-color;
                    content: '';
                }
            }

            label.iconfont {
                font-size: 1.8rem;
                color: $light-grey;
                padding: 0 .6rem .3rem;
            }

            input {
                border: 0;
                padding: 0 1.6rem;
                line-height: 5rem;
                width: 100%;
            }

            .line {
                border-bottom: 1px solid $light-grey;
            }

            .main-wraning {
                line-height: 5rem;
                transform: scale(0);
                opacity: 1;
                transition: .16s;

                &.validate {
                    transform: scale(1);
                }
            }
        }

        .forget-pwd.btn-auth-submit {
            margin-top: 4rem;
            margin-bottom: 1rem;
        }

        .icon-arrow-l {
            position: absolute;
            top: .8rem;
            left: 0;
            color: $main-color;
            font-size: 2rem;
        }
    }
</style>
