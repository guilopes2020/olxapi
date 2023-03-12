<?php

namespace App\Olx\States\Repositories;

use App\Olx\Abstracts\AbstractRepository;
use App\Olx\States\Entities\StateEntity;

class StateRepository extends AbstractRepository
{
    protected $model;

    public function __construct(StateEntity $model)
    {
        $this->model = $model;
    }
}