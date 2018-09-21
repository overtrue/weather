<?php

/*
 * This file is part of the overtrue/weather.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Overtrue\Weather;

use GuzzleHttp\Client;
use Overtrue\Weather\Exceptions\HttpException;
use Overtrue\Weather\Exceptions\InvalidArgumentException;

/**
 * Class Weather.
 */
class Weather
{
    /**
     * @var string
     */
    protected $key;

    /**
     * @var array
     */
    protected $guzzleOptions = [];

    /**
     * Weather constructor.
     *
     * @param string $key
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * @return \GuzzleHttp\Client
     */
    public function getHttpClient()
    {
        return new Client($this->guzzleOptions);
    }

    /**
     * @param array $options
     */
    public function setGuzzleOptions(array $options)
    {
        $this->guzzleOptions = $options;
    }

    /**
     * @param string $city
     * @param string $format
     *
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @throws \Overtrue\Weather\Exceptions\HttpException
     * @throws \Overtrue\Weather\Exceptions\InvalidArgumentException
     */
    public function getLiveWeather($city, $format = 'json')
    {
        return $this->getWeather($city, 'base', $format);
    }

    /**
     * @param string $city
     * @param string $format
     *
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @throws \Overtrue\Weather\Exceptions\HttpException
     * @throws \Overtrue\Weather\Exceptions\InvalidArgumentException
     */
    public function getForecastsWeather($city, $format = 'json')
    {
        return $this->getWeather($city, 'all', $format);
    }

    /**
     * @param string $city
     * @param string $type
     * @param string $format
     *
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @throws \Overtrue\Weather\Exceptions\HttpException
     * @throws \Overtrue\Weather\Exceptions\InvalidArgumentException
     */
    public function getWeather($city, $type = 'base', $format = 'json')
    {
        $url = 'https://restapi.amap.com/v3/weather/weatherInfo';

        if (!\in_array(\strtolower($format), ['xml', 'json'])) {
            throw new InvalidArgumentException('Invalid response format: '.$format);
        }

        if (!\in_array(\strtolower($type), ['base', 'all'])) {
            throw new InvalidArgumentException('Invalid type value(base/all): '.$type);
        }

        $format = \strtolower($format);
        $type = \strtolower($type);

        $query = array_filter([
            'key' => $this->key,
            'city' => $city,
            'output' => $format,
            'extensions' => $type,
        ]);

        try {
            $response = $this->getHttpClient()->get($url, [
                'query' => $query,
            ])->getBody()->getContents();

            return 'json' === $format ? \json_decode($response, true) : $response;
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
