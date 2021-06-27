<?php

use App\Http\Controllers\ClientCommerceController;
use App\Http\Controllers\ClientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommerceController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\ReserveController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login','AuthController@login');
    Route::post('/register', 'AuthController@register');
    Route::post('/refresh', 'AuthController@refresh');
    Route::get('/user-profile', 'AuthController@userProfile');  

    Route::post('/login/client','ClientController@loginClient');

    Route::post('/login/owner','OwnerController@loginOwner');
});

//Client
Route::get('/client', [ ClientController::class, 'getAllClient' ] );
Route::get('/client/{id}', [ ClientController::class, 'getClientById' ] );
Route::post('/client', [ ClientController::class, 'createClient' ] );
Route::post('/clientcommerce', [ ClientController::class, 'createClientCommerce' ] );
Route::match(['put', 'patch'],'/client/{id}', [ ClientController::class, 'updateClient' ] );
Route::delete('/client/{id}', [ ClientController::class, 'deleteClient' ] );

//Owner
Route::get('/owner', [ OwnerController::class, 'getAllOwner' ] );
Route::get('/owner/{id}', [ OwnerController::class, 'getOwnerById' ] );
Route::post('/owner', [ OwnerController::class, 'createOwner' ] );
Route::match(['put', 'patch'],'/owner/{id}', [ OwnerController::class, 'updateOwner' ] );
Route::delete('/owner/{id}', [ OwnerController::class, 'deleteOwner' ] );


//type commerce
Route::get('/typecommerce', [ CommerceController::class, 'getAllTypeCommerce' ] );
Route::get('/typecommerce/{id}', [ CommerceController::class, 'getTypeCommerceById' ] );
Route::post('/typecommerce', [ CommerceController::class, 'createTypeCommerce' ] );
Route::match(['put', 'patch'],'/typecommerce/{id}', [ CommerceController::class, 'updateTypeCommerce' ] );
Route::delete('/typecommerce/{id}', [ CommerceController::class, 'deleteTypeCommerce' ] );

//Commerce

Route::get('/getCommercebyowner/{id}',[ CommerceController::class, 'getCommerceByOwner' ] );
Route::get('/getcommerce/{id}',[ CommerceController::class, 'getCommerce' ] );
Route::get('/commerce',[ CommerceController::class, 'getAllCommerce' ] );
Route::get('/commerceId/{id}',[ CommerceController::class, 'getCommerceById' ] );
Route::get('/commerce/{id}',[ CommerceController::class, 'getCommerceByFk' ] );
Route::post('/commerce', [ CommerceController::class, 'createCommerce' ] );
Route::match(['put', 'patch'],'/commerce/{id}', [ CommerceController::class, 'updateCommerce' ] );
Route::delete('/commerce/{id}', [ CommerceController::class, 'deleteCommerce' ] );


Route::post('/reserve', [ ReserveController::class, 'createReserve' ] );
Route::match(['put', 'patch'],'/reserve/{id}', [ ReserveController::class, 'updateReserve' ] );
Route::get('/getReserveByIdOwner/{id}',[ ReserveController::class, 'getReserveByIdOwner' ] );
Route::get('/getReserveByIdClient/{id}',[ ReserveController::class, 'getReserveByIdClient' ] );

//CLIENTCOMMERCE
Route::get('/clients/{id}',[ ClientCommerceController ::class, 'getClientOfCommerce' ] );



