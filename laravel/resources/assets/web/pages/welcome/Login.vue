<template>
    <form class="login-form">
        <!-- 登录 -->
        <fieldset class="pb-6" v-if="tab == 0" :class="{'flip-action': tab == 0}">
            <legend align="center" class="text-center">欢迎登录</legend>

            <div class="flex line items-center relative">
                <label for="phone" class="iconfont icon-phone"></label>
                <input type="text" id="phone" placeholder="请输入手机号" v-model="login.phone">
                <i
                    class="el-icon-circle-close main-wraning absolute pin-t pin-r"
                    :class="{validate: !login.phone && !validate}">
                </i>
            </div>

            <div class="flex line items-center relative">
                <label for="password" class="iconfont icon-password"></label>
                <input type="password" id="password" placeholder="请输入密码" v-model="login.password">
                <i
                    class="el-icon-circle-close main-wraning absolute pin-t pin-r"
                    :class="{validate: !login.password && !validate}">
                </i>
            </div>

            <div class="flex items-center justify-between my-8">
                <span class="cursor-pointer main-color" @click="++tab">忘记密码</span>
                <span class="cursor-pointer main-color" @click="$emit('input', 1)">立即注册</span>
            </div>

            <div role="submit" class="btn-auth-submit" @click="onLogin">
                <template v-if="logging">
                    <i class="el-icon-loading mr-2"></i>登录中...
                </template>
                <template v-else>登录</template>
            </div>
        </fieldset>

        <!-- 忘记密码 -->
        <fieldset v-else-if="tab == 1" :class="{'flip-out': tab == 1}">
            <legend align="center" class="text-center">忘记密码</legend>
            <i class="iconfont icon-arrow-l cursor-pointer" @click="--tab"></i>

            <div class="flex line items-center relative">
                <label for="phone" class="iconfont icon-phone"></label>
                <input type="text" id="phone" placeholder="请输入手机号" v-model="form.phone">
                <i
                    class="el-icon-circle-close main-wraning absolute pin-t pin-r"
                    :class="{validate: !form.phone && !validate}">
                </i>
            </div>

            <div class="flex line items-center justify-between">
                <div class="flex items-center relative">
                    <label for="code" class="iconfont icon-code"></label>
                    <input type="text" id="code" placeholder="请输入验证码" v-model="form.captcha">
                    <i
                        class="el-icon-circle-close main-wraning absolute pin-t pin-r"
                        :class="{validate: !form.captcha && !validate}">
                    </i>
                </div>
                <span class="btn-captcha" :class="{'is-forbid': seconds < 60}" @click="getCode">
                    {{ seconds === 60 ? '获取验证码' : '重试(' + seconds + 's)' }}
                </span>
            </div>

            <div role="submit" class="btn-auth-submit forget-pwd" @click="onNext">下一步</div>
        </fieldset>

        <!-- 重置密码 -->
        <fieldset v-else-if="tab == 2" :class="{'fade-in': tab === 2}">
            <legend align="center" class="text-center">重置密码</legend>
            <i class="iconfont icon-arrow-l cursor-pointer" @click="--tab"></i>

            <div class="flex line items-center relative">
                <label for="password" class="iconfont icon-password"></label>
                <input type="password" id="password" placeholder="请输入新密码" v-model="form.password">
                 <i
                    class="el-icon-circle-close main-wraning absolute pin-t pin-r"
                    :class="{validate: !form.password && !validate}">
                </i>
            </div>

            <div class="flex line items-center relative">
                <label for="password_confirmation" class="iconfont icon-password"></label>
                <input
                    type="password"
                    id="password_confirmation"
                    placeholder="请再次输入新密码"
                    v-model="form.password_confirmation">
                 <i
                    class="el-icon-circle-close main-wraning absolute pin-t pin-r"
                    :class="{validate: !form.password_confirmation && !validate}">
                </i>
            </div>

            <div role="submit" class="btn-auth-submit forget-pwd" @click="onSubmit">完成</div>
        </fieldset>
    </form>
</template>

<script>
export default {
    data() {
        return {
            login: {
                phone: '',
                password: '',
            },
            form: {
                phone: '',
                captcha: '',
                password: '',
                password_confirmation: '',
            },
            tab: 0,
            logging: false,
            validate: true, // true: 验证通过, false: 不通过
            interval: null,
            seconds: 60,
            rule: {
                phone: /^1(3[0-9]|4[579]|5[0-3,5-9]|7[0135678]|8[0-9])\d{8}$/,
            },
        };
    },
    watch: {
        tab() {
            this.validate = true;
        },
    },
    methods: {
        /**
         * login button
         * @return null
         */
        onLogin() {
            if (this.logging) return;

            // validate
            if (!this.login.phone || !this.login.password) {
                this.validate = false;
                return $ele.$message.error('手机号码/密码 不能为空');
            }

            this.validate = false;
            if (!this.rule.phone.test(this.login.phone)) {
                return $ele.$message.error('请填写正确手机号码');
            }

            let pwdLen = this.login.password.length;
            if (pwdLen < 6 || pwdLen > 20) {
                this.login.password = '';
                return $ele.$message.error('密码长度为6-20');
            }

            this.validate = true;

            // logging
            this.logging = true;

            API.post('login', this.login)
                .then((res) => {
                    $ele.$message.success({
                        message: '登录成功',
                        duration: 1000,
                    });

                    SessionStore.set('my', res);
                    this.$store.commit('setMy', res);
                    this.$router.push('/');
                })
                .catch((err) => {
                    $ele.$message.error('登录失败， 错误原因：' + err.message);
                })
                .finally(() => {
                    setTimeout(() => {
                        this.validate = true;
                        this.logging = false;
                    }, 1000);
                });
        },
        getCode() {
            if (!this.form.phone) return $ele.$message.error('请输入手机号码');
            if (!this.rule.phone.test(this.form.phone)) {
                this.form.phone = '';
                return $ele.$message.error('请填写正确手机号码');
            }
            if (this.seconds < 60) return;

            this.seconds--;
            this.interval = setInterval(() => {
                if (--this.seconds <= 0) {
                    clearInterval(this.interval);
                    this.seconds = 60;
                }
            }, 1000);
        },
        onNext() {
            if (!this.form.phone || !this.form.captcha) {
                this.validate = false;
                return $ele.$message.error('手机号码/验证码 不能为空');
            }

            if (!this.rule.phone.test(this.form.phone)) {
                this.form.phone = '';
                return $ele.$message.error('请填写正确手机号码');
            }

            ++this.tab;
            this.validate = true;
        },
        onSubmit() {
            if (!this.form.password || !this.form.password_confirmation) {
                this.validate = false;
                return $ele.$message.error('新密码 不能为空');
            }

            if (this.form.password !== this.form.password_confirmation) {
                return $ele.$message.error('两次密码不一致， 请检查。');
            }

            this.validate = true;
            API.post('resetpwd', this.form).then((res) => {
                $ele.$message.success('重置密码成功!');
                this.$router.push({
                    name: 'Information.List',
                });
            }).catch((err) => {
                $ele.$message.error('重置密码失败， 错误原因：' + err);
            });
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
