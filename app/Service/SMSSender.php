<?php

namespace App\Service;

use App\Rules\Telephone;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Http;

class SMSSender
{
    const BASE_URI = 'https://api.orange.com';

    /**
     * @throws GuzzleException
     */
    public  static  function send(string $message, string $phone_number): bool
    {
        $telephoneValidator = new Telephone();
        if (!$telephoneValidator->passes('phone', $phone_number)) {
            throw new \InvalidArgumentException('Invalid phone number');
        }
        $accessToken = self::getSmsAccessTokenOM();
        // send the message to the phone
        $body = ['outboundSMSMessageRequest' => [
//            'address' => 'tel:'.$this->normalizePhoneNumber($recipientNumber),
            'address' => 'tel:'.self::normalizePhoneNumber($phone_number),
            'senderName'=> config('app.orange_api_sender_name'),
            'senderAddress' => 'tel:'.config('app.orange_api_sender_number'),
            'outboundSMSTextMessage' => [ 'message' => $message]
        ]
        ];
        $response = Http::withHeaders(
            ["Authorization" => "Bearer " . $accessToken,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->asJson()
            ->post(self::BASE_URI."/smsmessaging/v1/outbound/tel:".config('app.orange_api_sender_number') ."/requests",$body);

        return isset($response->json()['outboundSMSMessageRequest']) ;
    }
    /**
     * @throws GuzzleException
     */
    public  static function getSmsAccessTokenOM()
    {
        $data = [
            "grant_type"=>"client_credentials",
        ];
        $httpClient = new Client();

        $response = $httpClient->request("POST",self::BASE_URI."/oauth/v3/token",
            [
                'headers' => [
                    'Accept'=>'application/json',
                    'Authorization' => "Basic " . base64_encode(config('app.orange_api_client_id').":".config('app.orange_api_client_secret'))
                ],
                'form_params' => $data
            ]
        );

        $accessTokens = json_decode($response->getBody()->getContents(), true);

       return $accessTokens["access_token"];
    }
    /**
     * Normalize phone number.
     *
     * @param  $phone
     * @return string
     */
    protected static function normalizePhoneNumber($phone)
    {
        $phone = (string) $phone;

        if (!str_starts_with($phone, '+221')) {
            return '+221' . $phone;
        }

        return $phone;
    }

}
