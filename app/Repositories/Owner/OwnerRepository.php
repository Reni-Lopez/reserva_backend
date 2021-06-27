<?php
namespace App\Repositories\Owner;
use App\Models\Owner;
use Illuminate\Support\Facades\Crypt;

class OwnerRepository{
    
    protected $owner;

    public function __construct(Owner $owner){
        $this->owner = $owner;
    }
    public function getAllOwner(){
        return $this->owner->all();
    }
    public function getOwnerById( $id ){
        return $this->owner->find( $id );
    }
    public function createOwner( $data ){
        // $encriptedPassword = Crypt::encryptString($data->password);
        $Owner = new $this->owner;
        $Owner->name = $data->name;
        $Owner->email = $data->email;
        $Owner->password = bcrypt($data->password);
        $Owner->role = $data->role;
        return $Owner->save();
    }
    public function updateOwner( $data, $id ){
        $Owner = $this->owner->find( $id );
        $Owner->name = $data->name;
        $Owner->email = $data->email;
        $Owner->password = $data->password;
        $Owner->role = $data->role;
        return $Owner->update();
    }
    public function deleteOwner( $id ){
        $Owner = $this->owner->find( $id );
        return $Owner->delete();
    }
}