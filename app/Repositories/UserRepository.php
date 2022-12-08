<?php

namespace App\Repositories;

use App\Helpers\ConectadosApi;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Log;


class UserRepository implements UserRepositoryInterface
{
    private $api;
    private $model;

    public function __construct(User $model,ConectadosApi $api)
    {
        $this->api = $api;
        $this->model = $model;
    }

    public function getUsers($params): array
    {
        /* Se usa una función privada dentro del repositorio ya que se llama más de uan vez al helper */
        
        $result = $this->getInformation($params);

        if (empty($result['data'])){
            $result['data'] = 'Sin información';
        }

        return $result;
    }

    public function getUserTransaction($params): array
    {
        /* Se usa una función privada dentro del repositorio ya que se llama más de uan vez al helper */
        
        $result = $this->getInformation($params);

        if (empty($result['data'])){
            $result['data'] = 'El usuario no tiene transacciones.';
        }

        return $result;
    }

    public function getAllUsers($params)
    {
        /* Una vez esté la data en la bd obtenida del API, se  puede realizar la consulta guardando el registro en el log indicando se tiene filtro o no*/
        
        Log::info('Se realizó la consulta '.(!empty($params['search']))? 'con filtro '.$params['search']: 'sin parámetro');
        return $this->model->when(isset($params['search']) && !empty($params['search']), function ($search) use($params){
                $search->where('name','like','%'.$params['search'].'%')
                    ->orWhere('email','like','%'.$params['search'].'%');
            })
            ->with('transaction')
            ->paginate(5);
    }

    private function getInformation($params): array
    {
        /* Se llama al helper para evitar repetir el código */
        
        return $this->api->getRequest($params);

    }
}
