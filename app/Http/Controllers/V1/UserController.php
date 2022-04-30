<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(int $id) {
        return [
            'response' => User::findOrFail($id)
        ];
    }


    public function searchByName(string $keyword) {
        return [
            'response' => User::where('name', 'like', '%' . $keyword . '%')->get()
        ];
    }
}
