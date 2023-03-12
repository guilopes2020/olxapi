<?php

namespace App\OLX\Interfaces;

interface ServiceInterface
{
    public function getRepository();

    public function getAll();

    public function find(int $id);

    public function beforeSave(array $data);

    public function save(array $data);

    public function afterSave($entity, array $params);

    public function beforeUpdate($id, array $data);

    public function update(int $id, array $data);

    public function afterUpdate($entity, array $params);

    public function beforeDelete($id);

    public function delete(int $id);

    public function afterDelete($id);

    public function create(array $data);

    public function validateOnInsert(array $params);

    public function validateOnUpdate($id, array $params);

    public function validateOnDelete($id);
}