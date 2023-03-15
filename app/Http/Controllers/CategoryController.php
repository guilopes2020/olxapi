<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Olx\Categories\Services\CategoryService;

class CategoryController extends AbstractController
{
    protected $service;

    protected $requestValidate = CategoryStoreRequest::class;
    protected $requestValidateUpdate = CategoryUpdateRequest::class;

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }
}
