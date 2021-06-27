<?php
namespace App\Repositories\Commerce;
use App\Models\Commerce;
use Illuminate\Support\Facades\DB;

class CommerceRepository{
    
    protected $commerce;

    public function __construct(Commerce $commerce){
        $this->commerce = $commerce;
    }
    public function getAllCommerce(){
        return $this->commerce->all();
    }
    public function getCommerceById( $id ){
        return $this->commerce->find( $id );
    }
    public function getCommerceByFk( $id ){
        return $this->commerce->where('type_commerce', $id)->get();
    }
    public function getCommerce( $id ){
        return $this->commerce->where('owner_id', $id)->get();
    }

    public function getCommerceByOwner( $id ){
        $header_info = DB::select('CALL getCommerceByOwner(?)',array($id));
        return $header_info;
        // return $resp = DB::select('CALL getCommerceByOwner(?)', array($id));
        // return $resp;
        // dd($resp);
        // return DB::select('CALL getCommerceByOwner(?)', array($id));
        
    }

    public function createCommerce( $data ){
        $commerce = new $this->commerce;
        $commerce->type_commerce = $data->type_commerce;
        $commerce->name = $data->name;
        $commerce->direction = $data->direction;
        $commerce->owner_id = $data->owner_id;
        $commerce->opening = $data->opening;
        $commerce->closing = $data->closing;
        $commerce->description = $data->description;
        return $commerce->save();
    }
    public function updateCommerce( $data, $id ){
        $commerce = $this->commerce->find( $id );
        $commerce->type_commerce = $data->type_commerce;
        $commerce->owner_id = $data->owner_id;
        $commerce->name = $data->name;
        $commerce->direction = $data->direction;
        $commerce->opening = $data->opening;
        $commerce->closing = $data->closing;
        $commerce->description = $data->description;
        return $commerce->update();
    }
    public function deleteCommerce( $id ){
        $commerce = $this->commerce->find( $id );
        return $commerce->delete();
    }

}