<?php
namespace App\Services\Client;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\log;
use App\Repositories\Client\ClientRepository;

class ClientService{

    protected $client;

    public function __construct(ClientRepository $client){
        $this->client = $client;
    }
    public function getAllClient(){
        return $this->client->getAllClient();
    }
    public function getClientById( $id ){
        return $this->client->getClientById( $id );
    }
 
    public function createClient($json){
        $data = json_decode($json);
        $data_array = json_decode($json, true);
        $validate = Validator::make($data_array, [
            'name' => ['required'],
            'email' => ['required','unique:client,email'],
            'password' => ['required'],
            'phone' => ['required'],
        ]);
        if ($validate->fails()) {
            throw new InvalidArgumentException($validate->errors()->first());
        }
        return $this->client->createClient( $data );
    }
    
    public function createClientCommerce($json){
        $data = json_decode($json);
        $data_array = json_decode($json, true);
        $validate = Validator::make($data_array, [
            'client_fk' => ['required'],
            'commerce_fk' => ['required'],
        ]);
        if ($validate->fails()) {
            throw new InvalidArgumentException($validate->errors()->first());
        }
        return $this->client->createClientCommerce( $data );
    }
    public function updateClient($json, $id){   
        $data = json_decode($json);
        $data_array = json_decode($json, true);
        $validate = Validator::make($data_array, []);
        if ($validate->fails()) {
            throw new InvalidArgumentException($validate->errors()->first());
        }
        $result = $this->client->updateClient( $data, $id );
        return $result;
    }
    public function deleteClient($id){
        DB::beginTransaction();
        try{ 
            $result = $this->client->deleteClient($id);
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
