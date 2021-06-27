<?php
namespace App\Services\Owner;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\log;
use App\Repositories\Owner\OwnerRepository;

class OwnerService{

    protected $owner;

    public function __construct(OwnerRepository $owner){
        $this->owner = $owner;
    }

    public function getAllOwner(){
        return $this->owner->getAllOwner();
    }
    public function getOwnerById( $id ){
        return $this->owner->getOwnerById( $id );
    }
    public function createOwner($json){
        $data = json_decode($json);
        $data_array = json_decode($json, true);
        $validate = Validator::make($data_array, [
            'name' => ['required'],
            'email' => ['required','unique:owner,email'],
            'password' => ['required'],
        ]);
        if ($validate->fails()) {
            throw new InvalidArgumentException($validate->errors()->first());
        }
        return $this->owner->createOwner( $data );
    }
    public function updateOwner($json, $id){   
        $data = json_decode($json);
        $data_array = json_decode($json, true);
        $validate = Validator::make($data_array, []);
        if ($validate->fails()) {
            throw new InvalidArgumentException($validate->errors()->first());
        }
        $result = $this->owner->updateOwner( $data, $id );
        return $result;
    }
    public function deleteOwner($id){
        DB::beginTransaction();
        try{ 
            $result = $this->owner->deleteOwner($id);
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

