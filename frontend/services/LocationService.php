<?php

namespace frontend\services;

use GuzzleHttp\Client;
use yii\helpers\Json;
use yii\web\Request;

class LocationService
{
    protected $data;
    protected $token = 'e666f398-c983-4bde-8f14-e3fec900592a';
    protected $format = 'json';
    protected $base_uri = 'https://geocode-maps.yandex.ru/';
    protected $uri = '1.x';
    protected $client;


    /**
     * LocationService constructor.
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->base_uri
        ]);
    }

    /**
     * @param string $address
     * @return array
     */

    protected function sendResponse(string $address)
    {
        $response = $this->client->request('GET', $this->uri, [
            'query' => [
                'apikey' => $this->token,
                'geocode' => $address,
                'format' => $this->format
            ]
        ]);

        return Json::decode($response->getBody()->getContents(), true);
    }

    public function getResponse($address)
    {
        $data = $this->sendResponse($address);
        $result = [];

        if (!isset($data)) {
            throw new \Exception('Результата не найдено');
        }

        foreach ($data['response']['GeoObjectCollection']['featureMember'] as $item) {
            array_push($result, $item['GeoObject']['metaDataProperty']['GeocoderMetaData']['Address']);
        }

        return Json::encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    public function getCoords($address)
    {
        $data = $this->sendResponse($address);

        if (!isset($data)) {
            throw new \Exception('Результата не найдено');
        }

        return Json::encode($data['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
}
