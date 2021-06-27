<?php
namespace App\Services\ClientCommerce;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\log;
use App\Repositories\ClientCommerce\ClientCommerceRepository;


class ClientCommerceService{
    
    protected $clientCommerce;

    public function __construct( ClientCommerceRepository $clientCommerce){
        return $this->clientCommerce = $clientCommerce;
    }

    public function getClientOfCommerce( $id ){
        return $this->clientCommerce->getClientOfCommerce( $id );
    }

   
}