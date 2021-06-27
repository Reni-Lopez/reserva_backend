<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Commerce\CommerceService;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Services\Commerce\TypeCommerceService;

class CommerceController extends Controller
{
    protected $type_commerce;
    protected $commerce;
    protected $user;

    public function __construct(TypeCommerceService $type_commerce,CommerceService $commerce){
        $this->type_commerce = $type_commerce;
        $this->commerce = $commerce;
        $this->middleware('auth:api', ['except' => ['getAllCommerce','getTypeCommerceById','getAllTypeCommerce',
            'getCommerceById','getCommerceByFk','createTypeCommerce','createCommerce','updateTypeCommerce',
            'updateCommerce','deleteTypeCommerce','deleteCommerce','getCommerce','getCommerceByOwner'
        ]]);
        $this->user = $this->guard()->user();
    }
    public function getAllCommerce(){
        $data = $this->commerce->getAllCommerce();
        $response = array(
            'status' => 'success',
            'code' => 200,
            'data' => $data
        );
        return response()->json($response, 200);
    }
    public function getCommerceByOwner( $id ){
        $result = ['status' => 200]; // setting initial status as OK

        try
        {
            $result ['data'] = $this->commerce->getCommerceByOwner($id);
            
            // if there is not info in the tables will send status code 204
            if( empty($result['data']) )
            {
                $result = ['status' => 204];
            }
        }
        catch(Exception $e) 
        { //in case than an error occours will trhrow an exception with code status 400
            $result = [
                'status' => 400,
                'error' => $e->getMessage()
            ];
        }
       
        return response()->json( $result, $result['status'] );

    }
    public function getTypeCommerceById( $id ){
        $data = $this->type_commerce->getTypeCommerceById($id);
        if (is_object($data)) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'data' => $data
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 404,
                'message' => 'resource not found'
            );
        }
        return response()->json($response,$response['code']);

    }
    public function getAllTypeCommerce(){
        $data = $this->type_commerce->getAllCommerce();
        $response = array(
            'status' => 'success',
            'code' => 200,
            'data' => $data
        );
        return response()->json($response, 200);
    }
    public function getCommerceById( $id ){
        $result = ['status' => 200];
        try {
            $result['data'] = $this->commerce->getCommerceById( $id );
        } 
        catch (Exception $e){
            $result = [
                'status' => 404,
                'error' => $e->getMessage()
            ];
        }
        return response()->json($result, $result['status']);
    }
    public function getCommerce($id){
        $result = ['status' => 200];
        try {
            $result['data'] = $this->commerce->getCommerce( $id );
        } 
        catch (Exception $e){
            $result = [
                'status' => 404,
                'error' => $e->getMessage()
            ];
        }
        return response()->json($result, $result['status']);
    }
    public function getCommerceByFk($id){
        $result = ['status' => 200];
        try {
            $result['data'] = $this->commerce->getCommerceByFk( $id );
        } 
        catch (Exception $e){
            $result = [
                'status' => 404,
                'error' => $e->getMessage()
            ];
        }
        return response()->json($result, $result['status']);
    }
    public function createTypeCommerce( Request $request ){
        $json = $request->input('json',null);
        try{
           $resp = $this->type_commerce->createTypeCommerce( $json );
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
    public function createCommerce( Request $request ){
        $json = $request->input('json',null);
        try{
           $resp = $this->commerce->createCommerce( $json );
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
    public function updateTypeCommerce(Request $request, $id){
        $json = $request->input('json',null);
        try{
            $resp = $this->type_commerce->updateTypeCommerce($json,$id);
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
    public function updateCommerce( Request $request, $id ){
        $json = $request->input('json',null);
        try{
            $resp = $this->commerce->updateCommerce($json,$id);
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
    public function deleteTypeCommerce( $id ){
        try {
            $this->type_commerce->deleteTypeCommerce($id);
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'deleted data'
            );
        } catch (Exception $e) {
            $response = [
                'status' => 'bad request',
                'code' => 404,
                'error' => $e->getMessage()
            ];
        }
        return response()->json($response, $response['code']);
    }
    public function deleteCommerce( $id ){
        try {
            $this->commerce->deleteCommerce( $id );
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'deleted data'
            );
        } catch (Exception $e) {
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
