<?php

namespace App\Olx\Users\Repositories;

use App\Olx\Users\Entities\UserEntity;
use App\Olx\Abstracts\AbstractRepository;


class UserRepository extends AbstractRepository
{
    protected $model;

    public function __construct(UserEntity $model)
    {
        $this->model = $model;
    }
}