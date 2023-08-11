<?php

namespace App\Services;

use GuzzleHttp\Client;

class CepService
{
    protected $baseUrl = 'https://viacep.com.br/ws/';

    public function getEnderecoByCep($cep)
    {
        $client = new Client();
        $response = $client->get($this->baseUrl . $cep . '/json/');

        dd($response);

        if ($response->getStatusCode() == 200) {
            return json_decode($response->getBody(), true);
        }

        return null;
    }
}
