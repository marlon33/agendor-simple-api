<?php

namespace App\Http\Agendor;

class AgendorAPi
{
    private $token;
    private $route;

    public function __construct($token, $route)
    {
        $this->token = $token;
        $this->route = $route;
    }

    public function get()
    {
        $curl = curl_init();
        $route = 'https://api.agendor.com.br/v3/' . $this->route;
        curl_setopt_array($curl, array(
            CURLOPT_URL => $route,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Token ' . $this->token,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    }

    public function post($data)
    {
        $curl = curl_init();
        $route = 'https://api.agendor.com.br/v3/' . $this->route;

        curl_setopt_array($curl, array(
            CURLOPT_URL => $route,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Token ' . $this->token,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    }
}
