<?php

namespace App\Olx\Advertises\Repositories;

use App\Olx\Abstracts\AbstractRepository;
use App\Olx\Advertises\Entities\AdvertiseEntity;

class AdvertiseRepository extends AbstractRepository
{
    protected $model;

    public function __construct(AdvertiseEntity $model)
    {
        $this->model = $model;
    }
}