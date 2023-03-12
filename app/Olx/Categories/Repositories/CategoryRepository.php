<?php

namespace App\Olx\Categories\Repositories;

use App\Olx\Abstracts\AbstractRepository;
use App\Olx\Categories\Entities\CategoryEntity;

class CategoryRepository extends AbstractRepository
{
    protected $model;

    public function __construct(CategoryEntity $model)
    {
        $this->model = $model;
    }
}