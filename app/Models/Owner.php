<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Owner
 * 
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $role
 * 
 * @property Collection|Commerce[] $commerces
 *
 * @package App\Models
 */
class Owner extends Model
{
	protected $table = 'owner';
	public $timestamps = false;

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'name',
		'email',
		'password',
		'role'
	];

	public function commerces()
	{
		return $this->hasMany(Commerce::class);
	}
}
