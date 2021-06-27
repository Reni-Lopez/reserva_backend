<?php
namespace App\Repositories\Reserve;
use App\Models\Reserve;
use Illuminate\Support\Facades\DB;

class ReserveRepository{

    protected $reserve;

    public function __construct(Reserve $reserve){
        $this->reserve = $reserve;
    }
    

    public function getReserveByIdClient($id)
    {
        $response =  DB::select('CALL getReserveByIdClient(?)',array($id));
        return $response;
    }

    public function getReserveByIdOwner($id)
    {
        return DB::select('CALL getReserveByIdOwner(?)',array($id));
    }


    public function createReserve( $data ){
        $reserve = new $this->reserve;
        $reserve->commerce_id = $data->commerce_id;
        $reserve->client_id = $data->client_id;
        $reserve->date = $data->date;
        $reserve->time = $data->time;
        $reserve->description = $data->description;
        return $reserve->save();
    }
    public function updateReserve( $data, $id ){
        $reserve = $this->reserve->find( $id );
        $reserve->commerce_id = $data->commerce_id;
        $reserve->client_id = $data->client_id;
        $reserve->date = $data->date;
        $reserve->time = $data->time;
        $reserve->description = $data->description;
        return $reserve->save();
    }
}