<?php
namespace App\Repositories\ClientCommerce;
use App\Models\ClientCommerce;
use Illuminate\Support\Facades\DB;

class ClientCommerceRepository{
    
    protected $clientCommerce;

    public function __construct(ClientCommerce $clientCommerce){
        $this->clientCommerce = $clientCommerce;
    }
    public function getClientOfCommerce( $id ){
        return DB::select('CALL getClientsOfCommerce(?)', array($id));
    }

}