<?php

namespace Gamota\Dashboard\Http\Controllers\Api;

use Illuminate\Http\Request;
use ApiController;
use Gamota\Dashboard\User;

class UserController extends ApiController
{
    public function index()
    {
        $filter = User::getRequestFilter();

        $res = User::distinct()
            ->applyFilter($filter)
            ->select('users.*')
            ->get();

        return response()->json($res, 200);
    }

    public function genApiToken()
    {
        return response()->json([
            'api_token' => str_random(60),
        ]);
    }
}
