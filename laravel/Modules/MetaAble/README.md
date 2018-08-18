# 扩展模型

本模块是基于 [laravel-metable](https://github.com/plank/laravel-metable) [docs](http://laravel-metable.readthedocs.io/en/latest/) ， 如有使用问题请自行查询文档

#### 注意
- 你可以对里面的方法进行完善，但是严禁往里面丢业务逻辑相关代码
- 为了后期获取 open_id 方便，微信登录：unique_id 不存储 union_id

## 给模型添加关系

在你的模型里里面添加下面这句
```php
use Modules\AggregationPay\AggregationPayInterface

class XXXXXX extends Model implements AggregationPayInterface {
    use \Modules\MetaAble\MetaAbleTrait;
}
```

```php
$xxx = XXXXXX::find($id);
$xxx->setMeta($key, $value);
```
