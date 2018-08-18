export default {
    created() {
        if (this.form instanceof Object) {
            const query = this.$route.query;
            const params = this.form;
            for (const key in params) {
                if (Object.prototype.hasOwnProperty.call(params, key)) {
                    if (typeof query[key] === 'undefined') continue;
                    if (key.includes('page')) {
                        params[key] = +query[key];
                        continue;
                    }
                    if (key.includes('_id') && typeof query[key] === 'string') {
                        params[key] = +query[key];
                        continue;
                    }
                    if (Array.isArray(params[key]) && !Array.isArray(query[key])) {
                        params[key] = new Array(query[key]);
                        continue;
                    }
                    params[key] = query[key];
                }
            }
            this.form = params;
        }
    },
    watch: {
        loading(val) {
            if (this.form instanceof Object) {
                if (!val) this.$router.replace({query: this.form});
            }
        },
    },
};
