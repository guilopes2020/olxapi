<?php

namespace App\Olx\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    public function getModel(): Model;

    public function all();

    public function find(int $id, array $with, array $withCount);

    public function create(array $data): Model;

    public function update(Model $entity, $data);

    public function delete(int $id);

    public function list($sortBy, $pluck);

    public function allWithOutPaginate($params, $with);

    public function findOneWhere(array $where, array $with, array $withCount);

    public function findOrFail(int $id);

    public function findByUserAuth(array $params);

    public function where(array $where, array $with, array $withCount);

    public function deleteWhere($where);

    public function getAttribute($params, $value, $default);

    public function createOrUpdate(array $paramsValidation, array $params);
} 