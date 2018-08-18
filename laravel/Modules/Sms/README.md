# 短信发送
#### 注：你可以对里面的方法进行完善，但是严禁往里面丢业务逻辑相关代码

```php
// xxxxRequest.php

    public function rules()
    {
        $this->exception[] = 'captcha';
        return [
            'phone' => 'required|digits:11',
            'captcha' => ['required', new \Modules\Sms\Rules\Captcha($this->phone)],
        ];
    }
```

```php
$sms = new \Modules\Sms\Sms();

(new \Modules\Sms\Captcha())->send($phone);
(new \Modules\Sms\Captcha())->check($phone, $captcha);
```