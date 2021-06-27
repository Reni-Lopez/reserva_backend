<?php
namespace App\Services\Commerce;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\log;
use App\Repositories\Commerce\CommerceRepository;


class CommerceService{

    protected $commerce;

    public function __construct( CommerceRepository $commerce){
        return $this->commerce = $commerce;
    }
    public function getAllCommerce(){
        return $this->commerce->getAllCommerce();
    }

    public function getCommerceByOwner( $id ){
        return $this->commerce->getCommerceByOwner( $id );
    }

    public function getCommerceByFk( $id ){
        return $this->commerce->getCommerceByFk( $id );
    }
    public function getCommerce( $id ){
        return $this->commerce->getCommerce( $id );
    }
    public function getCommerceById( $id ){
        return $this->commerce->getCommerceById( $id );
    }
    public function createCommerce($json){
        $data = json_decode($json);
        $data_array = json_decode($json, true);
        $validate = Validator::make($data_array, [
            'name' => ['required','unique:commerce,name'],
        ]);
        if ($validate->fails()) {
            throw new InvalidArgumentException($validate->errors()->first());
        }
        return $this->commerce->createCommerce( $data );
    }
    public function updateCommerce($json, $id){   
        $data = json_decode($json);
        $data_array = json_decode($json, true);
        $validate = Validator::make($data_array, []);
        if ($validate->fails()) {
            throw new InvalidArgumentException($validate->errors()->first());
        }
        $result = $this->commerce->updateCommerce( $data, $id );
        return $result;
    }
    public function deleteCommerce($id){
        DB::beginTransaction();
        try{ 
            $result = $this->commerce->deleteCommerce($id);
        } 
        catch (Exception $e){
            DB::rollBack();
            Log::info($e->getMessage());
            throw new InvalidArgumentException('Unable to delete due data');
        }
        DB::commit();
        return $result;
    }

}
