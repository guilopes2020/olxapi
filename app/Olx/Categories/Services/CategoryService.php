<?php

namespace App\Olx\Categories\Services;

use App\Olx\Abstracts\AbstractService;
use App\Olx\Categories\Repositories\CategoryRepository;

class CategoryService extends AbstractService
{
    protected $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }
}