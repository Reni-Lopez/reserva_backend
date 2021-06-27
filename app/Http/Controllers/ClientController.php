<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Services\Client\ClientService;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class ClientController extends Controller
{
    protected $client;
    protected $user;

    public function __construct(ClientService $client){
        $this->client = $client;
        $this->middleware('auth:api', ['except' => ['loginClient','getAllClient','getClientById','createClient',
            'updateClient','deleteClient','createClientCommerce'
        ]]);
        $this->user = $this->guard()->user();
    }
    public function getAllClient(){
        $data = $this->client->getAllClient();
        $response = array(
            'status' => 'success',
            'code' => 200,
            'data' => $data
        );
        return response()->json($response, 200);
    }
    public function getClientById( $id ){
        $data = $this->client->getClientById( $id );
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
    public function loginClient( Request $request ){
        $json = $request->input('json',null);
        $data = json_decode($json);
        $data_array = json_decode($json, true);
        $validate = Validator::make($data_array, [
            'email' => ['required'],
            'password' => ['required'],
        ]);
        if ($validate->fails()) {
            throw new InvalidArgumentException($validate->errors()->first());
        }
        
        $login = Client::where('email',$data->email)->first();
        $resp = Client::find($login->id);

        try{
            $response = array(
                'status' => 'success',
                'code' => 200,
                'data' => $resp
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
    protected function respondWithToken($token){
        return response()->json([
            'token' => $token,
            'token_validity' => $this->guard()->factory()->getTTL() * 60,
            'id' => $this->guard()->user()->id,
            'role' => $this->guard()->user()->role,
            'name' => $this->guard()->user()->name,
            'email' => $this->guard()->user()->email
        ]);
    }
    public function createClient( Request $request ){
        $json = $request->input('json',null);
        try{
            $resp = $this->client->createClient($json);
             $response = array(
                'status' => 'success',
                'code' => 201,
                'message' => 'saved data',
                'id' => $resp->id
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
    public function createClientCommerce( Request $request ){
        $json = $request->input('json',null);
        try{
           $resp = $this->client->createClientCommerce( $json );
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
    public function updateClient(Request $request, $id){
        $json = $request->input('json',null);
        try{
            $resp = $this->client->updateClient($json,$id);
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
    public function deleteClient( $id ){
        try {
            $this->client->deleteClient($id);
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
