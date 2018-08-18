<template>
    <el-card>
        <tinymce v-model="form.content"></tinymce>
    </el-card>
</template>

<script>
export default {
    components: {
        Tinymce: () => import('admin/components/base/Tinymce'),
    },
    props: [],
    data() {
        return {
            form: {
                content: '',
                content2: '',
            },
        };
    },
    computed: {},
    watch: {},
    methods: {},
    mounted() {
    },
    beforeDestroy() {
    },
};
</script>

<style lang="scss">
</style>
