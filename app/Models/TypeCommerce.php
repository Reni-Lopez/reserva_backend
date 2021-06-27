<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TypeCommerce
 * 
 * @property int $id
 * @property string $type
 * 
 * @property Collection|Commerce[] $commerces
 *
 * @package App\Models
 */
class TypeCommerce extends Model
{
	protected $table = 'type_commerce';
	public $timestamps = false;

	protected $fillable = [
		'type'
	];

	public function commerces()
	{
		return $this->hasMany(Commerce::class, 'type_commerce');
	}
}
