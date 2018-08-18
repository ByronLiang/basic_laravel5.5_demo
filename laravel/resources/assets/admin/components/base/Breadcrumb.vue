<template>
    <el-breadcrumb separator="/" class="breadcrumb" v-if="breadcrumbs && breadcrumbs.length">
        <el-breadcrumb-item v-for="(item, index) in breadcrumbs" :to="item.path || '/'" :key="item.name">
            {{ item.meta.title }}
        </el-breadcrumb-item>
    </el-breadcrumb>
</template>

<script>
    import {Breadcrumb, BreadcrumbItem} from 'element-ui';

    export default {
        components: {
            ElBreadcrumb: Breadcrumb,
            ElBreadcrumbItem: BreadcrumbItem,
        },
        computed: {
            breadcrumbs() {
                let ret = [];
                const params = this.$route.params;
                const val = this.$parent && this.$parent.$route && this.$parent.$route.matched;

                if (val) {
                    ret = val.filter((i) => i.path).map(i => {
                        if (!i.path) return i;
                        for (const key in params) {
                            i.path = i.path.replace(':' + key, params[key]);
                        }
                        return i;
                    });
                }

                return ret;
            }
        },
    }
</script>

<style scoped>

</style>