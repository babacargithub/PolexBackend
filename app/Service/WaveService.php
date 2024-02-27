<?php /** @noinspection PhpUnused */

namespace App\Service;

use Exception;
use Http;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class WaveService
{
     const  WAVE_BASE_URL = 'https://api.wave.com/v1/checkout/sessions';


    public function wavePaymentSuccessCallBack(): JsonResponse
    {
        try {
            list($body, $valid) = $this->verifyWaveSignature();
            if ($valid) {
                # This is a request from Wave.
                # You can proceed decoding the request body.
                $body = json_decode($body);
                $webhook_event = $body->type;
                if ($webhook_event == "checkout.session.completed") {
                    $webhook_data = $body->data;

                    $metaData = json_decode($webhook_data->client_reference, true);

                    try {
                        // determine if it is for booking or depart
                        // check if booking
                        if ($metaData['type'] == "booking" || $metaData['type'] == "depart") {
                            //TODO handle success
                            Log::info("Wave payment saved for booking or depart");
                        }
                        if ($metaData['type'] == "booking") {
                           //TODO handle success
                           Log::alert("Wave payment saved for booking failed");
                        }//check if transaction is of depart type

                    } catch (Exception $e) {
                       Log::error("Unable to save payment made by phone number: " . $webhook_data->sender_mobile);
                       Log::error($e->getMessage() . '---' . $e->getFile() . '---' . $e->getTraceAsString());

                    }

                } else {
                   Log::alert("event sent by wave" . $webhook_event);
                }

            } else {
               Log::error("Wave signature is not  valid !");
                die("Unable to verify webhook signature.");
            }
        } catch (Exception $e) {
           Log::error($e);

        }
        return response()->json(["message" => "success"]);
    }

    public static function getWavePaymentUrl(array $data): JsonResponse
    {

//                            throw new NoSeatAvailableException("Aucune place disponible pour le départ : " . $booking->getDepart()->getName());
        try {
            $headers = self::getWaveHeaders();
            $requestBody = [
                ...$data,
                "currency" => "XOF",
                //TODO change
                "error_url" => "https://transport.golobone.net/paiement/error/depart/",
                "success_url" =>"https://transport.golobone.net/paiement/success/depart/",
            ];
            $request = Http::withHeaders($headers)->asJson()->post(self::WAVE_BASE_URL, $requestBody);
            $request->throw();//
            return response()->json(json_decode($request->body(), true), $request->status());
        } catch (RequestException $e) {
            Log::error($e->getMessage() . '---' . $e->getFile() . '---' . $e->getTraceAsString());
            return response()->json(json_decode($e->response->body()), $e->response->status());
        } /** @noinspection PhpRedundantCatchClauseInspection */
        catch (ConnectionException $connectionException){
            return response()->json(["message"=>'Erreur de connexion '.$connectionException->getMessage(), 400]);
        }


    }

    protected static function getWaveHeaders(): array
    {
        return [
            'Authorization' => 'Bearer ' .self::getParameter('app.wave_key'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }



    /**
     * @return array
     */
    public function verifyWaveSignature(): array
    {
        $wave_webhook_secret = $this->getParameter('app.wave_webhook_secret');
# This header is sent with the HMAC for verification.
        $wave_signature = $_SERVER['HTTP_WAVE_SIGNATURE'];
        $parts = explode(",", $wave_signature);
        $timestamp = explode("=", $parts[0])[1];
        $signatures = array();
        foreach (array_slice($parts, 1) as $signature) {
            $signatures[] = explode("=", $signature)[1];
        }
        $body = file_get_contents('php://input');
        $computed_hmac = hash_hmac("sha256", $timestamp . $body, $wave_webhook_secret);
        $valid = in_array($computed_hmac, $signatures);
        return array($body, $valid);
    }

    public function getLatestWaveTransactions()
    {
        $url = "https://api.wave.com/v1/transactions";
        $headers = $this->getWaveHeaders();
        $response = Http::withHeaders($headers)->get($url);

        $response = json_decode($response->body(), true);
        if (isset($response["items"])) {
            return $response["items"];
        }
        return [];
    }

    public static function getParameter(string $param)
    {
        return config($param);
    }


}


