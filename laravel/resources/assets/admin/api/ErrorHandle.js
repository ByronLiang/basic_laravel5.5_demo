export default class {
    constructor(data) {
        this.error = data;
        for (let error of this.errors()) {
            if (error.code !== data.code) {
                continue;
            }
            if (error.message) {
                $ele.$message.error(error.message);
                continue;
            }
            if (typeof error.method === 'function') {
                error.method();
            }
            break;
        }
    }

    errors() {
        return [
            /*
            {
                code: 10000,
                method: () => {
                    for (let k in this.error.data) {
                        let error = this.error.data[k];
                        $ele.$message(error[0]);
                        break;
                    }
                }
            },
            {
                code: 10001,
                message: '该用户已注册'
            },
            {
                code: 10003,
                method: () => {
                    Mint.MessageBox.confirm('请登录后操作', '').then(
                        action => {
                            Vue.$router.push({
                                name: 'Auth.Login'
                            });
                        },
                        action => {}
                    );
                    if (Vue.$store.state.token) {
                        Vue.$store.commit('updateToken', null);
                    }
                }
            },
            {
                code: 500001,
                message: '用户未注册'
            }
            */
        ];
    }
}
