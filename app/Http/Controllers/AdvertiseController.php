<?php

namespace App\Http\Controllers;

use App\Olx\Advertises\Services\AdvertiseService;

class AdvertiseController extends AbstractController
{
    protected $service;

    public function __construct(AdvertiseService $service)
    {
        $this->service = $service;
    }
}
