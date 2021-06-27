<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Client
 * 
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $phone
 * @property string $role
 * 
 * @property Collection|Commerce[] $commerces
 * @property Collection|Reserve[] $reserves
 *
 * @package App\Models
 */
class Client extends Model
{
	protected $table = 'client';
	public $timestamps = false;

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'name',
		'email',
		'password',
		'phone',
		'role'
	];

	public function commerces()
	{
		return $this->belongsToMany(Commerce::class, 'client_commerce', 'client_fk', 'commerce_fk')
					->withPivot('id');
	}

	public function reserves()
	{
		return $this->hasMany(Reserve::class);
	}
}
