<?php

namespace App\Console\Commands;

use App\UseCases\AppercodeService;
use App\UseCases\AuthService;
use App\UseCases\XmlService;
use Illuminate\Console\Command;

class SendUsers extends Command
{
    protected $signature = 'send:users';

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
        try{
            $sessionId = $this->authService->getSessionToken();
            $users = $this->appercodeService->getUsers($sessionId);
            $xml_path = $this->xmlService->createDoc($users);

        }catch (\Exception $exception){
            $this->error($exception->getMessage());
            return false;
        }
    }
}
