<?php

namespace App\DAL;

use App\DAL\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;
use Config;
/**
 * Class Repository
 * @package Bosnadev\Repositories\Eloquent
 */
abstract class Repository implements RepositoryInterface {

    /**
     * @var App
     */
    private $app;

    /**
     * @var
     */
    protected $model;

    /**
     * @param App $app
     */
    public function __construct(App $app) {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    abstract function model();

    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($columns = array('*'), $perPage = 0) {

        if($perPage==0){
             $perPage = Config::get('constants.PAGINATION');
        }

        return $this->model->Paginate($perPage, $columns);
    }

    /**
     * @param $queryObject
     * @param int $perPage
     * @param null $param
     * @return mixed
     */
    protected function simplePagination($queryObject, $perPage = 0,$param=null){

        if($perPage==0){
            $perPage = Config::get('constants.PAGINATION');
        }
            
        $queryObject=$queryObject->whereNull($param.'.deleted_at');
        return $queryObject->simplePaginate($perPage);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data) {
        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @param $id
     * @param string $attribute
     * @return mixed
     */
    public function update(array $data, $id, $attribute="id") {
        return $this->model->where($attribute, '=', $id)->get()->each(function($model) use($data) {
            $model->update($data);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id) {
        return $this->model->destroy($id);
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*')) {
        return $this->model->find($id, $columns);
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = array('*')) {
        return $this->model->where($attribute, '=', $value)->first($columns);
    }

    /**
     * @return Model
     */
    public function makeModel() {
        $newModel = $this->app->make($this->model());

        if (!$newModel instanceof Model){
             return false;
        }

        return $this->model = $newModel;
    }
}