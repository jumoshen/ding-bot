<?php

namespace DingBot\Services;

use GuzzleHttp\Client;

class DingBotService
{
    /**
     * @var Client $httpClient
     */
    protected $httpClient;

    protected $accessToken;

    /**
     * DingBotService constructor.
     * @param $accessToken
     */
    public function __construct($accessToken)
    {
        $this->httpClient = new Client([
            'headers'  => [
                'Content-Type' => 'application/json',
                'Charset'      => 'utf-8',
            ],
            'base_uri' => 'https://oapi.dingtalk.com/',
            'verify'   => false,
        ]);

        $this->accessToken = $accessToken;
    }

    /**
     * @param $text
     * @param array $atMobiles
     * @param null $callBack
     * @throws \Exception
     */
    public function text($text, $atMobiles = [], $callBack = null)
    {
        if (!$text) return;

        $data = [
            'msgtype' => 'text',
            'text'    => [
                'content' => $text,
            ],
            'at'      => [
                'atMobiles' => $atMobiles
            ]
        ];

        $this->response('/robot/send?access_token=' . $this->accessToken, 'post', [
            'json' => $data,
        ], $callBack);
    }

    /**
     * @param $text
     * @param array $atMobiles
     * @param null $callBack
     * @throws \Exception
     */
    public function markdown($text, $atMobiles = [], $callBack = null)
    {
        if (!$text) return;

        $data = [
            'msgtype'  => 'markdown',
            'markdown' => [
                "title" => $text,
                'text'  => $text,
            ],

            'at' => [
                'atMobiles' => $atMobiles
            ]
        ];

        $this->response('/robot/send?access_token=' . $this->accessToken, 'post', [
            'json' => $data,
        ], $callBack);
    }

    /**
     * @param $url
     * @param string $method
     * @param array $data
     * @param $callBack
     * @throws \Exception
     */
    private function response($url, $method = 'post', $data = [], $callBack)
    {
        $response = $this->httpClient->$method($url, $data);

        $statusCode = $response->getStatusCode();

        $result = json_decode($response->getBody(), true);

        if($result){
            if (($statusCode != 200) || (isset($result['errcode']) && $result['errcode'] != 0)) throw new \Exception($result['errmsg'], 400);
        }else{
            throw new \Exception('未知错误，请稍后重试', 400);
        }

        if (is_callable($callBack)) {
            $callBack($response);
        }
    }
}