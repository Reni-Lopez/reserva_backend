<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Services\Reserve\ReserveService;

class ReserveController extends Controller
{
    protected $reserve;
    protected $user;

    public function __construct(ReserveService $reserve){
        $this->reserve = $reserve;
        $this->middleware('auth:api', ['except' => ['getReserveByIdClient','getReserveByIdOwner','createReserve','updateReserve']]);
        $this->user = $this->guard()->user();
    }

    public function getReserveByIdClient( $id ){
        $data = $this->reserve->getReserveByIdClient( $id );
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

    public function getReserveByIdOwner( $id ){
        $data = $this->reserve->getReserveByIdOwner( $id );
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

    public function createReserve( Request $request ){
        $json = $request->input('json',null);
        try{
           $resp = $this->reserve->createReserve( $json );
            $response = array(
                'status' => 'success',
                'code' => 201,
                'message' => 'saved data',
            );
        }
        catch(Exception $e){
            $response = [
                'status' => 'bad request',
                'code' => 404,
                'error' => $e->getMessage()
            ];
        }
        return response()->json($response, $response['code']);
    }
    public function updateReserve( Request $request, $id ){
        $json = $request->input('json',null);
        try{
            $resp = $this->reserve->updateReserve($json,$id);
            $response = array(
                'status' => 'success',
                'code' => 201,
                'message' => 'updated data',
                );
        }
        catch(Exception $e){
            $response = [
                'status' => 'bad request',
                'code' => 404,
                'error' => $e->getMessage()
            ];
        }
        return response()->json($response, $response['code']);
    }
    protected function guard(){
        return Auth::guard();
    }
}
