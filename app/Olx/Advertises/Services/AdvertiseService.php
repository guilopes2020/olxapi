<?php

namespace App\Olx\Advertises\Services;

use App\Olx\Abstracts\AbstractService;
use App\Olx\Advertises\Repositories\AdvertiseRepository;

class AdvertiseService extends AbstractService
{
    protected $repository;

    public function __construct(AdvertiseRepository $repository)
    {
        $this->repository = $repository;
    }
}