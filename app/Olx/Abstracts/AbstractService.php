<?php

namespace App\Olx\Abstracts;

use Illuminate\Support\Facades\Auth;
use App\Olx\Interfaces\ServiceInterface;

abstract class AbstractService implements ServiceInterface
{
    protected $repository;

    /**
     * Get Repository
     *
     * @return mixed
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * Get All Services
     *
     * @param array $params
     * @return mixed
     */
    public function getAll(array $params = [], $with = [])
    {

        return $this->repository->all($params, $with);
    }

    /**
     * Find
     *
     * @param $id
     * @param array $with
     * @return mixed
     * @throws \Exception
     */
    public function find($id, array $with = [], array $withCount = [])
    {
        $result = $this->repository->find($id, $with, $withCount);
        if ($result == null) {
            throw new \Exception('Objeto nao encontrado na base de dados');
        }

        return $result;
    }

    /**
     * Before Save
     *
     * @param array $data
     * @return array
     */
    public function beforeSave(array $data)
    {
        return $data;
    }

    /**
     * Save
     *
     * @param array $data
     * @return mixed
     */
    public function save(array $data)
    {
        $data = $this->beforeSave($data);
        if ($this->validateOnInsert($data) !== false) {
            $entity = $this->repository->create($data);
            $this->afterSave($entity, $data);

            return $entity;
        }
    }

    public function afterSave($entity, array $params)
    {
        return $entity;
    }

    /**
     * Before Update method
     *
     * @param $id
     * @param $data
     * @return array
     */
    public function beforeUpdate($id, array $data)
    {
        return $data;
    }

    /**
     * Update method
     *
     * @param $id
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function update($id, array $data)
    {
        $data = $this->beforeUpdate($id, $data);
        $this->validateOnUpdate($id, $data);
        $entity = $this->find($id);
        $updated = $this->repository->update($entity, $data);

        if ($updated) {
            $this->afterUpdate($entity, $data);
        }

        return $updated;
    }

    public function afterUpdate($entity, array $params)
    {
    }

    /**
     * Before Delete method
     *
     * @param $id
     * @return mixed
     */
    public function beforeDelete($id)
    {
        return $id;
    }

    /**
     * Delete
     *
     * @param $id
     * @return void
     */
    public function delete($id)
    {
        $this->validateOnDelete($id);
        $this->beforeDelete($id);
        $this->repository->delete($id);
        $this->afterDelete($id);

        return $id;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function afterDelete($id)
    {
        return $id;
    }
    

    public function toSelect(bool $withGenerateSelectOption = true)
    {
        if ($withGenerateSelectOption) {
            return generateSelectOption($this->repository->list());
        }

        return $this->repository->list();
    }

    /**
     * @param $params
     * @return bool
     */
    public function validateOnInsert(array $params)
    {
    }

    /**
     * @param $id
     * @param array $params
     */
    public function validateOnUpdate($id, array $params)
    {
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function validateOnDelete($id)
    {
        $result = $this->repository->find($id);
        if ($result == null) {
            throw new \Exception('Objeto nao encontrado na base de dados');
        }
    }

    /**
     * Create
     * Simplres criação sem validações.
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $entity = $this->repository->create($data);
        $this->afterSave($entity, $data);

        return $entity;
    }

    /**
     * Get User Auth
     *
     * @return mixed
     */
    public function getUserAuth()
    {
        return Auth::user();
    }

}