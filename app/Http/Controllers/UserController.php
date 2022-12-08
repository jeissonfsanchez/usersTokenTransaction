<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private UserRepositoryInterface $user;

    public function __construct(UserRepositoryInterface $user){
        $this->user = $user;
    }

    public function getUsers(Request $request)
    {
        /* Se recibe el token y el page del paginador */
        $fields['token'] = trim($request->route('token'));
        $fields['page'] = $request->page ?? 1;

        $validator = Validator::make($fields, [
            'token' => 'string|required|min:1',
            'page' => 'int|required|min:1'
        ]);

        if ($validator->fails()) {
            return $this->responseError($validator->errors());
        }

        $path = $request->segment(2);

        $perPage = 10;

        $users = $this->user->getUsers($fields);
    
        /* Al traer la data de la API se pasa a colección y se le genera un paginador para retornar la data a la vista */

        $users = collect($users['data']);

        $users = new LengthAwarePaginator($users->forPage($fields['page'], $perPage), $users->count(), $perPage, $fields['page'], ['path' => $path]);

        return view('users.index', compact('users'));
    }

    public function getUserTransaction(Request $request)
    {
        $fields['token'] = trim($request->route('token'));

        $fields['client_id'] = trim($request->route('client_id'));

        $validator = Validator::make($fields, [
            'token' => 'string|required|min:10',
            'client_id' => 'int|required|min:1'
        ]);

        if ($validator->fails()) {
            return $this->responseError($validator->errors());
        }
        
        /* Se toma todas las transacciones del cliente */

        $userTransaction = $this->user->getUserTransaction($fields);

        $userTransaction = $userTransaction['data'];

        return response()->json($userTransaction);

    }

    public function getAllUsers(Request $request){
        $validator = Validator::make($request->all(), [
            'search' => 'string|nullable|min:1'
        ]);

        if ($validator->fails()) {
            return $this->responseError($validator->errors());
        }

        $fields =  $validator->valid();
        
        /* Se valida si viene con algún filtro de búsqueda y se envía al repository */

        return $this->user->getAllUsers($fields);

    }

    private function responseError($result): JsonResponse
    {
        return response()->json([
            'result' => $result,
        ], 422);

    }
}
