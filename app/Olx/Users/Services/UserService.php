<?php

namespace App\Olx\Users\Services;

use App\Olx\Abstracts\AbstractService;
use App\Olx\Users\Repositories\UserRepository;

class UserService extends AbstractService
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;

    }
}