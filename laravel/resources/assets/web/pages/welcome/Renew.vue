<template>
    <div class="renew-wrapper relative">
        <!-- 续费首页 -->
        <section class="renew-index" v-if="!type">
            <header class="text-center relative leading-loose">
                <span class="font-20">高企创新信息管理公司</span>

                <div class="absolute pin-r pin-t">
                    <span
                        class="btn-orange border-orange px-2"
                        @click="$router.push({name: 'Welcome'})">
                        进入业务系统
                    </span>
                    <span class="btn-shine-blue border-shine-blue px-2">修改admin密码</span>
                    <span class="btn-default border-grey" :style="{padding: '0 1rem'}">退出登录</span>
                </div>
            </header>

            <section class="renew-form mt-4">
                <div class="gaoqi-control-bar__wrapper text-right w-full">
                    <span class="border-shine-blue btn-shine-blue" @click="onEdit">修改</span>
                </div>

                <el-form
                    :model="form"
                    ref="formOne"
                    label-position="top"
                    label-width="80px"
                    class="flex flex-wrap gaoqi-base-form__disabled px-8 pt-8">
                    <el-form-item
                        label="企业名称"
                        prop="company_name"
                        :rules="{message: '请输入企业名称', required: true}">
                        <el-input
                            v-model="form.company_name"
                            :disabled="!isEdit"
                            placeholder="请输入企业名称">
                        </el-input>
                    </el-form-item>

                    <el-form-item
                        label="公司行业"
                        prop="industry"
                        :rules="{message: '请输入公司行业', required: true}">
                        <el-input
                            v-model="form.industry"
                            :disabled="!isEdit"
                            placeholder="请输入公司行业">
                        </el-input>
                    </el-form-item>

                    <el-form-item
                        label="企业法人"
                        prop="corporate"
                        :rules="{message: '请输入企业法人', required: true}">
                        <el-input
                            v-model="form.corporate"
                            :disabled="!isEdit"
                            placeholder="请输入企业法人">
                        </el-input>
                    </el-form-item>

                    <el-form-item
                        label="联系人"
                        prop="contact"
                        :rules="{message: '请输入联系人', required: true}">
                        <el-input
                            v-model="form.contact"
                            :disabled="!isEdit"
                            placeholder="请输入联系人">
                        </el-input>
                    </el-form-item>

                    <el-form-item
                        label="企业所在地"
                        prop="location"
                        :rules="{message: '请选择企业所在地', required: true}">
                        <el-cascader
                            class="w-full"
                            :options="districtOptions"
                            v-model="form.location"
                            :disabled="!isEdit"
                            :props="{value: 'id', label: 'fullname'}"
                            placeholder="请选择企业所在地">
                        </el-cascader>
                    </el-form-item>

                    <el-form-item
                        label="详细地址"
                        prop="address"
                        :rules="{message: '请输入详细地址', required: true}">
                        <el-input
                            v-model="form.address"
                            :disabled="!isEdit"
                            placeholder="请输入详细地址">
                        </el-input>
                    </el-form-item>

                    <el-form-item
                        label="企业域名"
                        prop="domain"
                        :rules="{message: '请输入企业域名', required: true}">
                        <template v-if="setDomain">
                            <el-input
                                v-model="form.domain"
                                :disabled="!isEdit"
                                placeholder="请输入企业域名">
                            </el-input>
                        </template>

                        <template v-else>
                            <span class="pl-6">{{ form.domain }}</span>
                        </template>
                    </el-form-item>

                    <el-form-item label="使用到期时间" required>
                        <span class="pl-6">2019-03-10到期 (剩余4天)</span>
                    </el-form-item>
                </el-form>
            </section>

            <div class="item">
                <header class="is-required">购买套餐</header>
                <span
                    v-for="combo in combos"
                    :key="'combo-' + combo.id"
                    @click="onSelect('combo', combo.id)"
                    class="combo relative"
                    :class="{'is-selected': combo.id === selectIds.combo}">
                    <header class="text-center">{{ combo.name }}</header>
                    <div class="price text-center">￥{{ combo.price }}</div>
                </span>
            </div>

            <div class="item">
                <header class="is-required">支付方式</header>
                <span
                    v-for="type in payTypes"
                    :key="'pay-' + type.id"
                    @click="onSelect('payType', type.id)"
                    class="pay-type relative"
                    :class="{'is-selected': type.id === selectIds.payType}">
                    <i class="iconfont" :class="'icon-' + type.icon"></i>
                    <span class="price text-center">{{ type.name }}</span>
                </span>
            </div>
        </section>

        <!-- 线下转账页面 -->
        <section class="renew-pay" v-else>
            <header align="center" class="text-center">线下转账</header>
            <i class="iconfont icon-arrow-l cursor-pointer" @click="type = 0"></i>

            <div class="item">
                <header class="is-required">汇款账号</header>
                <article class="account">
                    账号名称  <span>&nbsp;(中国工商银行)</span>
                    <br />
                    <span class="num">6229  0000 0000 0000</span>
                </article>
            </div>
            <div class="item statement">
                <header class="is-required">汇款说明</header>
                <article class="statement">
                    <div class="indent-2">
                        汇款成功后，请及时拨打XXX联系XXX公司开通系统账号。
                        该账户为对公账户，请确认无误后汇款，汇款时间在几点，
                        到账后账户会自动开通，请用户自行登录查看，
                        如果登录不了，请联系我们的客服电话400-000-0000
                    </div>
                    <br />
                    <div class="indent-2">
                        该账户为对公账户，请确认无误后汇款，汇款时间在几点，
                        到账后账户会自动开通，请用户自行登录查看，请联系我们的客服电话400-000-0000。
                    </div>
                </article>
            </div>
        </section>

        <div role="submit" class="btn-auth-submit" @click="nextStep">{{ type ? '完成' : '下一步' }}</div>
    </div>
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
            type: 0, // 0: 首页, 1: 线下转账页面
            isEdit: false,
            combos: [
                {
                    id: 1,
                    name: '半年套餐卡',
                    price: 600,
                }, {
                    id: 2,
                    name: '一年套餐卡',
                    price: 1100,
                },
            ],
            payTypes: [
                {
                    id: 1,
                    name: '支付宝',
                    icon: 'alipay',
                }, {
                    id: 2,
                    name: '微信',
                    icon: 'wechat',
                }, {
                    id: 3,
                    name: '线下转账',
                    icon: 'translate',
                },
            ],
            selectIds: {
                combo: 1,
                payType: 1,
            },
            form: {
                company_name: '高企创新信息管理公司',
                industry: '公司行业',
                corporate: '企业法人',
                contact: '联系人',
                location: ['110000', '110101'],
                address: '详细地址',
                domain: '',
            },
            districtOptions: [],
            setDomain: true,
        };
    },
    watch: {
        isEdit(val) {
            if (this.form.domain && this.setDomain) {
                this.setDomain = false;
            }
        },
    },
    methods: {
        nextStep() {
            if (!this.type) return ++this.type;
        },
        onSelect(objKey, id) {
            this.selectIds[objKey] = id;
        },
        onEdit() {
            if (this.isEdit) {
                // 保存
                // API.post('', this.form);
            }

            this.isEdit = !this.isEdit;
        },
        editCompany() {
            let params = {};
            API.put('companies/' + id, params);
        },
        submitOrder() {
            let params = {
                company_id: 1,
                package: 'half-a-year', // 半年套餐half-a-year 一年套餐a-year
            };
            API.post('orders', params);
        },
        payment() {
            let params = {
                id: 1, // 订单id
                type: 'order',
                channel: 'test', // 支付渠道:alipay_app,wechat_app,wechat_applet,test
                open_id: 1, // wechat_applet,根据情况传
            };
            API.post('pays', params);
        },
    },
    async created() {
        await API.get('https://xhtx.dev.ganguo.hk/api/common/district/').then((res) => {
            this.districtOptions = res;
        });
    },
};
</script>

<style lang="scss">
    @import '../../../scss/abstracts';

    .renew {
        &-wrapper {
            padding: 2.8rem 4rem 2.6rem;
            border-radius: .5rem;
            background: #fff;

            header.is-required::before {
                display: inline-block;
                vertical-align: middle;
                margin-right: .8rem;

                content: '\e93b';
                font-size: .5em;
                font-style: normal;
                color: $main-warning;
                font-family: 'iconfont' !important;
                -webkit-font-smoothing: antialiased;
            }

            .gaoqi-control-bar__wrapper {
                padding: .7rem 1rem;
            }
        }

        &-form {
            // padding: 0 2.4rem;
            border-radius: .2rem;
            border: 1px solid #ccc;

            .el-form-item {
                width: 31%;
                margin-right: 3%;

                &:nth-of-type(3n) {
                    margin-right: 0;
                }
            }
        }

        &-index {
            width: 91rem;
            min-width: 91rem;
            margin: 0 auto 2rem;
            border-radius: .2rem;

            .item {
                padding: 2rem 2rem 0;

                > header {
                    font-size: 1.6rem;
                    margin-bottom: 1rem;
                }
            }

            .combo,
            .pay-type {
                display: inline-block;
                border: 1px solid #ccc;
                border-radius: .5rem;
                overflow: hidden;

                &:nth-of-type(1) {
                    margin-left: 1.6rem;
                }

                &.is-selected {
                    border: 1px solid $main-color;
                }

                &.is-selected::after {
                    color: $main-color;
                    content: '\e601';
                    position: absolute;
                    right: -.2rem;
                    top: -.2rem;
                    font-size: 2rem;
                    font-family: "iconfont" !important;
                    font-style: normal;
                    -webkit-font-smoothing: antialiased;
                }
            }

            .combo {
                padding: 1.4rem 4rem;
                margin-right: 1.2rem;

                .price {
                    font-size: 1.8rem;
                    color: $main-warning;
                    margin-top: .6rem;
                    line-height: 1;
                }
            }

            .pay-type {
                padding: 1rem 1.6rem;
                margin-right: 1rem;

                .iconfont {
                    font-size: 3.4rem;
                    margin-right: 1rem;
                    vertical-align: middle;
                }

                .icon-alipay { color: #01ADF3;}
                .icon-wechat { color: #07B906;}
                .icon-translate { color: #DF6320;}
            }
        }
        &-pay {
            width: 74.8rem;
            border-radius: .5rem;

            > header {
                position: relative;
                width: 4em;
                color: #000;
                font-size: 2rem;
                margin: 0 auto 5rem;

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

            .icon-arrow-l{
                position: absolute;
                top: 3.4rem;
                left: 4rem;
                color: $main-color;
                font-size: 2rem;
            }


            article {
                padding: 2rem 1.6rem 4rem;

                &.account {
                    font-size: 1.8rem;
                    color: $main-color;
                    line-height: 2;
                    span {
                        font-size: 1.4rem;
                    }

                    .num {
                        font-size: 2rem;
                    }
                }

                &.statement {
                    color: #4A4A4A;
                    line-height: 1.5;
                }

                .indent-2 {
                    text-indent: 2em;
                }
            }
        }
    }
</style>
