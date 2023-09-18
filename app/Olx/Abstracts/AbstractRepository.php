<?php

namespace App\Olx\Abstracts;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Olx\Interfaces\RepositoryInterface;

abstract class AbstractRepository implements RepositoryInterface
{
    protected $model;

    /**
     * Get the model
     *
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * Get All
     *
     * @param $params
     * @param array $with
     * @return mixed
     */
    public function all($params = null, $with = [])
    {
        return $this->getModel()->query($params)->with($with)->paginate(10)->withQueryString();
    }

    public function allWithOutPaginate($params = null, $with = [])
    {
        return $this->getModel()->with($with)->query($params)->get();
    }

    /**
     * Retorna em forma de lista para selecte.
     * @return mixed
     */
    public function list($sortBy = 'name', $pluck = 'name'): array
    {
        return $this->getModel()->all()->sortBy($sortBy)->pluck($pluck, 'id')->all();
    }

    /**
     * Find
     *
     * @param integer $id
     * @param array $with
     * @param array $withCount
     * @return mixed
     */
    public function find(int $id, array $with = [], array $withCount = [])
    {
        
        return $this->getModel()->with($with)->withCount($withCount)->find($id);
    }

    /**
     * Retorna o primeiro registro encontrado.
     * @param array $where
     * @param array $with
     * @param array $withCount
     * @return mixed
     */
    public function findOneWhere(array $where, array $with = [], array $withCount = [])
    {
        $object = $this->where($where, $with, $withCount);

        return $object->first();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findOrFail(int $id)
    {
        return $this->getModel()->findOrFail($id);
    }

    /**
     * Find By User Authentication
     *
     * @param array $params
     * @return mixed
     */
    public function findByUserAuth(array $params)
    {
        if (isset($params['user_id']) && ! empty($params['user_id'])) {
            return $this->findOrFail($params['user_id']);
        }

        return Auth::user()->id;
    }

    /**
     * Create
     *
     * @param $params
     * @return Model
     */
    public function create($params): Model
    {
        return $this->getModel()->create($params);
    }

    /**
     * Update
     *
     * @param $entity
     * @param $data
     * @return mixed
     */
    public function update(Model $entity, $data)
    {

        return $entity->fill($data)->save();
    }

    /**
     * Where
     *
     * @param array $where
     * @param array $with
     * @param array $withCount
     * @return mixed
     */
    public function where(array $where, array $with = [], array $withCount = [])
    {
        return $this->getModel()->where($where)->with($with)->withCount($withCount)->get();
    }

    /**
     * Delete
     *
     * @param integer $id
     * @return mixed
     */
    public function delete(int $id)
    {
        $model = $this->find($id);
        
        return $model->delete();
    }

    /**
     * Delete com condição.
     * @param $where
     */
    public function deleteWhere($where)
    {
        $this->getModel()->where($where)->delete();
    }

    /**
     * getAttribute.
     * @param mixed $value
     * @return void
     */
    public function getAttribute($params, $value, $default = null)
    {
        return (isset($params[$value])) ? $params[$value] : $default;
    }

    /**
     * @param array $paramsValidation
     * @param array $params
     * @return mixed
     */
    public function createOrUpdate(array $paramsValidation, array $params)
    {
        return $this->model->updateOrCreate($paramsValidation, $params);
    }
}