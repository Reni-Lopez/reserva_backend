<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Owner;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Services\Owner\OwnerService;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class OwnerController extends Controller
{
    protected $owner;
    protected $user;

    public function __construct(OwnerService $owner){
        $this->owner = $owner;
        $this->middleware('auth:api', ['except' => ['loginOwner','createOwner','getAllOwner','getOwnerById',
            'updateOwner','deleteOwner'
        ]]);
        $this->user = $this->guard()->user();
    }
    public function loginOwner( Request $request ){
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
        
        $login = Owner::where('email',$data->email)->first();
        $resp = Owner::find($login->id);

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

    public function getAllOwner(){
        $data = $this->owner->getAllOwner();
        $response = array(
            'status' => 'success',
            'code' => 200,
            'data' => $data
        );
        return response()->json($response, 200);
    }
    public function getOwnerById( $id ){
        $data = $this->owner->getOwnerById( $id );
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
    public function createOwner( Request $request ){
        $json = $request->input('json',null);
        try{
            $this->owner->createOwner( $json );
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
    public function updateOwner(Request $request, $id){
        $json = $request->input('json',null);
        try{
            $resp = $this->owner->updateOwner($json,$id);
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
    public function deleteOwner( $id ){
        try {
            $this->owner->deleteOwner($id);
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

