<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $messageSuccessDefault = 'Operacao realizada com sucesso';
    protected $messageErrorDefault = 'Ops';
    public const TYPE_SUCCESS = 'success';
    public const TYPE_ERROR = 'error';

    public function ok($items = [], int $status = Response::HTTP_OK)
    {
        $data = [
            'type'   => self::TYPE_SUCCESS,
            'status' => $status,
            'data'   => $items,
            'show'   => false,
        ];

        return response()->json($data, $status);
    }

    public function error(string $message = '', array $items = [], $status = Response::HTTP_UNPROCESSABLE_ENTITY)
    {
        if (is_null($message)) {
            $message = $this->messageErrorDefault;
        }

        $data = [
            'type'   => self::TYPE_ERROR,
           'status'  => $status,
           'message' => $message,
           'show'    => true,
        ];

        if ($items) {
            foreach($items as $key => $item) {
                $data['errors'][$key] = $item;
            }
        }

        return response()->json($data, $status);
    }

    public function success(string $message, array $items = [], int $status = Response::HTTP_OK)
    {
        if (is_null($message)) {
            $message = $this->messageSuccessDefault;
        }

        $data = [
            'type'   => self::TYPE_SUCCESS,
           'status'  => $status,
           'message' => $message,
           'show'    => true,
        ];

        if ($items instanceOf Arrayable) {
            $items = $items->toArray();
        }

        if ($items) {
            foreach($items as $key => $item) {
                $data[$key] = $item;
            }
        }

        return response()->json($data, $status);
    }

    public function getUserAuth()
    {
        return Auth::user();
    }

    public function hasPermissionTo($permission)
    {
        if (!Auth::user()->hasPermissionTo($permission)) {
            throw new UnauthorizedException(403, 'Voce nao tem permissao suficiente para realizar essa acao');
        }
    }
}
