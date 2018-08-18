<template>
    <el-card>
        <el-form :model="form" :rules="rules" ref="form" label-position="top" class="flex flex-wrap -m-2">
            <div class="w-1/2 px-2">
                <el-form-item label="登录账号" prop="email">
                    <el-input v-model="form.account">
                    </el-input>
                </el-form-item>
            </div>
            <div class="w-1/2 px-2">
                <el-form-item label="新密码" prop="password">
                    <el-input type="password" v-model.trim="form.password" placeholder="不修改密码，请忽略">
                    </el-input>
                </el-form-item>
                <el-form-item label="确认新密码" prop="confirm_password">
                    <el-input type="password" v-model.trim="form.password_confirmation" placeholder="不修改密码，请忽略">
                    </el-input>
                </el-form-item>
            </div>
            <div class="w-full flex justify-center mt1">
                <el-button type="primary" @click="submit" :loading="isBtnLoading">保存</el-button>
            </div>
        </el-form>
    </el-card>
</template>

<script>
import {Form, FormItem, Input} from 'element-ui';

export default {
    components: {
        ElForm: Form,
        ElFormItem: FormItem,
        ElInput: Input,
    },
    props: [],
    data() {
        return {
            form: {
                account: this.$store.state.my.account,
            },
            rules: {
                account: [
                    {required: true, message: '请输入登录账号'},
                ],
            },
            isBtnLoading: false,
        };
    },
    computed: {},
    watch: {},
    methods: {
        submit() {
            this.$refs.form.validate((valid) => {
                if (!valid) return;
                this.isBtnLoading = true;
                API.put('my/profile', this.form)
                    .then((res) => {
                        return this.$store.dispatch('getMy');
                    })
                    .finally(() => (this.isBtnLoading = false));
            });
        },
    },
    mounted() {
    },
};
</script>

<style lang="scss">
</style>
