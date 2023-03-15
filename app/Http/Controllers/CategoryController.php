<?php

namespace App\Http\Controllers;

use App\Olx\Categories\Services\CategoryService;

class CategoryController extends AbstractController
{
    protected $service;

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }
}
