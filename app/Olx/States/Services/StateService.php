<?php

namespace App\Olx\States\Services;

use App\Olx\Abstracts\AbstractService;
use App\Olx\States\Repositories\StateRepository;

class StateService extends AbstractService
{
    protected $repository;

    public function __construct(StateRepository $repository)
    {
        $this->repository = $repository;

    }
}