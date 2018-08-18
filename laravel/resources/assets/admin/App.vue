<template>
    <router-view></router-view>
</template>

<script>
export default {
    watch: {
        '$route.matched': {
            handler(val) {
                val = val.filter((i) => i.meta && i.meta.title);
                let title;
                const defaultSiteTitle = this.$store.state.site_title;
                if (val.length) {
                    title = val[val.length - 1].meta.title;
                }
                if (title) {
                    document.title = title + ' - ' + defaultSiteTitle;
                } else if (document.title !== defaultSiteTitle) {
                    document.title = defaultSiteTitle;
                }
            },
            immediate: true,
        },
    },
};
</script>
