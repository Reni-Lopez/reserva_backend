<?php
namespace App\Services\Commerce;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\log;
use App\Repositories\Commerce\TypeCommerceRepository;

class TypeCommerceService{

    protected $commerce;

    public function __construct(TypeCommerceRepository $commerce){
        return $this->commerce = $commerce;
    }
    public function getTypeCommerceById( $id ){
        return $this->commerce->getTypeCommerceById( $id );
    }
    public function getAllCommerce(){
        return $this->commerce->getAllCommerce();
    }
    public function createTypeCommerce($json){
        $data = json_decode($json);
        $data_array = json_decode($json, true);
        $validate = Validator::make($data_array, [
            'type' => ['required','unique:type_commerce,type'],
        ]);
        if ($validate->fails()) {
            throw new InvalidArgumentException($validate->errors()->first());
        }
        return $this->commerce->createTypeCommerce( $data );
    }
    public function updateTypeCommerce($json, $id){   
        $data = json_decode($json);
        $data_array = json_decode($json, true);
        $validate = Validator::make($data_array, [
            'type' => ['required'],
        ]);
        if ($validate->fails()) {
            throw new InvalidArgumentException($validate->errors()->first());
        }
        $result = $this->commerce->updateTypeCommerce( $data, $id );
        return $result;
    }
    public function deleteTypeCommerce($id){
        DB::beginTransaction();
        try{ 
            $result = $this->commerce->deleteTypeCommerce($id);
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