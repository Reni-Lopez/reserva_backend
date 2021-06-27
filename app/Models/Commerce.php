<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Commerce
 * 
 * @property int $id
 * @property int $owner_id
 * @property int $type_commerce
 * @property string $name
 * @property string $description
 * @property string $direction
 * @property string $closing
 * @property string $opening
 * 
 * @property Owner $owner
 * @property Collection|Client[] $clients
 * @property Collection|Reserve[] $reserves
 *
 * @package App\Models
 */
class Commerce extends Model
{
	protected $table = 'commerce';
	public $timestamps = false;

	protected $casts = [
		'owner_id' => 'int',
		'type_commerce' => 'int'
	];

	protected $fillable = [
		'owner_id',
		'type_commerce',
		'name',
		'description',
		'direction',
		'closing',
		'opening'
	];

	public function owner()
	{
		return $this->belongsTo(Owner::class);
	}

	public function type_commerce()
	{
		return $this->belongsTo(TypeCommerce::class, 'type_commerce');
	}

	public function clients()
	{
		return $this->belongsToMany(Client::class, 'client_commerce', 'commerce_fk', 'client_fk')
					->withPivot('id');
	}

	public function reserves()
	{
		return $this->hasMany(Reserve::class);
	}
}
