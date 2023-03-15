<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AbstractController extends Controller
{
    protected $with = [];
    protected $orderBy = [];
    protected $service;
    protected $requestValidate;
    protected $requestValidateUpdate;
    protected $validated;

    public function index(Request $request)
    {
        if (! isset($request->with)) {
            $request->with = $this->with;
        }

        if (! isset($request->orderBy)) {
            $request->orderBy = $this->orderBy;
        }

        if (! isset($request->paginate)) {
            $request->paginate = true;
        }

        $items = $this->service->getAll($request->orderBy, $request->with, $request->paginate)->toArray();

        return $this->ok($items);
    }

    public function store(Request $request)
    {
        try {
            if ($this->requestValidate) {
                $requestValidate = app($this->requestValidate);
                $this->validated = $request->validate($requestValidate->rules());
            }
        } catch (ValidationException $e) {
            return $this->error($this->messageErrorDefault, $e->errors());
        }

        try {
            DB::beginTransaction();
            $response = $this->service->save($request->all());
            DB::commit();
            return $this->success($this->messageSuccessDefault, ['response' => $response]);
        } catch (\Exception | ValidationException $e) {
            DB::rollBack();
            if ($e instanceof ValidationException) {
                return $this->error($this->messageErrorDefault, $e->errors());
            }
            if ($e instanceof \Exception) {
                return $this->error($e->getMessage());
            }
        }
    }

    public function show($id, Request $request)
    {
        if (! isset($request->with)) {
            $request->with = $this->with;
        }

        try {
            return $this->ok($this->service->find($id, $request->with));
        } catch (\Exception | ValidationException $e) {
            DB::rollBack();
            if ($e instanceof \Exception) {
                return $this->error($e->getMessage());
            }
            if ($e instanceof ValidationException) {
                return $this->error($this->messageErrorDefault, $e->errors());
            }
        }
    }

    public function update($id, Request $request)
    {
        try {
            if ($this->requestValidateUpdate) {
                $requestValidateUpdate = app($this->requestValidateUpdate);
                $this->validated = $request->validate($requestValidateUpdate->rules());
            }
        } catch (ValidationException $e) {
            return $this->error($this->messageErrorDefault, $e->errors());
        }

        try {
            DB::beginTransaction();
            $response = $this->service->update($id, $request->all());
            DB::commit();
            return $this->success($this->messageSuccessDefault, ['response' => $response]);
        } catch (\Exception | ValidationException $e) {
            DB::rollBack();
            if ($e instanceof ValidationException) {
                return $this->error($this->messageErrorDefault, $e->errors());
            }
            if ($e instanceof \Exception) {
                return $this->error($e->getMessage());
            }
        }
    }

    public function destroy($id)
    {
        try {
            $this->service->delete($id);
            return $this->success($this->messageSuccessDefault);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
