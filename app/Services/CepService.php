<?php

namespace App\Services;

use GuzzleHttp\Client;

class CepService
{
    protected $baseUrl = 'https://viacep.com.br/ws/';

    public function getEnderecoByCep($cep)
    {
        $client = new Client([
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ]);

        try {
            $response = $client->request('GET', $this->baseUrl . $cep . '/json/');

            if ($response->getStatusCode() == 200) {
                $content = $response->getBody();
                return json_decode($content, true);
            }

        } catch (\Throwable $th) {

            return null;

        }



    }
}
