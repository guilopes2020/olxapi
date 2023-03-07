<?php

namespace App\OLX\Interfaces;

interface ServiceInterface
{
    public function getRepository();

    public function getAll();

    public function find(int $id);

    public function save(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);

    public function create(array $data);
}