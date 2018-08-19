
<h1 align="center">Weather</h1>

<p align="center">:rainbow: 基于百度地图接口的 PHP 天气信息组件。</p>

[![Build Status](https://travis-ci.org/overtrue/weather.svg?branch=master)](https://travis-ci.org/overtrue/weather) 
![StyleCI build status](https://github.styleci.io/repos/144818004/shield)  

## 安装

```sh
$ composer require overtrue/weather -vvv
```

## 配置

在使用本拓展之前，你需要去 [百度地图](http://lbsyun.baidu.com/index.php?title=car/api/weather) 注册账号，然后创建应用，获取应用的 `ak` 值

## 使用
## 使用

```php
use Overtrue\Weather\Weather;

$ak = 'xxxxxxxxxxxxxxxxxxxxxxxxxxx';

$weather = new Weather($ak);

// 返回数组格式
$response = $weather->getWeather('深圳');

// 批量获取
$response = $weather->getWeather('深圳|北京');

// 返回 XML 格式
$response = $weather->getWeather('深圳', 'xml');

// 按坐标获取
$response = $weather->getWeather('116.30,39.98', 'json');

// 批量坐标获取
$response = $weather->getWeather('116.43,40.75|120.22,43,33', 'json');

// 自定义坐标格式（coord_type）
$response = $weather->getWeather('116.306411,39.981839', 'json', 'bd09ll');
```

### 参数说明

```
array | string   getWeather(string $location, string $format = 'json', string $coordType = null)
```

> 参数说明：
> - `$location` - 支持经纬度和城市名两种形式，一次请求最多支持 15 个城市，之间用 "|" 分隔，同一个城市的经纬度之间用 "," 分隔。举例：`$location = "116.43,40.75|120.22,43,33"` 或者是 `$location = "北京|上海|广州"` 。
> - `$format`  - 输出的数据格式，默认为 json 格式，当 output 设置为 ’xml’ 时，输出的为 xml 格式的数据。
> - `$coordType` - 请求参数坐标类型，默认为 `gcj02` 经纬度坐标。允许的值为 `bd09ll`、`bd09mc`、`gcj02`、`wgs84`。`bd09ll` 表示百度经纬度坐标，`bd09mc`表示百度墨卡托坐标，`gcj02` 表示经过国测局加密的坐标。`wgs84` 表示 `gps` 获取的坐标。
> - 详情说明请参考官方：http://lbsyun.baidu.com/index.php?title=car/api/weather

### 在 Laravel 中使用

在 Laravel 中使用也是同样的安装方式，配置写在 `config/services.php` 中：

```php
	.
	.
	.
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
use Overtrue\Weather\Weather;

...

public function edit(Weather $weather) 
{
    $response = $weather->get('深圳');
}
```

#### 服务名访问

```php
	public function edit() 
	{
		$response = app('weather')->get('深圳');
	}

```

## 参考

- [百度地图天气接口](http://lbsyun.baidu.com/index.php?title=car/api/weather)

## License

MIT
