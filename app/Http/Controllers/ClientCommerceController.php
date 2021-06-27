<?php

namespace App\Http\Controllers;

use App\Models\ClientCommerce;
use App\Services\ClientCommerce\ClientCommerceService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientCommerceController extends Controller
{
    protected $clientCommerce;
    protected $user;

    public function __construct(ClientCommerceService $clientCommerce){
        $this->clientCommerce = $clientCommerce;
        $this->middleware('auth:api', ['except' => [ 'getClientOfCommerce' ]]);
        $this->user = $this->guard()->user();
    }

    public function getClientOfCommerce( $id ){
        $data = $this->clientCommerce->getClientOfCommerce( $id );
        try {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'data' => $data
            );
        } catch (Exception $th) {
            $response = array(
                'status' => 'error',
                'code' => 404,
                'message' => 'resource not found'
            );
        }
        
        return response()->json($response,$response['code']);
    }

    protected function guard(){
        return Auth::guard();
    }


}

