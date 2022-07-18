<?php
namespace App\Repositories;

use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Model;

Abstract class BaseRepository{
    protected $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    //get model proparties dynamic from model
    public function getProperties()
    {
        $getReflactionModel = new \ReflectionClass($this->model);
        $getProperties = $getReflactionModel->getProperty('fillable');
        $getProperties->setAccessible(true);
        return $getProperties->getValue(new $this->model);
    }
    //get relationas from dynamic model
    function getRelationMethod(){
        $getReflactionModel = new \ReflectionClass($this->model);
        $getRelation = $getReflactionModel->getProperty('relations');
        $getRelation->setAccessible(true);
        return $getRelation->getValue(new $this->model);
    }
    //Base repo to get all items
    public function getList($take = 10){
        $result = QueryBuilder::for($this->model)
                                ->allowedIncludes($this->getRelationMethod())
                                ->allowedFilters($this->getProperties())
                                ->allowedSorts($this->getProperties());
        return $result->paginate($take);
    }
    //Base repo to get item by id
    public function show($id){
        return QueryBuilder::for($this->model)
                            ->allowedIncludes($this->getRelationMethod())
                            ->findOrFail($id);
    }
    //Base repo to check item
    public function check($id){
        return $this->model->find($id);
    }
    //Base repo to create item
    public function create($data){
        return $this->model->create($data);
    }
    //Base repo to update item 
    public function update($id, $values){
        $item = $this->model->findOrFail($id);
        $item->update($values);
    }
    //base repo to delete item
    public function delete($model)
    {
        return $model->delete();
    }
}