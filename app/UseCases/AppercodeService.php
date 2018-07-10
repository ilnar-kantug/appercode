<?php

namespace App\UseCases;


use App\Entity\Appercode;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class AppercodeService
{

    private $guzzleClient;
    private $sessionId;

    public function __construct(Client $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    public function getUsers($sessionId)
    {
        $this->sessionId = $sessionId;

        $users = $this->fetchUsers();
        $profiles = $this->fetchProfiles();
        $fullUserData = $this->mergeUsersProfiles($users, $profiles);
        return $fullUserData;
    }

    public function fetchUsers()
    {
        try{
            $res = $this->guzzleClient->request('GET', Appercode::GET_USERS_URL, [
                'headers' => [
                    'X-Appercode-Session-Token' => $this->sessionId,
                ]
            ]);
        }catch (GuzzleException $exception){
            throw new \Exception($exception->getMessage());
        }

        $users =  json_decode($res->getBody()->getContents(), true);

        if (empty($users)){
            throw new \Exception('There are no users');
        }

        return $users;
    }

    public function fetchProfiles()
    {
        try{
            $res = $this->guzzleClient->request('GET', Appercode::GET_PROFILES_URL, [
                'headers' => [
                    'X-Appercode-Session-Token' => $this->sessionId,
                ]
            ]);
        }catch (GuzzleException $exception){
            throw new \Exception($exception->getMessage());
        }

        $profiles =  json_decode($res->getBody()->getContents(), true);

        if (empty($profiles)){
            throw new \Exception('There are no profiles');
        }

        return $profiles;
    }

    private function mergeUsersProfiles($users, $profiles)
    {
        $i = 0;
        foreach ($users as $user){
            $fullUserData[$i]['id'] = $user['id'];
            $fullUserData[$i]['username'] = $user['username'];
            $fullUserData[$i]['roleId'] = $user['roleId'];
            foreach ($profiles as $profile){
                if($user['id'] == $profile['userId']){
                    $fullUserData[$i]['firstName'] = $profile['firstName'];
                    $fullUserData[$i]['lastName'] = $profile['lastName'];
                    $fullUserData[$i]['position'] = $profile['position'];
                }
            }
            $i++;
        }
        return $fullUserData;
    }
}