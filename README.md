# `yar` 扩展在 `lumen` 框架中的简单封装

## 客户端

### 配置

- `config/service.php`

```php
<?php

return [
    'goods_service' => [
        'remote' => env('GOODS_SERVICE_REMOTE')
    ],
    'shop_service' => [
        'remote' => env('SHOP_SERVICE_REMOTE')
    ]
    // ...
];
```

- `bootstrap/app.php`

```php
$app->configure('service');
```

### 调用

```php
try 
{

    $result = (new oldSmokeGun\Rpc\Client\Client(config('service.goods_service.remote'), 'Demo'))
        ->call('Foo', ['name' => 'bob']);

    dd($result);

} catch (Yar_Client_Exception $exception) {
    // TODO
}
```

## 服务器端

> 注意： 路由 `/rpc/{service}` 已被注册

### 配置

- `bootstrap/app.php`

```php
$app->register(oldSmokeGun\Rpc\Providers\RpcServiceProvider::class);
```

### 使用

- `App/Services` 目录下新建 `Demo.php`

```php
<?php

namespace App\Services;

class Demo
{
    public function foo()
    {
        return 'this is demo';
    }

}
```
