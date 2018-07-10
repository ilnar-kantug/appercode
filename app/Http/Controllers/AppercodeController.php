<?php

namespace App\Http\Controllers;

use App\UseCases\AuthService;
use Illuminate\Http\Request;

class AppercodeController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function getUsers()
    {
        try{
            $sessionId = $this->authService->getSessionToken();
        }catch (\Exception $exception){
            return redirect('/')->with('error', $exception->getMessage());
        }
        return view('welcome');
    }
}
