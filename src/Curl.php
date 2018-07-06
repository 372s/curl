<?php
namespace Qous;

class Curl
{
    public $curl;

    public function __construct()
    {
        // $this->curl = curl_init();
    }

    public function get()
    {
        return $this->request($api, 'GET', $params = [], $headers = []);
    }

    public function post()
    {
        return $this->request($api, 'POST', $params = [], $headers = []);
    }

    public function put()
    {
        return $this->request($api, 'PUT', $params = [], $headers = []);
    }

    public function delete()
    {
        return $this->request($api, 'DELETE', $params = [], $headers = []);
    }

    public function request($api, $method = 'GET', $params = array(), $headers = [])
    {
        $curl = curl_init();
        switch (strtoupper($method)) {
            case 'GET':
                if (!empty($params)) {
                    $api .= (strpos($api, '?') !== false ? '&' : '?') . http_build_query($params);
                }
                curl_setopt($curl, CURLOPT_HTTPGET, true);
                break;
            case 'POST':
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
                break;
            case 'PUT':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
                break;
            case 'DELETE':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
                curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
                break;
        }
        curl_setopt($curl, CURLOPT_URL, $api);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($response === false && $err) {
            return array();
        } else {
            $response = json_decode($response, true);
            return $response;
        }
    }
}
