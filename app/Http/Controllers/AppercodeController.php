<?php

namespace App\Http\Controllers;

use App\UseCases\AppercodeService;
use App\UseCases\AuthService;
use Illuminate\Http\Request;

class AppercodeController extends Controller
{
    private $authService;
    private $appercodeService;

    public function __construct(AuthService $authService, AppercodeService $appercodeService)
    {
        $this->authService = $authService;
        $this->appercodeService = $appercodeService;
    }

    public function getUsers()
    {
        try{
            $sessionId = $this->authService->getSessionToken();
            $users = $this->appercodeService->getUsers($sessionId);
        }catch (\Exception $exception){
            return redirect('/')->with('error', $exception->getMessage());
        }
        return view('welcome');
    }
}
