<?php

namespace App\Http\Controllers;

use App\Http\Requests\StateStoreRequest;
use App\Http\Requests\StateUpdateRequest;
use App\Olx\States\Services\StateService;

class StateController extends AbstractController
{
    protected $service;

    protected $requestValidate = StateStoreRequest::class;
    protected $requestValidateUpdate = StateUpdateRequest::class;

    public function __construct(StateService $service)
    {
        $this->service = $service;
    }
}
