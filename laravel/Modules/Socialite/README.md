# 第三方授权登录

#### 注意
- 你可以对里面的方法进行完善，但是严禁往里面丢业务逻辑相关代码
- 为了后期获取 open_id 方便，微信登录：unique_id 不存储 union_id

### 给模型添加关系

在你的模型里里面添加下面这句
```php
use \Modules\Socialite\SocialiteTrait;
```

### 微信通过 openID 查找第三方登录信息
```php
\Modules\Socialite\Entities\Socialite::whereWechatId('2342', '234324')->get();
```
