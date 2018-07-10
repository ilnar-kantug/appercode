<?php

namespace App\Http\Controllers;

use App\UseCases\AppercodeService;
use App\UseCases\AuthService;
use App\UseCases\XmlService;
use Illuminate\Http\Request;

class AppercodeController extends Controller
{
    private $authService;
    private $appercodeService;
    private $xmlService;

    public function __construct(
        AuthService $authService,
        AppercodeService $appercodeService,
        XmlService $xmlService
    )
    {
        $this->authService = $authService;
        $this->appercodeService = $appercodeService;
        $this->xmlService = $xmlService;
    }

    public function getUsers()
    {
        try{
            $sessionId = $this->authService->getSessionToken();
            $users = $this->appercodeService->getUsers($sessionId);
            $xml_path = $this->xmlService->createDoc($users);
        }catch (\Exception $exception){
            return redirect('/')->with('error', $exception->getMessage());
        }
        return redirect('/');
    }
}
