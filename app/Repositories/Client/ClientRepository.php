<?php
namespace App\Repositories\Client;
use App\Models\Client;
use App\Models\ClientCommerce;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class ClientRepository{
    
    protected $client;
    protected $clientCommerce;

    public function __construct(Client $client,ClientCommerce $clientCommerce ){
        $this->client = $client;
        $this->clientCommerce = $clientCommerce;
    }
    public function getAllClient(){
        return DB::select('CALL getAllClients');
    }
    public function getClientById( $id ){
        return $this->client->find( $id );
    }
  
    public function createClient( $data ){
        //  ['password' => bcrypt($request->password)]
        // $encriptedPassword = Crypt::encryptString($data->password);
        // $client = new $this->client;
        // $client->name = $data->name;
        // $client->email = $data->email;
        // $client->password = $encriptedPassword;
        // $client->phone = $data->phone;
        // $client->role = $data->role;
        // return $client->save();
        $encriptedPassword  = bcrypt($data->password);
    //  = Crypt::encryptString($data->password);
        $client = new $this->client;

        $client->name = $data->name;
        $client->email = $data->email;
        $client->password = bcrypt($data->password);
        $client->phone = $data->phone;
        $client->role = $data->role;
        $client->save();
        return $client->fresh();
    }

    public function createClientCommerce( $data ){
        $clientCommerce = new $this->clientCommerce;
        $clientCommerce->client_fk = $data->client_fk;
        $clientCommerce->commerce_fk = $data->commerce_fk;
        $clientCommerce->save();
        return $clientCommerce;
    }

    public function updateClient( $data, $id ){
        $client = $this->client->find( $id );
        $client->name = $data->name;
        $client->email = $data->email;
        $client->password = bcrypt($data->password);
        $client->phone = $data->phone;
        $client->role = $data->role;
        return $client->update();
    }
    public function deleteClient( $id ){
        $client = $this->client->find( $id );
        return $client->delete();
    }

}