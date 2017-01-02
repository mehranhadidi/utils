<?php

namespace SHR;

use GuzzleHttp\Client;

class CallService
{
	const POST = 'POST';
    const GET = 'GET';

    public static function send($type, $url, $token = null, $headers = [], $body = null, $checkException = true)
    {
        // default headers for every request
        $defaultHeaders = [
            'Accept' => 'application/json',
            'Content-Type', 'text/json'
        ];

        // check if user passed a token, send it as Authorization Bearer header
        if( ! is_null($token))
            $defaultHeaders['Authorization'] = 'Bearer ' . $token;

        if( ! is_null($body))
            $body = ['form_params' => (array) $body];

        // combine user custom headers with defaults
        $headers = array_merge($headers, $defaultHeaders);

        if($checkException)
        {
            try
            {
                $client = new Client([
                    'headers' => $headers
                ]);

                $response = $client->request($type, $url, $body);

                $data = $response->getBody()->getContents();

                // if data is json return the object, if not return as string
                if(self::isJson($data))
                    return response(json_decode($data, true), $response->getStatusCode())
                        ->header('Content-Type', 'text/json');
                else
                    return $data;
            }
            catch (\Exception $e)
            {
                $error = $e->getResponse()->getBody(true);

                return response($error, $e->getCode())
                    ->header('Content-Type', 'text/json');
            }
        }
    }

    private static function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}