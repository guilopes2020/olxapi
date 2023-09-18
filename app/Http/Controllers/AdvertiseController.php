<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdvertiseStoreRequest;
use App\Http\Requests\AdvertiseUpdateRequest;
use App\Olx\Advertises\Services\AdvertiseService;

class AdvertiseController extends AbstractController
{
    protected $service;

    protected $requestValidate = AdvertiseStoreRequest::class;
    protected $requestValidateUpdate = AdvertiseUpdateRequest::class;

    public function __construct(AdvertiseService $service)
    {
        $this->service = $service;
    }
}
