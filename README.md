
# Weather

基于百度地图接口的 PHP 天气信息组件。

## 安装

```sh
$ composer require overtrue/weather -vvv
```

## 配置

在使用本拓展之前，你需要去 [百度地图](http://lbsyun.baidu.com/index.php?title=car/api/weather) 注册账号，然后创建应用，获取应用的 `ak` 值

## 使用

```php
use Overtrue\Weather\Weather;

$ak = 'xxxxxxxxxxxxxxxxxxxxxxxxxxx';

$weather = new Weather($ak);

// 返回数组格式
$response = $weather->getWeather('深圳');

// 批量获取
$response = $weather->getWeather('深圳,北京');

// 返回 XML 格式
$response = $weather->getWeather('深圳', 'xml');

// 按坐标获取
$response = $weather->getWeather('116.306411,39.981839', 'json');

// 自定义坐标格式（coord_type）
$response = $weather->getWeather('116.306411,39.981839', 'json', 'bd09ll');
```

### 参数说明
```
array | string   getWeather(string $location, string $format = 'json', string $coordType = null)
```

> - $location 地点，中文或者坐标地址，多个用斗角逗号隔开
> - $format 返回格式， `json`(默认)/`xml`, `json` 将会返回数组格式，`xml` 返回字符串格式。
> - $coordType 坐标格式，允许的值为`bd09ll`、`bd09mc`、`gcj02`、`wgs84`，默认为 `gcj02` 经纬度坐标。
> 详情说明请参考官方：http://lbsyun.baidu.com/index.php?title=car/api/weather

### 在 Laravel 中使用

在 Laravel 中使用也是同样的安装方式，配置写在 `config/services.php` 中：

```php
     'weather' => [
            'ak' => env('BAIDU_WEATHER_AK'),
            'sn' => env('BAIDU_WEATHER_SN'), 
    ],
```

然后在 `.env` 中配置（`BAIDU_WEATHER_SN` 为可选）：

```env
BAIDU_WEATHER_AK=
BAIDU_WEATHER_SN=
```

可以用两种方式来获取 `Overtrue\Weather\Weather` 实例：

#### 方法参数注入

```php
	public function edit(Weather $weather) 
	{
			$response = $weather->get('深圳');
	}
```

#### 服务名访问

```php
$response = app('weather')->get('深圳');
```

## 参考

- [百度地图天气接口](http://lbsyun.baidu.com/index.php?title=car/api/weather)

## License

MIT
