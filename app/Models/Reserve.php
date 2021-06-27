<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Reserve
 * 
 * @property int $id
 * @property int $client_id
 * @property int $commerce_id
 * @property string $date
 * @property string|null $description
 * 
 * @property Client $client
 * @property Commerce $commerce
 *
 * @package App\Models
 */
class Reserve extends Model
{
	protected $table = 'reserve';
	public $timestamps = false;

	protected $casts = [
		'client_id' => 'int',
		'commerce_id' => 'int'
	];

	protected $fillable = [
		'client_id',
		'commerce_id',
		'date',
		'time',
		'description'
	];

	public function client()
	{
		return $this->belongsTo(Client::class);
	}

	public function commerce()
	{
		return $this->belongsTo(Commerce::class);
	}
}
