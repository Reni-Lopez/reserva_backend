<?php
namespace App\Repositories\Commerce;
use App\Models\TypeCommerce;

class TypeCommerceRepository{

    protected $commerce;

    public function __construct(TypeCommerce $commerce){
       $this->commerce = $commerce; 
    }
    public function getTypeCommerceById( $id ){
        return $this->commerce->find( $id );
    }
    public function getAllCommerce(){
        return $this->commerce->all();
    }
    public function createTypeCommerce( $data ){
        $commerce = new $this->commerce;
        $commerce->type = $data->type;
        return $commerce->save();
    }
    public function updateTypeCommerce( $data, $id ){
        $commerce = $this->commerce->find( $id );
        $commerce->type = $data->type;
        return $commerce->update();
    }
    public function deleteTypeCommerce( $id ){
        $commerce = $this->commerce->find( $id );
        return $commerce->delete();
    }

}