<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ClientCommerce
 * 
 * @property int $id
 * @property int $client_fk
 * @property int $commerce_fk
 * 
 * @property Client $client
 * @property Commerce $commerce
 *
 * @package App\Models
 */
class ClientCommerce extends Model
{
	protected $table = 'client_commerce';
	public $timestamps = false;

	protected $casts = [
		'client_fk' => 'int',
		'commerce_fk' => 'int'
	];

	protected $fillable = [
		'client_fk',
		'commerce_fk'
	];

	public function client()
	{
		return $this->belongsTo(Client::class, 'client_fk');
	}

	public function commerce()
	{
		return $this->belongsTo(Commerce::class, 'commerce_fk');
	}
}
