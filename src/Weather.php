<?php

/*
 * This file is part of the overtrue/weather.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled.
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
    protected $ak;

    /**
     * @var string|null
     */
    protected $sn;

    /**
     * @var array
     */
    protected $guzzleOptions = [];

    /**
     * Weather constructor.
     *
     * @param string      $ak
     * @param string|null $sn
     */
    public function __construct(string $ak, string $sn = null)
    {
        $this->ak = $ak;
        $this->sn = $sn;
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
     * @param string      $location
     * @param string      $format
     * @param string|null $coordType
     *
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @throws \Overtrue\Weather\Exceptions\HttpException
     * @throws \Overtrue\Weather\Exceptions\InvalidArgumentException
     */
    public function getWeather(string $location, string $format = 'json', string $coordType = null)
    {
        $url = 'http://api.map.baidu.com/telematics/v3/weather';

        if (!\in_array($format, ['xml', 'json'])) {
            throw new InvalidArgumentException('Invalid response format: '.$format);
        }

        $query = array_filter([
            'ak' => $this->ak,
            'sn' => $this->sn,
            'location' => $location,
            'output' => $format,
            'coord_type' => $coordType,
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
