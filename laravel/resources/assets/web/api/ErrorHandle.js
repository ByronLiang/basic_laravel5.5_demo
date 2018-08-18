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
                        Msg.error(error[0]);
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
                    Msg.error('请登录后操作', '');
                    Vue.$router.push({
                        name: 'Auth.Login'
                    });
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
