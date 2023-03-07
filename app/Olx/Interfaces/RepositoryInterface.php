<?php

namespace App\Olx\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    public function getModel(): Model;

    public function all();

    public function find(int $id);

    public function create(array $data): Model;

    public function update(Model $entity, $data);

    public function delete(int $id);
} 