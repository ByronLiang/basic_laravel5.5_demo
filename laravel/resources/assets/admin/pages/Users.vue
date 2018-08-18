<template>
    <el-card>
        <form @submit.prevent="fetchData(1)" class="pb-6 flex">
            <div class="pr-3">
                <el-date-picker v-model="form.range_date" type="daterange" value-format="yyyy-MM-dd"
                                start-placeholder="注册开始日期"
                                end-placeholder="注册结束日期"/>
            </div>
            <div class="pr-3">
                <el-input placeholder="搜索关键字" v-model="form.keyword"/>
            </div>
            <div class="pr-6">
                <el-button native-type="submit">过滤</el-button>
            </div>
        </form>
        <el-table :data="list" v-loading="loading" size="mini">
            <el-table-column prop="id" label="ID" width="40"/>
            <el-table-column label="#">
                <template slot-scope="{$index, row}">
                    <div class="flex">
                        <div><img :src="row.avatar" class="rounded-full h-16 w-16"></div>
                        <div class="flex flex-col justify-around ml-1">
                            <div>{{ row.nickname }}</div>
                            <div>{{ row.account }}</div>
                        </div>
                    </div>
                </template>
            </el-table-column>
            <el-table-column prop="created_at" label="注册时间" width="140"/>
            <el-table-column min-width="150" label="操作" width="300">
                <template slot-scope="{$index, row}">
                    <router-link :to="`show/${row.id}`" append>
                        <el-button size="mini">编辑</el-button>
                    </router-link>
                    <el-button size="mini" @click="handleDelete($index, row)">
                        {{ row.deleted_at ? '正常' : '冻结' }}
                    </el-button>
                    <el-button type="danger" size="mini" @click="handleDelete($index, row, true)">删除</el-button>
                </template>
            </el-table-column>
        </el-table>
        <div class="text-center pt-3" v-show="loading && pagination.total">
            <el-pagination layout="total, prev, pager, next"
                           @current-change="fetchData"
                           :page-size="pagination.page_size"
                           :current-page="form.page"
                           :total="pagination.total">
            </el-pagination>
        </div>
    </el-card>
</template>

<script>
import {Table, TableColumn, Pagination, Input, DatePicker, Tag} from 'element-ui';

export default {
    components: {
        [Table.name]: Table,
        [TableColumn.name]: TableColumn,
        [Pagination.name]: Pagination,
        [Input.name]: Input,
        [DatePicker.name]: DatePicker,
        [Tag.name]: Tag,
    },
    filters: {},
    directive: {},
    data() {
        return {
            form: {
                page: 1,
            },
            pagination: {
                total: 0,
                page_size: 0,
            },
            list: [],
            loading: false,
        };
    },
    computed: {},
    watch: {
    },
    methods: {
        fetchData(page = null) {
            if (this.loading) return;
            if (page) this.form.page = page;

            this.loading = true;
            API.get('users', {params: this.form}).then((res) => {
                this.list = res.data;
                this.pagination.page_size = res.per_page;
                this.pagination.total = res.total;
            }).finally(() => this.loading = false);
        },
        async handleDelete(index, row, force = false) {
            let params = {};
            if (force && await $ele.$confirm('此操作不可逆，是否继续?', '删除警告', {type: 'warning'})) {
                params.ac = 'force';
            }
            API.delete('users/' + row.id, {params}).then((res) => this.fetchData());
        },
    },
    mounted() {
        this.fetchData();
    },
    beforeDestroy() {
    },
};
</script>
