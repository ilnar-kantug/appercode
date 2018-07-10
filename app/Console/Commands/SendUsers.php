<?php

namespace App\Console\Commands;

use App\UseCases\AppercodeService;
use App\UseCases\AuthService;
use App\UseCases\XmlService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendUsers extends Command
{
    protected $signature = 'send:users {email}';

    protected $description = 'Command to send users data to given email';

    private $authService;
    private $appercodeService;
    private $xmlService;

    public function __construct(
        AuthService $authService,
        AppercodeService $appercodeService,
        XmlService $xmlService
    )
    {
        parent::__construct();
        $this->authService = $authService;
        $this->appercodeService = $appercodeService;
        $this->xmlService = $xmlService;
    }

    public function handle()
    {
        $email = $this->argument('email');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die ("Укажите правильный email") ;
        }

        try{
            $sessionId = $this->authService->getSessionToken();
            $users = $this->appercodeService->getUsers($sessionId);
            $xml_path = $this->xmlService->createDoc($users);
            Mail::to($email)->send(new \App\Mail\SendUsers($xml_path));
        }catch (\Exception $exception){
            $this->error($exception->getMessage());
            return false;
        }
    }
}
