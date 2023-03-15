<?php

namespace App\Http\Controllers;

use App\Olx\States\Services\StateService;

class StateController extends AbstractController
{
    protected $service;

    public function __construct(StateService $service)
    {
        $this->service = $service;
    }
}
