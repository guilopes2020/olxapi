<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Olx\Users\Services\UserService;
use App\Http\Requests\UserUpdateRequest;

class UserController extends AbstractController
{
    protected $service;

    protected $requestValidate = UserStoreRequest::class;
    protected $requestValidateUpdate = UserUpdateRequest::class;
    
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }
}
