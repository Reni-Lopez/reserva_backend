<?php
namespace App\Services\Reserve;

use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\log;
use App\Repositories\Reserve\ReserveRepository;

class ReserveService{
    
    protected $reserve;

    public function __construct(ReserveRepository $reserve){
        $this->reserve = $reserve;
    }
    
    public function getReserveByIdClient($id)
    {
        return  $this->reserve->getReserveByIdClient( $id );
    }
    public function getReserveByIdOwner($id)
    {
        return  $this->reserve->getReserveByIdOwner( $id );
    }
    public function createReserve($json){
        $data = json_decode($json);
        $data_array = json_decode($json, true);
        $validate = Validator::make($data_array, [
            // 'name' => ['required','unique:commerce,name'],
        ]);
        if ($validate->fails()) {
            throw new InvalidArgumentException($validate->errors()->first());
        }
        return $this->reserve->createReserve( $data );
    }
    public function updateReserve($json, $id){   
        $data = json_decode($json);
        $data_array = json_decode($json, true);
        $validate = Validator::make($data_array, []);
        if ($validate->fails()) {
            throw new InvalidArgumentException($validate->errors()->first());
        }
        $result = $this->reserve->updateReserve( $data, $id );
        return $result;
    }

}
