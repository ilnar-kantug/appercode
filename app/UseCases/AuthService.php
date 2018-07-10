<?php
/**
 * Created by PhpStorm.
 * User: iamopk
 * Date: 10.07.18
 * Time: 12:43
 */

namespace App\UseCases;


use App\Entity\Appercode;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class AuthService
{
    private $guzzleClient;

    public function __construct(Client $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    public function getSessionToken()
    {
        try{
            $res = $this->guzzleClient->request('POST', Appercode::LOGIN_URL, [
                'json' => [
                    'username' => env('ADMIN_LOGIN'),
                    'password' => env('ADMIN_PASS'),
                    'generateRefreshToken' => true,
                ]
            ]);
        }catch (GuzzleException $exception){
            throw new \Exception($exception->getMessage());
        }

        if ($res->getStatusCode() != Response::HTTP_OK){
            throw new \Exception('Cannot log in');
        }

        $loginData =  json_decode($res->getBody()->getContents(), true);

        if (! $loginData){
            throw new \Exception('No login data received');
        }

        return $loginData['sessionId'];
    }
}