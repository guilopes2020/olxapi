<?php

namespace App\Http\Controllers;

use App\Olx\Users\Services\UserService;

class UserController extends AbstractController
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }
}
