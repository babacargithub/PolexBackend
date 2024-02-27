<?php /** @noinspection PhpUnused */


/**
 * Copyright (c) 2020.  All rights reserved for Polex SARL  Software
 */

namespace App\Service;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\HttpException;

class OrangeMoneyService
{


//    public function orangeMoneyPaymentSuccessCallBack(RequestStack $request): Response
//    {
//
//        $data = json_decode($request->getCurrentRequest()->getContent(), true);
//        if (isset($data['status']) && isset($data['customer']) ){
//            if ($data['status'] == "SUCCESS"){
//                $customerPhoneNumber = $data["customer"]['id'];
//                $customer = $this->getDoctrine()->getRepository(\App\Entity\Client::class)
//                    ->findOneByPhoneNumber($customerPhoneNumber);
//                if ($customer != null){
//                    $booking = $customer->getCurrentBooking();
//                    if ($booking != null){
//                        // save payment
//                        if ($booking->getTicket() == null) {
//                            $this->bookingManager->saveTicketPayementForOnlineUsers($booking, $this->logger, "om");
//                        }
//                    }else{
//                       Log::alert("Booking is null for customer OM payment");
//                    }
//
//                }else{
//                   Log::alert("Customer is null");
//                }
//            }
//        }
//
//        return new Response('OM url called');
//
//    }

    /**
     * @throws GuzzleException
     */
    protected function getAccessTokenOM()
    {
        $data = [
            "grant_type"=>"client_credentials",
        ];
        $httpClient = new Client();

        $response = $httpClient->request("POST","https://api.orange-sonatel.com/oauth/token",
            [
                'headers' => [
                    'Accept'=>'application/x-www-form-urlencoded',
                    'Authorization' => "Basic ".OrangeMoneyService::getParameter('app.om_api_key_base_64_encoded')
                ],
                'form_params' => $data
            ]
        );

        $accessTokens = json_decode($response->getBody()->getContents(), true);

        return $accessTokens["access_token"];
    }


    /**
     */
    public function initOMPayment(array $data): JsonResponse
    {
        try {


            $requestData =
                [
                    'amount' => [
                        'unit' => 'XOF',
                        'value' => $data['amount'],
                    ],
                    'customer' => [
                        'id' => $data['telephone'],
                        'idType' => 'MSISDN',
                        'walletType' => 'PRINCIPAL',
                    ],
                    'method' => 'QRCODE',
                    'partner' => [
                        'encryptedPinCode'=>config('app.om_merchant_encrypted_pin'),
                        'id' => config('app.om_merchant_msisdn'),
                        'idType' => 'MSISDN',
                        'walletType' => 'PRINCIPAL',
                    ],
                    'metadata' => $data['metadata'],
                    'receiveNotification' => true
                ];
            $client = $this->getClient();
            $response = $client->asJson()->post("https://api.orange-sonatel.com/api/eWallet/v1/payments", $requestData);
            return response()->json(json_decode($response->body()));
        } catch (GuzzleException $e) {
           Log::error($e->getMessage());
            return new JsonResponse("erreur ", 500);

        }catch (Exception $e) {
           \Log::error($e->getMessage());

            return new JsonResponse("Erreur  ".$e->getMessage(), 500);
        }

    }

    /**
     * @throws GuzzleException
     */
    public function balance(): JsonResponse
    {
        $reqBody = [
            'idType' => 'MSISDN',
            'encryptedPinCode' => OrangeMoneyService::getParameter('om_merchant_encrypted_pin'),
            'id' => OrangeMoneyService::getParameter('om_merchant_msisdn'),
            'wallet' => 'PRINCIPAL',
        ];
        $response = $this->getClient()->post("https://api.orange-sonatel.com/api/eWallet/v1/account/retailer/balance",[
            "body"=>json_encode($reqBody)
        ]);
        $data = json_decode($response->body(),true);
        return new JsonResponse(["balance"=>$data['value']]);
    }

    /**
     * @throws GuzzleException
     */
    public function transactions(): JsonResponse
    {
        $response = $this->getClient()->get("https://api.orange-sonatel.com/api/eWallet/v1/transactions?size=300", [
        ]);

        return new JsonResponse(json_decode($response->body()));

    }

    /**
     * @throws GuzzleException
     */
    public function withdraw(RequestStack $requestStack): JsonResponse
    {
        $content = json_decode($requestStack->getCurrentRequest()->getContent(),true);
        if (isset($content['amount']) && isset($content["secretCode"]) && isset($content["phoneNumber"])) {
            $phoneNumber = $content['phoneNumber'];
            $amount = $content['amount'];
            $secretCode = $content['secretCode'];

            if ($secretCode == OrangeMoneyService::getParameter('om_secret_code')) {
                $reqBody = [
                    'partner' => [
                        'idType' => 'MSISDN',
                        'id' => OrangeMoneyService::getParameter('om_merchant_msisdn'),
                        'encryptedPinCode' => OrangeMoneyService::getParameter('om_merchant_encrypted_pin')
                    ],
                    'customer' => [
                        'idType' => 'MSISDN',
                        'id' => $phoneNumber,
                    ],
                    'amount' => [
                        'value' => $amount,
                        'unit' => 'XOF',
                    ],
                    'reference' => '',
                    'receiveNotification' => true,
                ];
                $response = $this->getClient()->post('https://api.orange-sonatel.com/api/eWallet/v1/cashins', [
                    "body" => json_encode($reqBody)
                ]);
                return new JsonResponse(json_decode($response->body(), true));
            } else {
                throw new HttpException(400,"bad request: invalid withdraw secret code");

            }
        }else{
            throw new HttpException(400,"bad request: amount and secret code should be present");
        }
    }

    /**
     * @throws GuzzleException
     *
     */
    public function getClient() : PendingRequest
    {
        $accessToken = $this->getAccessTokenOM();

        return Http::withHeaders(

                [
                    "Authorization" => "Bearer " . $accessToken,
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',

                ]);
    }

    public static function getParameter($param)
    {
        return config($param);
    }

}

